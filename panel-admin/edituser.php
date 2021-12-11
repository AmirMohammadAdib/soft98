<?php 
include "../database/db.php";
include "header.php";

$id = $_GET['id'];
$success = null;


if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $userlevel = $_POST['userlevel'];
    $golduser = $_POST['golduser'];

    $add_user = $conn->prepare('UPDATE users SET username=? , email=? , pass=? , userlevel=? , golduser=? WHERE id=?');
    $add_user->bindValue(1, $username);
    $add_user->bindValue(2, $email);
    $add_user->bindValue(3, $pass);
    $add_user->bindValue(4, $userlevel);
    $add_user->bindValue(5, $golduser);
    $add_user->bindValue(6, $id);

    $add_user->execute();
    $success = true;
    
}

$users = $conn->prepare('SELECT * FROM users WHERE id=?');
$users->bindValue(1, $id);
$users->execute();
$users = $users->fetch(PDO::FETCH_ASSOC);

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g"
                        class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">حسام موسوی</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                صفحه اصلی
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="menus.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>منو ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="logo.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لوگو</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="slider.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>اسلایدر</p>
                                </a>
                            </li>
                        </ul>

                        <!-- user -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                کاربران
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="users.php" class="nav-link active">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>تمام کاربران</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="golduser.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>کاربران ویژه</p>
                                </a>
                            </li>
                        </ul>
                        <!-- courses -->
                        <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                دوره
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add_course.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن دوره</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="add_course.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>فروش رفته</p>
                                </a>
                            </li>
                        </ul>
                                                <!-- blog -->
                                                <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                وبلاگ
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add_blog.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن بلاگ</p>
                                </a>
                            </li>
                        </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>

<div>
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;">افزودن کاربر</h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <form method="POST">
        <label>نام کاربری</label>
        <input type="text" name="username" class="form-control" placeholder="نام کاربری"
            value="<?= $users['username'] ?>"><br>
        <label>ایمیل</label>
        <input type="text" name="email" class="form-control" placeholder="ایمیل" value="<?= $users['email'] ?>"><br>
        <label>رمز عبور</label>
        <input type="text" name="pass" class="form-control" placeholder="رمز عبور" value="<?= $users['pass'] ?>"><br>

        <label>سطح کاربری</label><br>
        <input type="radio" name="userlevel" value="0" <?php if($users['userlevel'] == 0){ ?> checked <?php } ?>>
        <label style="font-weight: 500; font-size: 15px;">کاربر عادی</label><br>
        <input type="radio" name="userlevel" value="1" <?php if($users['userlevel'] == 1){ ?> checked <?php } ?>>
        <label style="font-weight: 500; font-size: 15px;">ادمین</label><br><br>

        <label>کاربر ویژه</label><br>
        <input type="radio" name="golduser" value="0" <?php if($users['golduser'] == 0){ ?> checked <?php } ?>>
        <label style="font-weight: 500; font-size: 15px;">کاربر عادی</label><br>
        <input type="radio" name="golduser" value="1" <?php if($users['golduser'] == 1){ ?> checked <?php } ?>>
        <label style="font-weight: 500; font-size: 15px;">طلایی</label>


        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ویرایش کاربر" name="register" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
</div>


<?php include "footer.php" ?>

<?php if($success){ ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

Toast.fire({
    icon: 'success',
    title: 'ویرایش با موفقیت انجام شد'
})
</script>
<?php } ?>