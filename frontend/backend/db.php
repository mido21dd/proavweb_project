<?php
$conn = mysqli_connect("localhost", "root", "", "order"); 

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}
?>
