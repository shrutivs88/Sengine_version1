<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/AuthService.php');

/**
 * No Direct Access Allowed To Auth
 */
if($_SESSION['fromLogin'] === false) {
    header("Location: ../views/error/noaccess.php");
} else {
    $_SESSION['fromLogin'] = false;
}


/**
 * Authentication And Authorization Process
 */
$authService = new AuthService();
$email = $_POST['email'];
$password = $_POST['pass'];
if(validateCredentials($email, $password)) {
    $userId = $authService->performAuthentication($email, $password);
    if($userId !== false) {
        $_SESSION['role'] = $authService->performAuthorization();
        $_SESSION['email'] = $email;
        $_SESSION['userId'] = $userId;
        header("Location:../views/user/home.php");
        return;
    }
    header("Location:../views/login.php");
}

/**
 * Credentials Validations
 */
function validateCredentials($email, $password) {
    if($email == "" || $password == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($email," ") !== false) || (strrpos($password," ") !== false)) {
        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
        return false;
    }
    return true;
}

?>