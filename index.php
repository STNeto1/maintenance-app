<?php

include "includes/header.php";

session_start();
session_regenerate_id();

if (!$_SESSION['logged_in']) {
  header('location: login.php?status=auth-required');
}

include "includes/footer.php"; ?>

<h1>Home</h1>
