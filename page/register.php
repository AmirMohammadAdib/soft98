<?php 
include "../database/db.php";
include "header.php"; 

$error_pass = null;
$error_user = null;
$error_fild = null;

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $rpass = $_POST['retry_pass'];

    $user = $conn->prepare('SELECT * FROM users WHERE email=?');
    $user->bindValue(1, $email);
    $user->execute();

    if(!empty($_POST['email']) & !empty($_POST['username']) & !empty($_POST['pass']) & !empty($_POST['retry_pass'])){
        if($user->rowCount() <= 0){
            if($pass == $rpass){
                $add_user = $conn->prepare('INSERT INTO users SET username=? , email=? , pass=?');
                $add_user->bindValue(1, $username);
                $add_user->bindValue(2, $email);
                $add_user->bindValue(3, $pass);
            
                $add_user->execute();
                header('location: ../index.php');

                $_SESSION['login'] = true;
                $_SESSION['name'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                $_SESSION['userlevel'] = 0;

            }else{
                $error_pass = true;
            }
        }else{
            $error_user = true;
        }
    }else{
        $error_fild = true;
    }
}

?>
<div class="container">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="box-register">
            <div class="titre-register">
                <h1>ثبت نام</h1>
            </div><br>
            <div class="foem">
                <form method="POST">
                    <input type="text" name="username" class="form-control username"
                        placeholder="نام کاربری خود را وارد کنید"><br>
                    <input type="email" name="email" class="form-control username"
                        placeholder="ایمیل خود را وارد کنید"><br>
                    <input type="password" name="pass" class="form-control username"
                        placeholder="پسوورد خود را وارد کنید"><br>
                    <input type="password" name="retry_pass" class="form-control username"
                        placeholder="تکرار پسوورد"><br>
                    <div style="display: flex; justify-content: end; flex-direction: row-reverse;">
                        <input type="submit" value="ثبت نام" class="btn btn-outline-primary" id="btn"
                            style="border: 2px solid #459cb0;" name="register">
                        <input type="submit" value="ورود" class="btn btn-primary"
                            style="margin-right: 8px; background-color: #459cb0; color: #ffffff;">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div><br><br><br>

<?php include "footer.php"; ?>

<?php if($error_pass){ ?>
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
    title: 'رمز عبور باهم یکسان نیست'
})
</script>
<?php } ?>
<?php if($error_user){ ?>
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
    title: 'کاربری با همچین مشخصاتی وجود داره'
})
</script>
<?php } ?>
<?php if($error_fild){ ?>
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
    title: 'فیلد های مشخص شده رو کامل کنید'
})
</script>
<?php } ?>