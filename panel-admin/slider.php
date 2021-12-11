<?php 
include "../database/db.php";
include "header.php"; 

$number = 1;

$success = null;
$error = null;
$error_format = null;

if(isset($_POST['sub'])){
    $active = $_POST['select'];

    
    //uploader//
  $target_dir = "../image/slider/";
  $new_name = basename($_FILES["fileToUpload"]["name"]);
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
      $uploadOk = 0;
      $error_format = true;

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

  $add_logo = $conn->prepare('INSERT INTO slider SET image=? , active=?');
  $add_logo->bindValue(1, $new_name);
  $add_logo->bindValue(2, $active);
  $add_logo->execute();
  $success = true;

}
$slider = $conn->prepare('SELECT * FROM slider');
$slider->execute();
$slider = $slider->fetchAll(PDO::FETCH_ASSOC);


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
                                <a href="slider.php" class="nav-link active">
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
    <h1 style="margin-right: 280px; margin-top: 12px; opacity: 0.7;">اسلایدر</h1>
</div>
<div class="form-menus" style="width: 70%; margin-right: 280px; margin-top: 20px;">
    <div class="slider" style="width: 50%;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach($slider as $slide){ ?><li data-target="#carouselExampleIndicators"
                    data-slide-to="<?= $number++ ?>" class="<?php if($slide['active'] == 1){ ?>active<?php } ?>"></li>
                <?php } ?>
            </ol>
            <div class="carousel-inner">
                <?php foreach($slider as $slide){ ?>
                <div class="carousel-item <?php if($slide['active'] == 1){ ?>active<?php } ?>">
                    <img class="d-block w-100" src="../image/slider/<?= $slide['image'] ?>" alt="Second slide">
                </div>
                <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data"><br>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control active"><br>
        <h2 style="opacity: 0.7;">وضعیت انتخاب</h2>
        <div style="display: flex; align-items: center;">
            <label>غیرفعال</label>
            <input type="radio" name="select" class="form-check" checked value="0" style="margin-right: 5px;"><br>
        </div>
        <div style="display: flex; align-items: center;">
            <label>فعال</label>
            <input type="radio" name="select" class="form-check" value="1" style="margin-right: 5px;">
        </div>
        <div style="display: flex; justify-content: center;">
            <input type="submit" value="ثبت اسلایدر" name="sub" class="btn btn-warning" style="width: 60%;">
        </div>
    </form><br>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">عکس</th>
                <th scope="col">حذف</th>
                <th scope="col">انتخاب</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach($slider as $slide){ ?>

                <th scope="row"><?= $number++; ?></th>
                <td style="width: 67%;"><img src="../image/slider/<?= $slide['image']; ?>" style="width: 100%;"></td>
                <td>
                    <a href="deleteslider.php?id=<?= $slide['id']; ?>"><input type="submit" value="حذف"
                            class="btn btn-danger"></a>
                </td>
                <td><?php if($slide['active'] == 0){echo "غیر فعال";}elseif($slide['active'] == 1){echo "فعال";} ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>



<?php include "footer.php"; ?>