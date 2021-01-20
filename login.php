<?php

session_start();
session_regenerate_id();
if ($_SESSION['logged_in']) {
  header('location: index.php');
}

include "includes/header.php";

?>

<div class="container m-5">
  <?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == "invalid"): ?>
          <div class="alert alert-danger">
              <strong>Invalid Request</strong>
          </div>
    <?php elseif ($_GET['status'] == "auth-required") : ?>
          <div class="alert alert-danger">
              <strong>You have to login or register to access the home</strong>
          </div>
    <?php endif; ?>
  <?php endif; ?>

    <div class="row">
        <div class="col">
            <h2 class="mb-3">Login</h2>

          <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == "not-found"): ?>
                  <div class="alert alert-danger">
                      <strong>User not found</strong>
                  </div>
            <?php elseif ($_GET['status'] == "bad-auth"): ?>
                  <div class="alert alert-danger">
                      <strong>Invalid credentials</strong>
                  </div>
            <?php endif; ?>
          <?php endif; ?>

            <form action="loginOrRegister.php" method="post">

                <input type="hidden" name="type" value="login">

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Your username"
                           required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Your password" required minlength="6">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col">
            <h2 class="mb-3">Register</h2>

          <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == "already"): ?>
                  <div class="alert alert-danger">
                      <strong>User already registered</strong>
                  </div>
            <?php endif; ?>
          <?php endif; ?>

            <form action="loginOrRegister.php" method="post">

                <input type="hidden" name="type" value="register">

                <div class="mb-3">
                    <label for="username" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your name" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Your username"
                           required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Your password" required minlength="6">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php

include "includes/footer.php";

?>
