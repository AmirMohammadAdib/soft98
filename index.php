<?php 
include "database/db.php";
include "script/jdf.php";


$num_student = $conn->prepare('SELECT COUNT(id) FROM users');
$num_student->execute();
$num_students = $num_student->fetch(PDO::FETCH_ASSOC);

foreach($num_students as $num_student){}


$num_course = $conn->prepare('SELECT COUNT(id) FROM course');
$num_course->execute();
$num_course = $num_course->fetch(PDO::FETCH_ASSOC);

foreach($num_course as $num_cours){}

$number = 0;
$success_login = null;
$error_login = null;
$menus = $conn->prepare('SELECT * FROM menus ORDER BY sort');
$menus->execute();
$menus = $menus->fetchAll(PDO::FETCH_ASSOC);

$logo = $conn->prepare('SELECT * FROM logo WHERE id=1');
$logo->execute();
$logo = $logo->fetch(PDO::FETCH_ASSOC);

$slider = $conn->prepare('SELECT * FROM slider');
$slider->execute();
$slider = $slider->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $login = $conn->prepare('SELECT * FROM users WHERE email=? AND pass=?');
    $login->bindValue(1, $email);
    $login->bindValue(2, $pass);
    $login->execute();

    if($login->rowCount() >= 1){ 
        $success_login = true;
        $login = $login->fetch(PDO::FETCH_ASSOC);

        $_SESSION['login'] = true;
        $_SESSION['name'] = $login['username'];
        $_SESSION['email'] = $email;
        $_SESSION['pass'] = $pass;
        $_SESSION['userlevel'] = $login['userlevel'];

    }else{ 
        $error_login = true;
} 
}
if(isset($_SESSION['login'])){
    $wallet = $conn->prepare('SELECT wallet FROM users WHERE email=?');
$wallet->bindValue(1, $_SESSION['email']);
$wallet->execute();
$wallet = $wallet->fetch(PDO::FETCH_ASSOC); 
}

$course = $conn->prepare('SELECT * FROM course LIMIT 8');
$course->execute();
$course = $course->fetchAll(PDO::FETCH_ASSOC);

$blogs = $conn->prepare('SELECT * FROM blog LIMIT 8');
$blogs->execute();
$blogs = $blogs->fetchAll(PDO::FETCH_ASSOC);

$admin = $conn->prepare('SELECT username , id FROM users WHERE userlevel=1');
$admin->execute();
$admin = $admin->fetchAll(PDO::FETCH_ASSOC);

