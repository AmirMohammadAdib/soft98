<?php 
include "../database/db.php";
include "header.php";

$number = 1;

$error_pass = null;
$error_user = null;
$error_fild = null;
$success = null;


if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $rpass = $_POST['retry_pass'];

    $user = $conn->prepare('SELECT * FROM users WHERE email=?');
    $user->bindValue(1, $email);
    $user->execute();

    if(!empty($_POST['email']) & !empty($_POST['username']) & !empty($_POST['pass']) & !empty($_POST['retry_pass'])){
        if($user->rowCount() <= 0){
            if($pass == $rpass){
                $add_user = $conn->prepare('INSERT INTO users SET username=? , email=? , pass=? ');
                $add_user->bindValue(1, $username);
                $add_user->bindValue(2, $email);
                $add_user->bindValue(3, $pass);
            
                $add_user->execute();
                $success = true;

                $_SESSION['login'] = true;
                $_SESSION['name'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
            }else{
                $error_pass = true;
            }
        }else{
            $error_user = true;
        }
    }else{
        $error_fild = true;
    }
}

$users = $conn->prepare('SELECT * FROM users');
$users->execute();
$users = $users->fetchAll(PDO::FETCH_ASSOC);

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
        <input type="text" name="username" class="form-control" placeholder="نام کاربری"><br>
        <input type="text" name="email" class="form-control" placeholder="ایمیل"><br>
        <input type="text" name="pass" class="form-control" placeholder="رمز عبور"><br>
        <input type="text" name="retry_pass" class="form-control" placeholder="تکرار رمز عبور"><br>

        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ثبت کاربر" name="register" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
    <table class="table table-light table-hover"
        style="border: 1px solid #6e7871; border-radius: 5px; box-shadow: 0px 0px 4px #6e7871">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام کاربری</th>
                <th scope="col">ایمیل</th>
                <th scope="col">رمز عبور</th>
                <th scope="col">سطح کاربری</th>
                <th scope="col">حساب ویژه</th>
                <th scope="col">حذف، ویرایش</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user){ ?>
            <tr>
                <th scope="row"><?= $number++; ?></th>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['pass'] ?></td>
                <td><?php if($user['userlevel'] == 0){echo "کاربر عادی";}else{echo "ادمین";} ?></td>
                <td><?php if($user['golduser'] == 0){echo "حساب عادی";}else{echo "حساب ویژه";} ?></td>
                <td>
                    <a href="edituser.php?id=<?= $user['id']; ?>"><input type="submit" value="ویرایش"
                            class="btn btn-warning"></a>
                    <a href="deleteuser.php?id=<?= $user['id']; ?>"><input type="submit" value="حذف"
                            class="btn btn-danger"></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include "footer.php" ?>
<?php if($error_pass){ ?>
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
    icon: 'error',
    title: 'رمز عبور باهم یکسان نیست'
})
</script>
<?php } ?>
<?php if($error_user){ ?>
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
    icon: 'error',
    title: 'کاربری با همچین مشخصاتی وجود داره'
})
</script>
<?php } ?>
<?php if($error_fild){ ?>
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
    icon: 'error',
    title: 'فیلد های مشخص شده رو کامل کنید'
})
</script>
<?php } ?>
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
    title: 'حساب با موفقیت ساخته شد'
})
</script>
<?php } ?>