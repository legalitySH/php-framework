<?php

declare(strict_types=1);

?>


<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./../../styles/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Users CRUD</title>
</head>
<body>
<h1 class="header">Users CRUD</h1>
<table id="users-table">
    <tr>
        <th>Id</th>
        <th>Login</th>
        <th>Registration date</th>
    </tr>
</table>

<form id="remove-form" method="post">
    <p class="operations-text">Delete:
        <input class="operations-input" placeholder="id" type="text" name="id">
        <button class="submit-btn remove" id="remove-btn">Remove</button>
    </p>
</form>

<form id="insert-form" method="post">
    <p class="operations-text">Insert:
        <input class="operations-input" placeholder="login" type="text" name="login">
        <button class="submit-btn insert" id="remove-btn">Add</button>
    </p>
</form>

<script src="./../../script/usersAjax.js"></script>
<script>
    loadUsers();
</script>
</body>

</html>