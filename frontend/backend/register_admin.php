<?php
include "db.php";

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($conn,
  "INSERT INTO admins (username,password)
   VALUES ('$username','$password')"
);

echo "ok";
