

<?php
include "db.php";

$name = isset($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '';
$type = isset($_POST['type']) ? mysqli_real_escape_string($conn,$_POST['type']) : '';

$sql = "SELECT * FROM orders WHERE 1=1";

if($name != ''){
    $sql .= " AND name LIKE '%$name%'";
}

if($type != ''){
    $sql .= " AND type='$type'";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
    echo '<tr id="row-'.$row['id'].'">
            <td>'.$row['name'].'</td>
            <td>'.$row['type'].'</td>
            <td>'.$row['details'].'</td>
            <td>'.$row['created_at'].'</td>
            <td>'.$row['status'].'</td>
            <td>';
    echo '</td>
            <td>
                <div class="dropdown">
                    <div class="dropdown-content">
                        <a href="#" class="edit-btn" data-id="'.$row['id'].'">تعديل</a>
                        <a href="#" class="delete-btn" data-id="'.$row['id'].'">حذف</a>
                    </div>
                </div>
            </td>
          </tr>';
}
?>
