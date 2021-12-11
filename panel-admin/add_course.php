<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";


$number = 1;
$success = null;
$error_format = null;
$error_size = null;
$error_format_video = null;

$admin = $conn->prepare('SELECT username , id FROM users WHERE userlevel=1');
$admin->execute();
$admin = $admin->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['sub'])){
    $title = $_POST['title'];
    $caption = $_POST['caption'];
    $status = $_POST['status'];
    $teacher = $_POST['teacher'];
    $level = $_POST['level'];
    $price = $_POST['value'];

    
        //uploader//
        $target_dir = "../image/poster-course/";
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
        if ($_FILES["fileToUpload"]["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
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
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        //uploader//
        $target_dir = "../video/introduction_course/";
        $add_video = rand(1000, 100000) . basename($_FILES["fileToUpload2"]["name"]);
        $target_file = $target_dir . $add_video;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
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
        if ($_FILES["fileToUpload2"]["size"] > 350000000) {
            $error_size = true;
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        if (
            $imageFileType != "mp4"
        ) {
            $error_format_video = true;
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($add_video)) . " has been uploaded.";
                $add_course = $conn->prepare('INSERT INTO course SET title=? , date=? , teacher=? , parts=? , cation=? , course_level=? , status_course=? , price=? , poster=? , introduction_video=?');
                $add_course->bindValue(1, $title);
                $add_course->bindValue(2, time());
                $add_course->bindValue(3, $teacher);
                $add_course->bindValue(4, 68);
                $add_course->bindValue(5, $caption);
                $add_course->bindValue(6, $level);
                $add_course->bindValue(7, $status);
                $add_course->bindValue(8, $price);
                $add_course->bindValue(9, $new_name);
                $add_course->bindValue(10, $add_video);
            
            
                $add_course->execute();
                $success = true;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }


}

$courses = $conn->prepare('SELECT * FROM course');
$courses->execute();
$courses = $courses->fetchAll(PDO::FETCH_ASSOC);

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
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;">افزودن دوره</h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" class="form-control" placeholder="عنوان دوره"><br>
        <textarea name="caption" class="editor" id="my-editor" cols="30" rows="10"
            placeholder="کپشن مورد نظر خود را بنویسید"></textarea><br>
        <label>وضعیت دوره</label><br>
        <label>به اتمام رسیده</label>
        <input type="radio" name="status" name="status" value="0"><br>
        <label>درحال برگزاری</label>
        <input type="radio" name="status" name="status" value="1" checked><br><br>

        <label> عکس : </label><br>
        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload"><br>

        <label>مدرس</label>
        <select name="teacher" class="form-control">
            <?php foreach($admin as $teache){ ?>
                <option value="<?= $teache['id'] ?>"><?= $teache['username'] ?></option>
            <?php } ?>
        </select><br>
        <label>سطح دوره</label><br>
        <select name="level" class="form-control">
            <option value="1">مقدماتی</option>
            <option value="2">متوسط</option>
            <option value="3">پیشرفته</option>
        </select><br>

        <label>وضعیت پرداخت</label><br>
        <label>رایگان</label>
        <input type="radio" name="pay" value="0" onclick="sum1()" checked><br>
        <label value="1">نقدی</label>
        <input type="radio" name="pay" value="1" onclick="sum()"><br>

        <style>
        #pay_div {
            display: none;
        }
        </style>
        <script>
        function sum() {
            document.querySelector("#pay_div").style = "display: block";
        }

        function sum1() {
            document.querySelector("#pay_div").style = "display: none";
        }
        </script>

        <div id="pay_div">
            <label> قیمت دوره : </label>
            <input type="text" class="form-control" name="value" placeholder="قیمت دوره اموزشی">
        </div><br>

        <label>آپلود ویدئوی مقدمه</label>
        <input type="file" name="fileToUpload2" class="form-control" id="fileToUpload2"><br>

        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ثبت دوره" name="sub" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
    <table class="table table-light table-hover"
        style="border: 1px solid #6e7871; border-radius: 5px; box-shadow: 0px 0px 4px #6e7871">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">تاریخ</th>
                <th scope="col">قسمت</th>
                <th scope="col">سطح</th>
                <th scope="col">قیمت</th>
                <th scope="col">نویسنده</th>
                <th scope="col">حذف، ویرایش</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($courses as $course){ ?>
            <tr>
                <th scope="row"><?= $number++; ?></th>
                <td><?= $course['title'] ?></td>
                <td><?= jdate('j / m / Y', $course['date']) ?></td>
                <td><?= $course['parts'] ?></td>
                <td><?php if($course['course_level'] == 1){echo "مقدماتی";}elseif($course['course_level'] == 2){echo "متوسط";}else{echo "پیشرفته";} ?></td>
                <td><?php if(empty($course['price'])){echo "رایگانـ";}else{echo $course['price'] . " تومان ";} ?></td>
                <td><?php foreach($admin as $ad){if($ad['id'] == $course['teacher']){echo $ad['username'];}} ?></td>
                <td>
                    <a href="deletecourse.php?id=<?= $course['id'] ?>"><input type="submit" value="حذف" class="btn btn-danger"></a>
                    <a href="editcourse.php?id=<?= $course['id'] ?>"><input type="submit" value="ویرایش" class="btn btn-warning"></a>
                    <a href="part.php?id=<?= $course['id'] ?>"><input type="submit" value="مدیریت قسمت ها" class="btn btn-info"></a>
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
    title: 'دوره با موفقیت اضافه شد'
})
</script>
<?php } ?>
<?php if($error_format){ ?>
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
    title: 'فقط فرمت های jpg, png, jpage پشتیبانی میشود'
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

<?php if($error_format_video){ ?>
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