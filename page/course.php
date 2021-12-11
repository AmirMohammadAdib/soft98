<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";

$succes_basket = null;
$id = $_GET['id'];
$number_parts = 1;
$error_login = null;
$error_row = null;

$slect = $conn->prepare('SELECT * FROM basket WHERE course_id=? && user_id=?');
$slect->bindValue(1, $id);
$slect->bindValue(2, $_SESSION['email']);
$slect->execute();
$slect = $slect->fetch(PDO::FETCH_ASSOC);



$course = $conn->prepare('SELECT * FROM course WHERE id=?');
$course->bindValue(1, $id);
$course->execute();
$course = $course->fetch(PDO::FETCH_ASSOC);


$parts = $conn->prepare('SELECT * FROM parts WHERE course=?');
$parts->bindValue(1, $id);
$parts->execute();
$parts = $parts->fetchAll(PDO::FETCH_ASSOC);

    $row_count = $conn->prepare('SELECT * FROM basket WHERE course_id=? && user_id=?');
    $row_count->bindValue(1, $id);
    $row_count->bindValue(2, $_SESSION['email']);
    $row_count->execute();
    $row_count = $row_count->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['basket'])){
    if(isset($_SESSION['login'])){
        if(!empty($course['price'])){
            if($row_count->rowCount() <= 0){
            $add_basket = $conn->prepare('INSERT INTO basket SET course_id=? , user_id=?');
            $add_basket->bindValue(1, $id);
            $add_basket->bindValue(2, $_SESSION['email']);
            $add_basket->execute();
            $succes_basket = true;
        }else{
            $error_row = true;
        }
    }else{
        $error_login = true;
    }
    }
}

$amount_parts = $conn->prepare('SELECT COUNT(id) FROM parts WHERE course=?');
$amount_parts->bindValue(1, $id);
$amount_parts->execute();
$amount_parts = $amount_parts->fetch(PDO::FETCH_ASSOC);
foreach($amount_parts as $amount_part){};

?>
<div class="container col-xl-10" style="margin-top: 100px;">
    <div class="slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="../image/slider.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="../image/slider2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="../image/slider.png" alt="Third slide">
                </div>
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
<?= $row_count['user_id'] ?>


