<?php

include "includes/header.php";
include "classes/User.php";
include "classes/Request.php";

session_start();
session_regenerate_id();

if (!$_SESSION['logged_in']) {
  header('location: login.php?status=auth-required');
}

$obUser = new User();
$obRequest = new Request();

$requests = $obRequest->findAll();

?>

<div class="container m-5">

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Name</th>
            <th>Manager</th>
            <th>Finished</th>
            <th>Created At</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($requests

                       as $req): ?>
            <tr>
                <td><?= $req['id'] ?> </td>
                <td><?= $req['title'] ?> </td>
                <td><?= $req['name'] ?> </td>
                <td><?= $req['manager'] ?> </td>
                <td>
                  <?= $req['finished'] ? "Yes" : "No" ?>
                </td>
                <td>
                  <?= $req['createdAt'] ?>
                </td>
                <td>
                  <?= !$req['finished'] ?
                    "<a href='#' class='btn btn-success'>Finish</a>"
                    : "<button class='btn' disabled>Finish</button>"
                  ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</div>


<?php include "includes/footer.php"; ?>

