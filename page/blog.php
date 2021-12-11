<?php 
include "../database/db.php";
include "header.php";
include "../script/jdf.php";

$id = $_GET['id'];
$profile = rand(1, 5);

$blog = $conn->prepare('SELECT * FROM blog WHERE id=?');
$blog->bindValue(1, $id);
$blog->execute();
$blog = $blog->fetch(PDO::FETCH_ASSOC);

$admin = $conn->prepare('SELECT username , id FROM users WHERE userlevel=1');
$admin->execute();
$admin = $admin->fetchAll(PDO::FETCH_ASSOC);

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


<div class="container all-content-blog col-xl-10">
    <div style="width: 68%;">
        <div class="content-course" style="margin-top: 20px; margin-bottom: 20px;">
            <div class="image">
                <img src="../image/poster-blog/<?= $blog['poster'] ?>" style="border-radius: 5px 5px 530px 5px;">
            </div>
            <div class="information-blog">
                <div class="profile-writer">
                    <img src="../image/profile/<?= $profile . ".png" ?>">
                </div>
                <div class="txt-information">
                    <div class="writer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                            <path
                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                        </svg>
                        <div class="name">
                            <p><?php foreach($admin as $ad){if($ad['id'] == $blog['writer']){echo $ad['username'];}} ?></p>
                        </div>
                    </div>
                    <div class="date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                            <path
                                d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                        </svg>
                        <div class="name">
                            <p><?= jdate('Y / n / j', $blog['date']) ?></p>
                        </div>
                    </div>
                    <div class="vio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                        </svg>
                        <div class="name">
                            <p>۲۵۳</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="titre">
                <h1><?= $blog['title'] ?></h1>
            </div>
            <div class="caption-blog">
                <p><?= $blog['content'] ?></p>
            </div>
        </div>
        <div class="video-course" style="padding-bottom: 1.2%;">
            <div class="comments">
                <div class="category-comment">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-receipt"
                        viewBox="0 0 16 16">
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
                    <input type="submit" value="ثبت نظر" class="btn btn-warning" style="width: 30%; margin-bottom: 10px;">
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
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک
                                    است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
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
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک
                                    است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
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
                                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک
                                    است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
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
        </div><br>
    </div>

    <div class="introduction-blog" style="width: 31%; margin-top: 20px; top: 90px; bottom: 20px; position: sticky;">
    <h1>لینک های مفید</h1><hr>
        <ul>
            <?php for($e=0; $e<15; $e++){ ?>
            <a href="#">
                <li>چند راه برای انجام پروژه بهتر فریلنسر</li>
            </a>
            <?php } ?>
        </ul>
    </div>
</div>



<?php include "footer.php" ?>