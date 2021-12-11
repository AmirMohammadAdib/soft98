function open_searche(){
    document.querySelector('#searche').style="opacity: 1;"
    document.querySelector('.icon-header').style="width: 30%;"
    document.querySelector('#icon_searche').style="background-color: #ffffff; border: 1px solid #ced4da; border-left: none;";

}
function down_searche(){
    document.querySelector('#searche').style="opacity: 0;"
    document.querySelector('.icon-header').style="width: 3%;"
    document.querySelector('#icon_searche').style="";

}
function open_login(){
    document.querySelector('.login-box').style="opacity: 1; width: 38%; height: 441px; margin-bottom: 62px;"

}
function exit_login(){
    document.querySelector('.login-box').style="opacity: 0;"
}
function open_profile(){
    document.querySelector('.box-profile').style = "opacity: 1;"
}
function exit_profile(){
    document.querySelector('.box-profile').style = "opacity: 0;"
}
function open_pay(){
    document.querySelector('#pay').style="opacity: 0";
}