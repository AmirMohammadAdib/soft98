<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";


$baskets = $conn->prepare('SELECT course.title , course.price , course.date , course.poster , basket.id FROM basket JOIN course ON course_id = course.id WHERE user_id=? AND status=0');
$baskets->bindValue(1, $_SESSION['email']);
$baskets->execute();
$baskets = $baskets->fetchAll(PDO::FETCH_ASSOC);

$total = 0;

$wallet = $conn->prepare('SELECT wallet FROM users WHERE email=?');
$wallet->bindValue(1, $_SESSION['email']);
$wallet->execute();
$wallet = $wallet->fetch(PDO::FETCH_ASSOC);

?>
<div class="container col-xl-9" style="margin-top: 100px;">
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
</div><br>

<div class="container col-xl-9" style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
    <div class="all-content-basket" style="width: 69.5%;">
        <?php foreach($baskets as $basket){ ?>
        <div class="basket-course">
            <div class="img-title">
                <div class="img-course-basket">
                    <img src="../image/poster-course/<?= $basket['poster'] ?>">
                </div>
                <div class="title-teacher">
                    <div class="titre-basket">
                        <h1><?= $basket['title'] ?></h1>
                    </div>
                    <div class="teacher-box-basket">
                        <h4>مدرس : امیر محمد ادیب</h4>
                    </div>
                </div>
            </div>
            <div class="pay-date">
                <div class="price">
                    <h4><?= $basket['price'] ?> تومان</h4>
                </div>
                <div class="date">
                    <h6><?= jdate('Y / j / n', $basket['date']) ?></h6>
                </div>
            </div>
            <div class="exit">
                <a href="deletebasket.php?id=<?= $basket['id'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x"
                        viewBox="0 0 16 16">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg></a>
            </div>
        </div>
        <?php $total += $basket['price'];} ?>
    </div>
    <div class="side-basket">
        <div class="payment-method">
            <h3>انتخاب شیوه پرداخت</h3>
            <div class="radio-payment">
                <div class="form-check select-payment">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label information-check-pay" for="flexRadioDefault1">
                        اتصال به درگاه پرداخت
                    </label>
                </div>
                <div class="form-check select-payment" style="margin-top: 5px;">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                    <label class="form-check-label information-check-pay" for="flexRadioDefault2">
                        خرید با کیف پول
                    </label>
                </div>
            </div>
        </div><br>
        <div class="final-pay">
            <div class="me-wallet">
                <p> : موجودی کیف پول شما</p><span><?= $wallet['wallet'] ?> تومان</span>
            </div>
            <div class="me-wallet">
                <p> : مبلغ کل</p><span><?= $total; ?> تومان</span>
            </div>
            <hr>
            <div class="final-pay-price">
                <h4>مبلغ قابل پرداخت : <?= $total; ?> تومان</h4>
            </div>
            <form method="POST" action="pay.php">
                <input type="hidden" value="<?= $total ?>" name="total">
                <input type="hidden" value="<?= $_SESSION['email'] ?>" name="user">
                <input type="hidden" value="<?php foreach($baskets as $basket){echo $basket['id'];} ?>" name="course">

                <input type="submit" value="ثبت و پرداخت نهایی" class="btn"
                    style="width: 100%; background-color: #288fd4; color: #ffffff; opacity: 0.7; margin-top: 8px;"
                    name="sub">
            </form>
        </div>
    </div>
</div><br>

<?php include "footer.php" ?>