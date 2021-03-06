<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";

$success = null;

if(isset($_POST['sub'])){
    //uploader//
    $target_dir = "../software/";
    $soft = rand(1000, 100000) . basename($_FILES["soft"]["name"]);
    $target_file = $target_dir . $soft;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["soft"]["tmp_name"]);
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
    if ($_FILES["soft"]["size"] > 500000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "rar"
    ) {
        $error_format = true;
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["soft"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($soft)) . " has been uploaded.";
                //uploader//
    $target_dir = "../software/logo/";
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
            $title = $_POST['titre'];
            $caption = $_POST['caption'];
            $category = $_POST['category'];
            $caption_box = $_POST['caption_box'];

            $add_soft = $conn->prepare('INSERT INTO software SET titre=? , logo=? , caption=? , category=? , date=? , file=? , caption_box=?');
            $add_soft->bindValue(1, $title);
            $add_soft->bindValue(2, $new_name);
            $add_soft->bindValue(3, $caption);
            $add_soft->bindValue(4, $category);
            $add_soft->bindValue(5, time());
            $add_soft->bindValue(6, $soft);
            $add_soft->bindValue(7, $caption_box);

            $add_soft->execute();
            $success = true;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">?????? ????????????</span>
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
                    <a href="#" class="d-block">???????? ??????????</a>
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
                                ???????? ????????
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="menus.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>?????? ????</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="logo.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>????????</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="slider.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>??????????????</p>
                                </a>
                            </li>
                        </ul>

                        <!-- user -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                ??????????????
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="users.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>???????? ??????????????</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="golduser.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>?????????????? ????????</p>
                                </a>
                            </li>
                        </ul>

                        <!-- courses -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                ????????
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add_course.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>???????????? ????????</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="add_course.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>???????? ????????</p>
                                </a>
                            </li>
                        </ul>
                        <!-- blog -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                ??????????
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add_blog.php" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>???????????? ????????</p>
                                </a>
                            </li>
                        </ul>
                        <!-- software -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                ?????? ??????????
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="addsoft.php" class="nav-link active">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>???????????? ?????? ??????????</p>
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
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;">???????????? ?????? ??????????</h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <form method="POST" enctype="multipart/form-data"><br>
        <label>?????? ?????? ??????????</label>
        <input type="text" name="titre" class="form-control"
            placeholder="?????? ?????? ?????????? (???????? : ???????????? ?????? ?????????? ???????????? ?????????????? ???? - visual studio code / 16.2)"><br>

        <textarea name="caption" class="editor" id="my-editor" cols="30" rows="10"
            placeholder="?????????????? ?????? ?????????? ???? ??????????"></textarea><br>

        <label> ?????? ?????????? ???? ?????????? ???? : (???????? ???? 500 ??????????????)</label><br>
        <input type="file" name="soft" class="form-control" id="soft"><br>

        <label>???????? ????????</label>
        <select name="category" class="form-control">
            <option value="1">?????? ??????????</option>
            <option value="2">???????????? </option>
            <option value="3"> ???????????? ??????????</option>
        </select><br>

        <label> ???????? ?????? ?????????? (1 : 1)</label><br>
        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload"><br>

        <label>???????? ????????</label>
        <input type="text" name="caption_box" class="form-control" placeholder="???????? ????????(15 ????????)"><br>
        <div style="display: flex; justify-content: center;">
            <input type="submit" value="???????????? ?????? ??????????" name="sub" class="btn btn-warning" style="width: 60%;">
        </div>

    </form>
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
    title: '?????? ?????????? ???? ???????????? ?????????? ????'
})
</script>
<?php } ?>