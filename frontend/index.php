 <?php
session_start();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة الطلبات</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

<!-- Navbar -->
<header class="navbar">
    <div class="logo">
        <span class="logo-box">P</span>
        <span>نظام إدارة الطلبات</span>
    </div>

    <nav>
        
       <button class="btn-primary" onclick="openAuthModal()">Admin</button>
    </nav>

</header>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-text">
        <span class="badge">نظام إدارة متكامل</span>

        <h1>
            نظّم طلباتك <br>
            <span>بكل سهولة واحترافية</span>
        </h1>

        <p>
            منصة مركزية لإدارة جميع أنواع الطلبات، سواء كانت طلبات شراء،
            مشتريات، أو خدمات. تخلص من الورق والفوضى الآن.
        </p>

        <div class="buttons">
            <a href="dashboard.php"class="btn primary">لوحة  التحكم </a> 
            <button class="btn outline">اعرف المزيد</button>
        </div>
    </div>

    <div class="hero-image">
        <div class="shapes"></div>
    </div>
</section>






<footer class="footer">
    <div class="footer-content">
        <div class="footer-logo">
            <span class="logo-box">P</span>
            <span>نظام إدارة الطلبات</span>
        </div>
        <p>© 2026 جميع الحقوق محفوظة</p>
        <div class="footer-links">
            <a href="#">الشروط والأحكام</a>
            <a href="#">الخصوصية</a>
            <a href="#">اتصل بنا</a>
        </div>
    </div>
</footer>




<!-- Auth Modal -->
<div id="authModal" class="modal">
  <div class="modal-content">

    <div class="modal-header">
      <h2 id="authTitle">تسجيل الدخول</h2>
      <span class="close" onclick="closeAuthModal()">×</span>
    </div>

    <!-- Login Form -->
    <form id="loginForm">
      <label>اسم Admin</label>
      <input type="text" name="username" required>

      <label>كلمة المرور</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn-primary">Login</button>
      <button class="btn-outline" onclick="switchToRegister()">
      Register Admin
    </button>
    </form>

    <hr>
 

    <!-- Register Button -->
    

    <!-- Register Form -->
    <form id="registerForm" style="display:none;">
        <button class="btn-outline" onclick="switchTologin()">
      login
    </button>
      <label>اسم Admin</label>
      <input type="text" name="username" required>

      <label>كلمة المرور</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn-primary">Register</button>
    </form>

<form id="logoutForm" style="display:none;">
    
  <button type="submit" class="btn-danger">Logout</button>
</form>

  </div>
</div>
<script>
function openAuthModal(){
    document.getElementById("authModal").style.display = "block";
}
function closeAuthModal(){
    document.getElementById("authModal").style.display = "none";
}

function switchToRegister(){
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerForm").style.display = "block";
    document.getElementById("authTitle").innerText = "تسجيل Admin جديد";
}

function switchTologin(){
    document.getElementById("registerForm").style.display = "none";
    document.getElementById("loginForm").style.display = "block";
    document.getElementById("authTitle").innerText = "تسجيل الدخول ";
}

$("#loginForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "login_admin.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(){
              location.reload();
closeAuthModal();          
        },
        error: function(){ alert("حدث خطأ أثناء الإضافة."); }
    });
});


$("#registerForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "register_admin.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(){
              location.reload();
closeAuthModal();          
        },
        error: function(){ alert("حدث خطأ أثناء الإضافة."); }
    });
});

$("#logoutForm").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "logout_admin.php",
        type: "POST",
        success: function(){
            location.reload();
        }
    });
});








</script>

<script>
let isLoggedIn = <?php echo isset($_SESSION['admin_id']) ? 'true' : 'false'; ?>;

if(isLoggedIn){
    $("#loginForm").hide();
    $("#registerForm").hide();
    $("#logoutForm").show();
    $("#authTitle").text("");
}else{
    $("#loginForm").show();
    $("#logoutForm").hide();
}
</script>

</body>

</html>
