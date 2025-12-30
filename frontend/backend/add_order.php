<?php
include "db.php";

$name = mysqli_real_escape_string($conn, $_POST['name']);
$type = mysqli_real_escape_string($conn, $_POST['type']);
$details = mysqli_real_escape_string($conn, $_POST['details']);
$admin_id = $_POST['admin_id'];


$sql = "INSERT INTO orders (name, type, details, status,admin_id) 
        VALUES ('$name', '$type', '$details','pending',$admin_id)";

if(mysqli_query($conn, $sql)){
   
    exit;
} else {
    echo "خطأ: " . mysqli_error($conn);
}
?>