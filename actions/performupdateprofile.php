<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location:../login.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');
$userService = new UserService();
$fname = $_POST["fname"];
$email = $_POST["email"];
$password = $_POST["pass"];
$originalEmail = $_POST["originalEmail"];
$userId = $_POST["userId"];

if(validateDetails($fname, $email, $password, $userId)) {
    if($userService->checkEmailAllowSelf($email, $originalEmail)) {
        $userService->updateProfile($fname, $email, $password, $userId);
        $_SESSION['serverMsg'] = "Profile Updated Successfully! Login Again";
        header("Location:performlogout.php");
    } else { 
        $_SESSION['serverMsg'] = "E-Mail ID Is Already Taken!";
        header("Location:../views/user/editprofile.php?&userId=".$userId);
    }
} else {
    header("Location:../views/user/editprofile.php?&userId=".$userId);
}

/**
 * Details Validation
 */
function validateDetails($fname, $email, $password, $userId) {
    if($fname == "" || $email == "" || $password == "" || $userId == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($fname," ") !== false) || (strrpos($email," ") !== false) || (strrpos($password," ") !== false)|| (strrpos($userId," ") !== false)) {
        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
        return false;
    }
    return true;
}

?>