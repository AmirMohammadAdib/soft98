<?php 
include "../database/db.php";
include "header.php";

$error_inventory = null;


$slider = $conn->prepare('SELECT * FROM slider');
$slider->execute();
$slider = $slider->fetchAll(PDO::FETCH_ASSOC);


$wallet = $conn->prepare('SELECT wallet FROM users WHERE email=?');
$wallet->bindValue(1, $_SESSION['email']);
$wallet->execute();
$wallet = $wallet->fetch(PDO::FETCH_ASSOC); 


$pay = $conn->prepare('SELECT * FROM golduser');
$pay->execute();
$pay = $pay->fetchAll(PDO::FETCH_ASSOC);

foreach($pay as $pa){};


$wallet = $wallet['wallet'];
$description = $pa['pay'];


if(isset($_POST['pay'])){
    if($wallet >= $description){
        $add_user = $conn->prepare('INSERT INTO golduser SET name=? , date=?');
        $add_user->bindValue(1, $_SESSION['name']);
        $add_user->bindValue(2, time());
        $add_user->execute();
    
        $update = $conn->prepare('UPDATE users SET wallet=? WHERE email=?');
        $update->bindValue(1, $wallet-$description);
        $update->bindValue(2, $_SESSION['email']);
        $update->execute();
    }else{
        $error_inventory = true;
    }
}

?>
<div class="container col-xl-9" style="margin-top: 100px;">
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
</div>
<div class="container col-xl-9"
    style="display: flex; flex-direction: row-reverse; align-items: flex-start; justify-content: space-between;">
    <div class="information-pay">
        <div class="header-pay-page">
            <h1>اکانت ویژه ۱ ماهه</h1>
            <h4>۳۰ روز</h4>
        </div>
        <hr>
        <div class="monye-account">
            <h2>حق اشتراک : ۸۰۰۰۰ هزار تومان</h2>
        </div>
    </div>
    <div class="pay-account">
        <div class="total-wallet-txt">
            <h4>مجموع کیف پول :</h4>
            <h5><?= $wallet ?> تومان</h5>
        </div>
        <div class="total-wallet-txt" style="margin-top: 10px;">
            <h4>مبلغ کل فاکتور :</h4>
            <h5><?= $description ?> تومان</h5>
        </div>
        <hr style="opacity: 0.2;">
        <div class="payable">
            <h5>مبلغ قابل پرداخت : <?php if($wallet >= $description){echo "0";}else{echo $description - $wallet;} ?></h5>
        </div>
        <hr style="opacity: 0.2;">
        <div class="description-pay">
            <h6>
                برای نهایی کردن فاکتور باید کیف پول خود را به میزان مبلغ قابل پرداخت فاکتور شارژ نمایید.برای ادامه بر
                روی دکمه زیر کلیک نمایید .
            </h6>
            <form method="POST">
                <?php if($description >= $wallet){ ?>
                    <a href="wallet.php?amount=<?= $description ?>"><input type="submit" value="اول باید موجودیت رو افزایش بدی" class="btn" name="pay"></a>
                <?php }else{ ?>
                    <input type="submit" value="ادامه" class="btn" name="pay">
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<div class="container col-xl-9">
    <div class="information-pay-acount">
        <div style="display: flex; margin-bottom: 8px;">
            <b>عضویت ویژه در وبسایت</b>
        </div>
        <p>عضویت ویژه به سایت تاپ لرن افزوده شد. از این پس شما کاربران گرامی می‌توانید برای دسترسی به امکانات ویژه سایت،
            اشتراک ویژه را فراهم نمایید.

            با خرید اشتراک ویژه شما به عنوان کاربر VIP شناخته می‌شوید و می‌توانید از دوره های مخصوص اعضای ویژه به مدت یک
            ماه استفاده نمایید.</p>
    </div>
</div><br>


<?php include "footer.php" ?>
<?php if($error_inventory){ ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 6000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

Toast.fire({
    icon: 'error',
    title: 'موجودی کیف پول برای ارتقا به حساب ویژه کافی نیست'
})
</script>
<?php } ?>