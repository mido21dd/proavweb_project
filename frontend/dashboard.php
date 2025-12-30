
<?php
include "db.php";

$total = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders")
)['c'];

$pending = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders WHERE status='pending'")
)['c'];

$approved = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders WHERE status='approved'")
)['c'];
$rejected = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders WHERE status='rejected'")
)['c'];

?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - نظام إدارة الطلبات</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header class="navbar">
    <div class="right">
        
        <span class="logo-box">P</span>
        <span class="logo-text">نظام إدارة الطلبات</span>
    </div>
    <nav class="center">
        <a href="index.php" class="nav-item active">الرئيسية</a>
    </nav>
    
    <button class="btn-primary" onclick="openAddModal()">➕ إضافة طلب جديد</button>
</header>

<section class="page-header">

    <div>
        <h1>لوحة التحكم</h1>
        <p>    عدد طلبات الاجمالي في موقع !!!</p>
    </div>
    

    <!-- Stats Cards -->
<section class="stats">

    <div class="card">
        <div class="icon green">✔</div>
        <div>
            <span>المقبولة</span>
            <h2><?= $approved ?></h2>
        </div>
    </div>

    <div class="card">
        <div class="icon orange">⟳</div>
        <div>
            <span>قيد الانتظار</span>
            <h2><?= $pending ?></h2>
        </div>
    </div>


<div class="card">
    <div class="icon red">✖</div>
    <div>
        <span>المرفوضة</span>
        <h2><?= $rejected ?></h2>
    </div>
</div>




    <div class="card">
        <div class="icon blue">📄</div>
        <div>
            <span>إجمالي الطلبات</span>
            <h2><?= $total ?></h2>
        </div>
        
    </div>

</section>


</section>

<?php
include "db.php";
session_start();

$admin= isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;

if (isset($admin)) {


$sql = "SELECT * FROM orders WHERE admin_id = '$admin'";
$result = mysqli_query($conn, $sql);
}
else{
    $result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
}


?>

<section class="table-container">

<section class="filters">
    <input type="text" id="filterName" placeholder="بحث باسم صاحب الطلب...">
    <select id="filterType">
        <option value="">الكل</option>
        <option value="طلب توصيل">طلب توصيل</option>
        <option value="طلب شراء">طلب شراء</option>
        <option value="طلب خدمة">طلب خدمة</option>
    </select>
</section>

<table>
    <thead>
        <tr>
            <th>الاسم</th>
            <th>النوع</th>
            <th>التفاصيل</th>
            <th>تاريخ الطلب</th>
            <th> الحالة</th>
        </tr>
    </thead>
    <tbody id="ordersTable">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr id="row-<?= $row['id'] ?>">
            <td><?= $row['name'] ?></td>
            <td><?= $row['type'] ?></td>
            <td><?= $row['details'] ?></td>
            <td><?= $row['created_at'] ?></td>

            <td>
          <div clase="stastyl"><?= $row['status'] ?></td>
 

<td>
<?php if(isset($_SESSION['admin_id'])): ?>
    <div class="dropdown">
        <div class="dropdown-content">
            <a href="#" class="edit-btn" data-id="<?= $row['id'] ?>">تعديل</a><br>
            <a href="#" class="delete-btn" data-id="<?= $row['id'] ?>">حذف</a>
        </div>
    </div>
<?php endif; ?>
</td>


            
        </tr>
      <?php } ?> 
    </tbody>
</table>

</section>

<div id="addOrderModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>إضافة طلب جديد</h2>
      <span class="close" onclick="closeAddModal()">×</span>
    </div>
    <form id="addOrderForm">
        <label>اسم صاحب الطلب</label>
        <input type="text" name="name" required>

        <label>نوع الطلب</label>
        <select name="type" required>
            <option value="">اختر نوع الطلب</option>
            <option value="طلب توصيل">طلب توصيل</option>
            <option value="طلب شراء">طلب شراء</option>
            <option value="طلب خدمة">طلب خدمة</option>
        </select>
