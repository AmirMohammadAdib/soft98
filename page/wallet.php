<?php 
include "../database/db.php";
include "header.php";

$slider = $conn->prepare('SELECT * FROM slider');
$slider->execute();
$slider = $slider->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['pay'])){
    $amount = $_POST['deposit_pay'];


    $data = [
        'pin' => 'aqayepardakht',
        'amount' => $amount,
        'callback' => 'http://localhost/project-web/page/verify.php?amount=' . $amount,
      ];
      
      $data = json_encode($data);
      $ch = curl_init('https://panel.aqayepardakht.ir/api/create');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLINFO_HEADER_OUT, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data))
      );
      $result = curl_exec($ch);
      curl_close($ch);
      if ($result && !is_numeric($result)) {
          header('Location: https://panel.aqayepardakht.ir/startpay/' . $result);
      } else {
          echo "خطا";
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

<div class="container col-xl-9">
    <div class="add-pay">
        <div class="header-add-pay">
            <h1>کیف پول</h1>
            <h4>موجودی شما : 500</h4>
        </div>
        <div class="note-add-pay">
            <p>مبلغ شارژ به تومان می باشد و لطفا دقت کنید مبلغ پرداختی به هیچ عنوان امکان استرداد ندارد .</p>
        </div><br>
        <div style="display: flex; justify-content: end; margin-right: 30px;">
            <div class="deposit">
                <div style="display: flex; justify-content: flex-start; opacity: 0.8;">
                    <label> مبلغ مورد نظر (تومان)</label>
                </div>
                <form method="POST">
                    <div class="inp">
                        <input type="number" name="deposit_pay" class="form-control" placeholder="مثلا (۵۰۰۰۰)" required>
                        <input type="submit" value="شارژ حساب" class="btn" name="pay">
                    </div>
                </form>
            </div>
        </div><br><br>
    </div>
</div><br>

<?php include "footer.php" ?>