<div class="container col-xl-10" style="display: flex; justify-content: space-between; align-items: start;">
    <div class="all-left-content" style="width: 65%;">
        <div class="content-course">
            <div class="image">
                <img src="../image/poster-course/<?= $course['poster'] ?>">
            </div>
            <div class="titre">
                <h1><?= $course['title'] ?></h1>

                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart"
                    viewBox="0 0 16 16">
                    <path
                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                </svg>
            </div>
            <div class="caption">
                <p><?= $course['cation'] ?></p>
            </div>
        </div>
        <div class="video-course">
            <div class="header-video">
                <div class="category-video">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-person-video2" viewBox="0 0 16 16">
                        <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path
                            d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z" />
                    </svg>
                    <h4>فهرستـــ ویدئو ها</h4>
                </div>
                <div class="time-video">
                    <p>مدت زمان دوره</p> <span>۲۵ : ۲۶ : ۲۱</span>
                </div>
            </div>
            <div class="video">
                <video controls id="video" src="../video/introduction_course/<?= $course['introduction_video'] ?>">

                </video>
            </div>
            <div class="parts">
                <?php foreach($parts as $part){ ?>
                <div class="box-part">
                    <div class="line-right-part">
                        <div class="number-part">
                            <p><?= $number_parts++; ?></p>
                        </div>
                        <div class="name-part">
                            <p><?= $part['name'] ?></p>
                        </div>
                    </div>
                    <div class="line-left-part">
                        <div class="time-part">
                            <p><?= $part['time'] . " دقیقه" ?></p>
                        </div>
                        <div class="icon-part">
                            <a href="#video">
                                <div class="play" link="<?= $part['video'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                        class="bi bi-play" viewBox="0 0 16 16">
                                        <path
                                            d="M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z" />
                                    </svg>
                                </div>
                            </a>
                            <div class="download">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                    class="bi bi-download" viewBox="0 0 16 16">
                                    <path
                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path
                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <script>
                $(document).on('click', '.play', function() {
                    var link = $(this).attr('link');
                    $("#video").attr('src', "../video/part-course/" + link);
                })
                </script>
            </div>
        </div>
        <div class="video-course" style="padding-bottom: 1.2%;">
            <div class="comments">
                <div class="category-comment">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                        class="bi bi-receipt" viewBox="0 0 16 16">
                        <path
                            d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                        <path
                            d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <h4>نظرات کاربران در رابطه با این دوره</h4>
                </div>
                <p class="help-comment">نظر خود را وارد کنید</p>
                <textarea name="caption" class="editor" id="my-editor" cols="30" rows="10"
                    placeholder="نظر خودت رو وارد کن"></textarea><br>
                <div style="display: flex; justify-content: end; margin-top: -15px;">
                    <input type="submit" value="ثبت نظر" class="btn btn-warning"
                        style="width: 30%; margin-bottom: 10px;">
                </div>
            </div><br>
            <div class="box-comment">
                <div class="up-box">
                    <div class="profile-name">
                        <div class="profile">
                            <img src="../image/profile-comment.jpg">
                        </div>
                        <div class="name-date">
                            <div class="fullname">
                                <h4>امیر محمد ادیب</h4>
                            </div>
                            <div class="date-comment">
                                <h5>۲۵ / ۸/ / ۱۴۰۰</h5>
                            </div>
                            <div class="content">
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان
                                    گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط
                                    فعلی
                                    تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
                                    زیادی
                                    در شصت و سه درصد گذشته حال و آینده، شنا</p>
                            </div>
                        </div>
                    </div>
                    <div class="replay">
                        <input type="submit" value="پاسخ" class="btn btn-success" style="background-color: #a1d4ae;">
                        <input type="submit" value="گزارش" class="btn btn-warning" style="background-color: #f7f28b;">
                    </div>
                </div>
            </div>
            <div class="box-comment">
                <div class="up-box">
                    <div class="profile-name">
                        <div class="profile">
                            <img src="../image/profile-comment.jpg">
                        </div>
                        <div class="name-date">
                            <div class="fullname">
                                <h4>امیر محمد ادیب</h4>
                            </div>
                            <div class="date-comment">
                                <h5>۲۵ / ۸/ / ۱۴۰۰</h5>
                            </div>
                            <div class="content">
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان
                                    گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط
                                    فعلی
                                    تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
                                    زیادی
                                    در شصت و سه درصد گذشته حال و آینده، شنا</p>
                            </div>
                        </div>
                    </div>
                    <div class="replay">
                        <input type="submit" value="پاسخ" class="btn btn-success" style="background-color: #a1d4ae;">
                        <input type="submit" value="گزارش" class="btn btn-warning" style="background-color: #f7f28b;">
                    </div>
                </div>
            </div>
            <div class="box-comment">
                <div class="up-box">
                    <div class="profile-name">
                        <div class="profile">
                            <img src="../image/profile-comment.jpg">
                        </div>
                        <div class="name-date">
                            <div class="fullname">
                                <h4>امیر محمد ادیب</h4>
                            </div>
                            <div class="date-comment">
                                <h5>۲۵ / ۸/ / ۱۴۰۰</h5>
                            </div>
                            <div class="content">
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان
                                    گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط
                                    فعلی
                                    تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
                                    زیادی
                                    در شصت و سه درصد گذشته حال و آینده، شنا</p>
                            </div>
                        </div>
                    </div>
                    <div class="replay">
                        <input type="submit" value="پاسخ" class="btn btn-success" style="background-color: #a1d4ae;">
                        <input type="submit" value="گزارش" class="btn btn-warning" style="background-color: #f7f28b;">
                    </div>
                </div>
            </div>
        </div>
    </div><br>

    <div class="pay-course" style="width: 34%; margin-top: 20px; top: 100px; position: sticky;">
        <div class="header-pay">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-currency-dollar" viewBox="0 0 16 16">
                    <path
                        d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                </svg>
                <h1> قیمت این دوره<span style="font-size: 22px;">
                        <?php if(empty($course['price'])){echo "رایگانـ";}else{echo $course['price'] . " تومان ";} ?>
                    </span></h1>
            </div>
        </div>
        <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
        <div class="teachr"
            style="display: flex; flex-direction: row-reverse; justify-content: space-between; margin-top: 20px;">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-bounding-box" viewBox="0 0 16 16" class="icon-teacher"
                    style="color: #787878; opacity: 0.9;">
                    <path
                        d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z" />
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                </svg>
                <p style="margin-top: -5px; margin-right: 6px; opacity: 0.9;"> : مدرس</p>
            </div>
            <div>
                <p style="margin-top: -5px; color: #313233; font-size: 14px;">امیر محمد ادیب</p>
            </div>
        </div>
        <div class="teachr" style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-bounding-box" viewBox="0 0 16 16" class="icon-teacher"
                    style="color: #787878; opacity: 0.9;">
                    <path
                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                    <path
                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />

                </svg>
                <p style="margin-top: -5px; margin-right: 6px; opacity: 0.9;"> : مدت زمان دوره</p>
            </div>
            <div>
                <p style="margin-top: -5px; color: #313233; font-size: 14px;"><?php $times = 0; foreach($parts as $part){$times += $part['time'];} echo $times . " دقیقه " ?></p>
            </div>
        </div>
        <div class="teachr" style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-bounding-box" viewBox="0 0 16 16" class="icon-teacher"
                    style="color: #787878; opacity: 0.9;">
                    <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    <path
                        d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z" />
                </svg>
                <p style="margin-top: -5px; margin-right: 6px; opacity: 0.9;"> : تعداد ویدئو ها</p>
            </div>
            <div>
                <p style="margin-top: -5px; color: #313233; font-size: 14px; "><?= $amount_part . " ویدئو " ?></p>
            </div>
        </div>
        <div class="teachr" style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-bounding-box" viewBox="0 0 16 16" class="icon-teacher"
                    style="color: #787878; opacity: 0.9;">
                    <path
                        d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />

                </svg>
                <p style="margin-top: -5px; margin-right: 6px; opacity: 0.9;"> : سطح دوره</p>
            </div>
            <div>
                <p style="margin-top: -5px; color: #313233; font-size: 14px;">
                    <?php if($course['course_level'] == 1){echo "مقدماتی";}elseif($course['course_level'] == 2){echo "متوسط";}else{echo "پیشرفته";} ?>
                </p>
            </div>
        </div>
        <div class="teachr" style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-bounding-box" viewBox="0 0 16 16" class="icon-teacher"
                    style="color: #787878; opacity: 0.9;">
                    <path fill-rule="evenodd"
                        d="M0 .5A.5.5 0 0 1 .5 0h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 0 .5Zm0 2A.5.5 0 0 1 .5 2h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm9 0a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm-9 2A.5.5 0 0 1 .5 4h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5Zm5 0a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm7 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5Zm-12 2A.5.5 0 0 1 .5 6h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm8 0a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm-8 2A.5.5 0 0 1 .5 8h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm7 0a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm-7 2a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm0 2a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5Zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />

                </svg>
                <p style="margin-top: -5px; margin-right: 6px; opacity: 0.9;"> : وضعیت دوره</p>
            </div>
            <div>
                <p style="margin-top: -5px; color: #53afe0; font-size: 14px;">
                    <?php if($course['status_course'] == 0){echo "در حال برگزاری";}else{echo "به اتمام رسیده";} ?></p>
            </div>
        </div>
        <div class="teachr" style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
            <div style="display: flex; flex-direction: row-reverse;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-bounding-box" viewBox="0 0 16 16" class="icon-teacher"
                    style="color: #787878; opacity: 0.9;">
                    <path
                        d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                </svg>
                <p style="margin-top: -3px; margin-right: 6px; opacity: 0.9;"> : آخرین بروزرسانی</p>
            </div>
            <div>
                <p style="margin-top: -5px; color: #313233; font-size: 14px;"><?= jdate('Y / m / n', $course['date']) ?></p>
            </div>
        </div>
        <form method="POST">
            <?php 
                if(!empty($course['price'])){
                    if(isset($_SESSION['login']) && $slect['status'] == 1){ ?>
                        <input type="submit" value="شما دانشجوی این دوره هستید" class="btn" style="background-color: #ffffff; border: 2px solid #53afe0; color: #53afe0; width: 100%;">
                    <?php } elseif(isset($_SESSION['login']) && $slect['status'] == 0){ ?>
                        <input type="submit" value="ثبت نام در دوره" class="btn" style="background-color: #53afe0; color: #ffffff; width: 100%;" name="basket">
                <?php } else{ ?>
                    <a href="register.php"><input type="submit" value="ثبت نام در دوره" class="btn" style="background-color: #53afe0; color: #ffffff; width: 100%;"></a>
                <?php }}else{ ?>
                        <input type="submit" value="این دوره رایگانه" class="btn" style="background-color: #ffffff; border: 2px solid #53afe0; color: #53afe0; width: 100%;">  
             <?php } ?>
        </form>
    </div>
</div>

<?php include "footer.php" ?>
<?php if($succes_basket){ ?>
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
    title: 'محصول مورد نظر به سبد خرید اضافه شد'
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
    title: 'برای خرید باید وارد بشی'
})
</script>
<?php } ?>

<?php if($error_row){ ?>
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
    icon: 'warning',
    title: 'این محصول رو توی سبدت داری'
})
</script>
<?php } ?>