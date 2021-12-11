<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";

$number = 1;
$id = $_GET['id'];
$success = null;
$error_size = null;
$error_format = null;

$course = $conn->prepare('SELECT * FROM course WHERE id=?');
$course->bindValue(1, $id);
$course->execute();
$course = $course->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['sub'])){
    $title = $_POST['title'];
    $time = $_POST['time'];

    //uploader//
    $target_dir = "../video/part-course/";
    $new_name = rand(1000, 100000) . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $new_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 350000000) {
        $error_size = true;
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "mp4"
    ) {
        $error_format = true;
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($new_name)) . " has been uploaded.";
            $add_part = $conn->prepare('INSERT INTO parts SET user=? , course=? , name=? , video=? , time=? , date=?');
            $add_part->bindValue(1, $_SESSION['email']);
            $add_part->bindValue(2, $id);
            $add_part->bindValue(3, $title);
            $add_part->bindValue(4, $new_name);
            $add_part->bindValue(5, $time);
            $add_part->bindValue(6, time());
        
            $add_part->execute();
            $success = true;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$parts = $conn->prepare('SELECT * FROM parts WHERE course=?');
$parts->bindValue(1, $id);
$parts->execute();
$parts = $parts->fetchAll(PDO::FETCH_ASSOC);

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
                                <a href="add_course.php" class="nav-link active">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن دوره</p>
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
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;"><?= $course['title'] ?></h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <form method="POST" enctype="multipart/form-data">
        <label>آپلود قسمت ویدئو</label>
        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload"><br>
        <label>عنوان قسمت</label>
        <input type="text" name="title" class="form-control" placeholder="عنوان قسمت دوره"><br>
        <label>(دقیقه)مدت زمان دوره (مثال : 45)</label>
        <input type="text" name="time" class="form-control" placeholder="مدت زمان قسمت (مثال : 45)"><br>
        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ثبت قسمت" name="sub" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">زمان</th>
                <th scope="col">تایم</th>
                <th scope="col">حذف، ویرایش</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($parts as $part){ ?>
            <tr>
                <th scope="row"><?= $number++; ?></th>
                <td><?= $part['name'] ?></td>
                <td><?= $part['time'] . " دقیقه "?></td>
                <td><?= jdate('j / n / Y', $part['date']) ?></td>
                
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
    title: 'قسمت دوره با موفقیت اضافه شد'
})
</script>
<?php } ?>

<?php if($error_size){ ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

Toast.fire({
    icon: 'error',
    title: 'حداکثر سایز ویدئو برای آپلود 350 مگابایته'
})
</script>
<?php } ?>

<?php if($error_format){ ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

Toast.fire({
    icon: 'error',
    title: 'برای آپلود ویدئو فقط فرمت mp4 پشتیبانی میشود'
})
</script>
<?php } ?>