$softs = $conn->prepare('SELECT * FROM software');
$softs->execute();
$softs = $softs->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="all-content">
        <div class="header">
            <div class="container col-xl-10">
                <div class="row">
                    <div class="all-header">
                        <div class="menu-header">
                            <ul>
                                <?php foreach($menus as $menu){ ?>
                                <a href="<?= $menu['src'] ?>">
                                    <li><?= $menu['title'] ?></li>
                                </a>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="icon-header">
                            <div class="searche">
                                <span onclick="open_searche()" onmousedown="down_searche()" id="search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor"
                                        class="bi bi-search" viewBox="0 0 16 16" id="icon_searche">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="searche" placeholder="دنبال چه دوره ای هستی" id="searche">
                            </div>
                            <div class="login-register">
                                <?php if(isset($_SESSION['login'])){ ?>
                                <div class="login">
                                    <div style="display: flex; align-items: center;">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; margin-right: 5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34"
                                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"
                                                onclick="open_profile()" onclick="down_profile()">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path fill-rule="evenodd"
                                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" id="row-register" class="bi bi-caret-down-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                            </svg>
                                        </div>
                                        <a href="page/spacial_account.php"><img src="image/logo-special-account.png"
                                                width="200"></a>
                                    </div>

                                    <div class="box-profile">
                                        <div style="display: flex; justify-content: right;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                style="color: #eb3636; opacity: 0.7; cursor: pointer; margin-bottom: -35px; z-index: 2;"
                                                onclick="exit_profile()" fill="currentColor" class="bi bi-x"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                            </svg>
                                        </div>
                                        <p class="name-profile">خوش آمدید <?= $_SESSION['name'] ?></p>
                                        <div class="profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-person-rolodex" viewBox="0 0 16 16">
                                                <path d="M8 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                <path
                                                    d="M1 1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h.5a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h.5a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H6.707L6 1.293A1 1 0 0 0 5.293 1H1Zm0 1h4.293L6 2.707A1 1 0 0 0 6.707 3H15v10h-.085a1.5 1.5 0 0 0-2.4-.63C11.885 11.223 10.554 10 8 10c-2.555 0-3.886 1.224-4.514 2.37a1.5 1.5 0 0 0-2.4.63H1V2Z" />
                                            </svg>
                                            <p>پروفایل</p>
                                        </div>

                                        <div class="profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                                            </svg>
                                            <p>علاقه مندی ها</p>
                                        </div>


                                        <div class="profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                                            </svg>
                                            <div
                                                style="width: 100%; display: flex; flex-direction: row-reverse; justify-content: space-between;">
                                                <a href="page/pay/wallet.php">
                                                    <p>کیف پول</p>
                                                </a>
                                                <p style="opacity: 0.6;">تومان <?= $wallet['wallet'] ?></p>
                                            </div>
                                        </div>

                                        <div class="profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                                                <path
                                                    d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                                <path
                                                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                                <path
                                                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                                            </svg>
                                            <p>جدید ترین مطالب</p>
                                        </div>
                                        <div class="profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                                                <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM3.394 15l-1.48-6h-.97l1.525 6.426a.75.75 0 0 0 .729.574h9.606a.75.75 0 0 0 .73-.574L15.056 9h-.972l-1.479 6h-9.21z"/>
                                            </svg>
                                            <a href="page/basket.php"><p>سبد خرید</p></a>
                                        </div>
                                        <?php if($_SESSION['userlevel'] == 1){ ?>
                                        <div class="profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                                                <path
                                                    d="M13.5 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h11zm-11-1a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-11z" />
                                                <path
                                                    d="M6.5 3a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V3zm-4 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V3zm8 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V3z" />
                                            </svg>
                                            </svg>
                                            <a href="panel-admin/menus.php"
                                                style="text-decoration: none; color: #555b5e;">
                                                <p>پنل ادمین</p>
                                            </a>
                                        </div>
                                        <?php } ?>
                                        <hr>
                                        <div class="delete-accont">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                                <path fill-rule="evenodd"
                                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                            </svg>
                                            <a href="page/out-accont.php" style="text-decoration: none;">
                                                <p>خروج از سایت</p>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <?php }else{ ?>
                                <div class="login-spacial">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor"
                                        class="bi bi-person-circle" viewBox="0 0 16 16" onclick="open_login()"
                                        onmousedown="down_login()">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                    </svg>
                                    <?php if(!isset($_SESSION['login'])){ ?><a href="page/register.php"><img
                                            src="image/logo-special-account.png" width="200"></a><?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-xl-10">
        <div class="login-box">
            <div class="header-box-login">
                <div class="logo-login">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="titre-login">
                        <h1>ورود به سایت</h1>
                    </div>
                </div>
                <div class="exit-box-login" onclick="exit_login()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </div>
            </div>
            <form method="POST">
                <div class="form-login">
                    <div class="username">
                        <label>ایمیل</label><br>
                        <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" class="form-control">
                    </div>
                    <div class="pass">
                        <label>رمز عبور</label><br>
                        <input type="text" name="pass" placeholder="رمز عبور خود را وارد کنید" class="form-control">
                        <a href="">رمزمو فراموش کردم</a>
                    </div>
                    <input type="submit" value="ورود" class="btn" name="login">
                    <div class="register-link">
                        <p><span>حساب نداری : </span><a href="page/register.php">عضویت در وبسایت</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div><br>
    <div class="container col-xl-10">
        <div class="logo-poster">
            <div class="logo">
                <img src="image/logo-site/<?= $logo['image']; ?>" alt="">
            </div>
            <div class="information-site">
                <div class="box">
                    <div class="time">
                        <div class="image">
                            <img src="image/stat-time.svg">
                        </div>
                        <div class="value">
                            <p>دوره آموزشی</p><span><?= $num_cours ?></span>
                        </div>
                    </div>
                    <div class="time">
                        <div class="image">
                            <img src="image/stat-teacher.svg">
                        </div>
                        <div class="value">
                            <p>مقاله تست</p><span>۱۵۸</span>
                        </div>
                    </div>
                    <div class="time">
                        <div class="image">
                            <img src="image/stat-student.svg">
                        </div>
                        <div class="value">
                            <p>نفر دانشجو</p><span><?= $num_student ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-xl-10">
        <div class="slider">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php foreach($slider as $slide){ ?><li data-target="#carouselExampleIndicators"
                        data-slide-to="<?= $number++ ?>" class="<?php if($slide['active'] == 1){ ?>active<?php } ?>">
                    </li><?php } ?>
                </ol>
                <div class="carousel-inner">
                    <?php foreach($slider as $slide){ ?>
                    <div class="carousel-item <?php if($slide['active'] == 1){ ?>active<?php } ?>">
                        <img class="d-block w-100" src="image/slider/<?= $slide['image'] ?>" alt="Second slide">
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
    </div>
    <div class="container col-xl-10">
        <div class="course" style="padding-bottom: 0;">
            <div class="header-course">
                <div class="titre">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                        <path
                            d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z" />
                    </svg>
                    <h1>جدید ترین دوره های آموزشی</h1>
                </div>
            </div>
            <div class="all-box-course" style="flex-wrap: wrap;">
                <?php foreach($course as $cours){ ?>
                <div class="box-course" style="margin-bottom: 13px;">
                    <div class="image">
                        <a href="page/course.php?id=<?= $cours['id'] ?>"><img
                                src="image/poster-course/<?= $cours['poster'] ?>"></a>
                    </div>
                    <div class="title">
                        <a href="page/course.php?id=<?= $cours['id'] ?>"><h1 style="direction: rtl;"><?= $cours['title'] ?></h1></a>
                    </div>
                    <div class="teacher-name">
                        <div class="teacher">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                            <p><?php foreach($admin as $ad){ if($ad['id'] == $cours['teacher']){echo $ad['username'];}} ?></p>
                        </div>
                    </div>
                    <hr style="margin-top: -5px;">
                    <div class="bottom-course">
                        <div class="time">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-clock" viewBox="0 0 16 16">
                                <path
                                    d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                            <p>۹:۵:۰۰</p>
                        </div>
                        <div class="pay">
                            <p><?php if(empty($cours['price'])){echo "رایگانـ";}else{echo $cours['price'] . "تومان";} ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div><br>
    <div class="container col-xl-10">
        <div class="course">
            <div class="header-course">
                <div class="titre">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                        <path
                            d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z" />
                    </svg>
                    <h1>آخرین مقالات وبسایت</h1>
                </div>
            </div>
            <div class="all-box-blog">
                <div class="boxs-blog">
                    <?php foreach($blogs as $blog){ ?>
                    <div class="box-course" style="width: 49%; margin-bottom: 15px;">
                        <div class="image">
                            <a href="page/blog.php?id=<?= $blog['id'] ?>"><img src="image/poster-blog/<?= $blog['poster'] ?>"></a>
                        </div>
                        <div class="title">
                            <a href="page/blog.php?id=<?= $blog['id'] ?>" style="text-decoration: none;">
                                <h1><?= $blog['title'] ?></h1>
                            </a>
                        </div>
                        <div class="caption">
                            <p><?= $blog['caption_box'] ?></p>
                        </div>
                        <div class="information-course">
                            <div class="right-box-course">
                                <div class="date">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-calendar-date" viewBox="0 0 16 16">
                                        <path
                                            d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z" />
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                    </svg>
                                    <p><?= jdate('Y / m / j', $blog['date']) ?></p>
                                </div>
                                <div class="vio">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                    <p>۲۵۶</p>
                                </div>
                            </div>
                            <div class="left-box-course">
                                <div class="writer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person" viewBox="0 0 16 16">
                                        <path
                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                    </svg>
                                    <p><?php foreach($admin as $ad){if($ad['id'] == $blog['writer']){echo $ad['username'];}} ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                </div>
                <div class="software">
                    <?php foreach($softs as $soft){ ?>
                    <div class="box-software">
                        <div class="image-titre-soft">
                            <div class="image">
                                <img src="software/logo/<?= $soft['logo'] ?>">
                            </div>
                            <div class="title-caption">
                                <div class="title">
                                    <a href="page/software.php?id=<?= $soft['id'] ?>" style="margin-top: 15px; text-decoration: none;">
                                        <h1>
                                            <?= $soft['titre'] ?>
                                        </h1>
                                    </a>
                                </div>
                                <div class="caption">
                                    <p><?= $soft['caption_box'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div><br>
    <div style="background-color: #313a3f;">
        <div class="container col-xl-10">
            <div class="footer">
                <p>طبق ماده تست قانون تمام حقوق مادی و معنوی وبسایت متعلق به صاحب امتیاز سایت میباشد<br><br>استفاده از
                    مطالب وبسایت تنها با اجازه از مدیریت وبسایت مجاز است</p>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="js/app.js"></script>

</html>
<?php if($success_login){ ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
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
    title: 'ورود با موفقیت انجام شد'
})
</script>
<?php } ?>
<?php if($error_login){ ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
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
    title: 'ایمیل یا رمز عبور اشتباهه'
})
</script>
<?php } ?>