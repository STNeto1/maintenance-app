<?php

require_once "classes/User.php";

$obUser = new User();

if (isset($_POST['type'])) {
  if ($_POST['type'] == 'login') {
    if (isset($_POST['username'], $_POST['password'])) {
      // check if user exists
      $user = $obUser->findUserByUsername($_POST['username']);

      if ($user) {
        if (password_verify($user['password'], $_POST['password'])) {
          session_regenerate_id();
          $_SESSION['logged_in'] = TRUE;
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['role'] = $user['role'];
          header('location: index.php?status=login');
        } else {
          header('location login.php?status=bad-auth');
        }
      } else {
        header('location login.php?status=not-found');
      }
    }
  }

  if ($_POST['type'] == 'register') {
    if (isset($_POST['name'], $_POST['username'], $_POST['password'])) {
      $user = $obUser->findUserByUsername($_POST['username']);

      if (!$user) {
        $newUser = $obUser->insert($_POST['name'], $_POST['username'], $_POST['password']);

        session_regenerate_id();
        $_SESSION['logged_in'] = TRUE;
        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['role'] = $newUser['role'];
        header('location: index.php?status=login');
      } else {
        header('location login.php?status=already');
      }
    }
  }
} else {
  header('location login.php?status=invalid');
}