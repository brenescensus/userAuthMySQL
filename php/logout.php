<?php
function logout(){
if(isset($_SESSION['fullnames'])){
    $_SESSION=array();
    unset($_SESSION);
    session_destroy();
    header(location:'login.php');
}
}
logout();