<?php
include "db.php";
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $res = mysqli_query($conn,"SELECT * FROM orders WHERE id=$id");
    echo json_encode(mysqli_fetch_assoc($res));
}
?>
