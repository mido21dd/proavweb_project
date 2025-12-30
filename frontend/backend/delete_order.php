<?php
include "db.php";
if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    mysqli_query($conn,"DELETE FROM orders WHERE id=$id");
}
?>