<label>اختيار Admin</label>
<select name="admin_id" required>
  <?php
  $admins = mysqli_query($conn,"SELECT * FROM admins");
  while($a = mysqli_fetch_assoc($admins)){
      echo "<option value='{$a['id']}'>{$a['username']}</option>";
  }
  ?>
</select>

        <label>التفاصيل</label>
        <textarea name="details"></textarea>

        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closeAddModal()">إلغاء</button>
            <button type="submit" class="btn-primary">حفظ</button>
        </div>
    </form>
  </div>
</div>


<div id="editOrderModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>تعديل الطلب</h2>
      <span class="close" onclick="closeEditModal()">×</span>
    </div>
    <form id="editOrderForm">
        <input type="hidden" name="id">
        <label>اسم صاحب الطلب</label>
        <input type="text" name="name" required>

        <label>نوع الطلب</label>
        <select name="type" required>
            <option value="">اختر نوع الطلب</option>
            <option value="طلب توصيل">طلب توصيل</option>
            <option value="طلب شراء">طلب شراء</option>
            <option value="طلب خدمة">طلب خدمة</option>
        </select>
        <label>الحالة</label>
        <select name="status" required>
            <option value="">اختر  الحالة</option>
            <option value="pending">قيد الانتظار </option>
            <option value="approved">قبول </option>
            <option value="rejected">رفض </option>
        </select>

        <label>التفاصيل</label>
        <textarea name="details"></textarea>

        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closeEditModal()">إلغاء</button>
            <button type="submit" class="btn-primary">حفظ التعديلات</button>
        </div>
    </form>
  </div>
</div>

<script>

function openAddModal(){ $("#addOrderModal").show(); }
function closeAddModal(){ $("#addOrderModal").hide(); $("#addOrderForm")[0].reset(); }

function openEditModal(){ $("#editOrderModal").show(); }
function closeEditModal(){ $("#editOrderModal").hide(); $("#editOrderForm")[0].reset(); }

//add 
$("#addOrderForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "add_order.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(){
            alert("تمت الإضافة بنجاح!");
              location.reload();
            closeAddModal();
          
        },
        error: function(){ alert("حدث خطأ أثناء الإضافة."); }
    });
});
//edit
$(document).on("click", ".edit-btn", function(e){
    e.preventDefault();
    let id = $(this).data("id");
    $.ajax({
        url: "get_order.php",
        type: "GET",
        data: {id: id},
        dataType: "json",
        success: function(data){
            openEditModal();
            $("#editOrderForm input[name='id']").val(data.id);
            $("#editOrderForm input[name='name']").val(data.name);
            $("#editOrderForm select[name='type']").val(data.type);
            $("#editOrderForm textarea[name='details']").val(data.details);

        }
    });
});
//save edit
$("#editOrderForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "edit_order.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(){
            alert("تم تعديل الطلب بنجاح!");
            closeEditModal();
            location.reload();
        },
        error: function(){ alert("حدث خطأ أثناء التعديل."); }
    });
});

// delet
$(document).on("click", ".delete-btn", function(e){
    e.preventDefault();
    if(confirm("هل أنت متأكد من حذف هذا الطلب؟")){
        let id = $(this).data("id");
        $.ajax({
            url: "delete_order.php",
            type: "POST",
            data: {id: id},
            success: function(){
                alert("تم حذف الطلب بنجاح!");
                $("#row-" + id).remove();
                            location.reload();

            },
            error: function(){ alert("حدث خطأ أثناء الحذف."); }
        });
    }
});
//filter
function filterOrders() {
    let name = $("#filterName").val();
    let type = $("#filterType").val();

    $.ajax({
        url: "filter_orders.php",
        type: "POST",
        data: {name: name, type: type},
        success: function(data){
            $("#ordersTable").html(data);
        }
    });
}

$("#filterName").on("keyup", filterOrders);
$("#filterType").on("change", filterOrders);

</script>

</body>
</html>
