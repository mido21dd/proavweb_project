<?php
include "db.php";
if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $type = mysqli_real_escape_string($conn,$_POST['type']);
    $details = mysqli_real_escape_string($conn,$_POST['details']);
    $status=mysqli_real_escape_string($conn,$_POST['status']);
    mysqli_query($conn,"UPDATE orders SET name='$name',status='$status', type='$type', details='$details' WHERE id=$id");
}
?>
