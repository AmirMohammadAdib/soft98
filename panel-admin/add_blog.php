<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";

$number =1;
$success = null;

$admin = $conn->prepare('SELECT username , id FROM users WHERE userlevel=1');
$admin->execute();
$admin = $admin->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['sub'])){

    //uploader//
    $target_dir = "../image/poster-blog/";
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

        
    $title = $_POST['title'];
    $writer = $_POST['writer'];
    $content = $_POST['content'];
    $caption_box = $_POST['caption_box'];

    $add_blog = $conn->prepare('INSERT INTO blog SET title=? , poster=? , writer=? , vio=? , date=? , content=? , caption_box=?');
    $add_blog->bindValue(1, $title);
    $add_blog->bindValue(2, $new_name);
    $add_blog->bindValue(3, $writer);
    $add_blog->bindValue(4, 260);
    $add_blog->bindValue(5, time());
    $add_blog->bindValue(6, $content);
    $add_blog->bindValue(7, $caption_box);

    $add_blog->execute();
    $success =true;

    }

    $blogs = $conn->prepare('SELECT * FROM blog');
    $blogs->execute();
    $blogs = $blogs->fetchAll(PDO::FETCH_ASSOC);
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
                                <a href="add_blog.php" class="nav-link active">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن بلاگ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="add_blog.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>نظرات مقاله</p>
                                </a>
                            </li>
                        </ul>
                        <!-- software -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                نرم افزار
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="addsoft.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن نرم افزار</p>
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
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;">افزودن مقاله</h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" class="form-control" placeholder="عنوان مقاله"><br>

        <label> پوستر : </label><br>
        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload"><br>

        <textarea name="content" class="editor" id="my-editor" cols="30" rows="10"
            placeholder="مقاله خودتون رو بنویسید"></textarea><br>


        <label>کپشن باکس</label>
        <input type="text" name="caption_box" class="form-control" placeholder="کپشن باکس(20 الی 30 کلمه)"><br>

        <label>نویسنده</label>
        <select name="writer" class="form-control">
            <?php foreach($admin as $teache){ ?>
            <option value="<?= $teache['id'] ?>"><?= $teache['username'] ?></option>
            <?php } ?>
        </select><br>


        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ثبت مقاله" name="sub" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
    <table class="table table-light table-hover"
        style="border: 1px solid #6e7871; border-radius: 5px; box-shadow: 0px 0px 4px #6e7871">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">پوستر</th>
                <th scope="col">نویسنده</th>
                <th scope="col">حذف، ویرایش</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($blogs as $blog){ ?>
            <tr>
                <th scope="row"><?= $number++; ?></th>
                <th scope="row"><?= $blog['title'] ?></th>
                <th scope="row"><img src="../image/poster-blog/<?= $blog['poster'] ?>" width="200"></th>
                <th scope="row"><?php foreach($admin as $ad){if($ad['id'] == $blog['writer']){echo $ad['username'];}} ?>
                </th>
                <td>
                    <a href="editblog.php?id=<?= $blog['id'] ?>"><input type="submit" value="ویرایش"
                            class="btn btn-warning"></a>
                    <a href="deleteblog.php?id=<?= $blog['id'] ?>"><input type="submit" value="حذف"
                            class="btn btn-danger"></a>
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
    title: 'مقاله با موفقیت اضافه شد'
})
</script>
<?php } ?>