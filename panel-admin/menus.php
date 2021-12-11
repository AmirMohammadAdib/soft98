<?php 
include "../database/db.php";
include "header.php"; 

$number = 1;

if(isset($_POST['sub'])){
  $title = $_POST['title'];
  $src = $_POST['src'];
  $sort = $_POST['sort'];


  $add_menu = $conn->prepare('INSERT INTO menus SET title=? , src=? , sort=?');
  $add_menu->bindValue(1, $title);
  $add_menu->bindValue(2, $src);
  $add_menu->bindValue(3, $sort);

  $add_menu->execute();
}

$menus = $conn->prepare('SELECT * FROM menus ORDER BY sort');
$menus->execute();
$menus = $menus->fetchAll(PDO::FETCH_ASSOC);


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
                                <a href="menus.php" class="nav-link active">
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
                                <a href="users.php" class="nav-link">
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
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;">منو</h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <form method="POST">
        <input type="text" name="title" class="form-control" placeholder="عنوان منو"><br>
        <input type="text" name="src" class="form-control" placeholder="لینک منو"><br>
        <input type="text" name="sort" class="form-control" placeholder="ترازبندی منو"><br>
        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ثبت منو" name="sub" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">لینک</th>
                <th scope="col">ترازبندی</th>
                <th scope="col">حذف، ویرایش</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($menus as $menu){ ?>
            <tr>
                <th scope="row"><?= $number++; ?></th>
                <td><?= $menu['title'] ?></td>
                <td><?= $menu['src'] ?></td>
                <td><?= $menu['sort'] ?></td>
                <td>
                    <a href="pages/editmenu.php?id=<?= $menu['id']; ?>"><input type="submit" value="ویرایش"
                            class="btn btn-warning"></a>
                    <input type="submit" value="حذف" class="btn btn-danger">
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>



<?php include "footer.php"; ?>