<?php
session_start();


include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$q = mysqli_query($conn,"SELECT * FROM admins WHERE username='$username'");
$admin = mysqli_fetch_assoc($q);

if($admin && password_verify($password,$admin['password'])){
    $_SESSION['admin_id'] = $admin['id'];
    echo "ok";
}else{
    echo "error";
}
