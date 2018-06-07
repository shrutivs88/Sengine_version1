<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');
$userService = new UserService();
$fname = $_POST["fname"];
$email = $_POST["email"];
$originalEmail = $_POST["originalEmail"];
$password = $_POST["pass"];
$roleId = $_POST["roleId"];
$userId = $_POST["userId"];

if(validateDetails($fname, $email, $password, $roleId, $userId)) {
    if($userService->checkEmailAllowSelf($email, $originalEmail)) {
        $userService->updateUser($fname, $email, $password, $roleId, $userId);
        $_SESSION['serverMsg'] = "BDM Updated Successfully!";
        header("Location:../../views/user/admin/bdmlist.php");
    } else { 
        $_SESSION['serverMsg'] = "E-Mail ID Is Already Taken!";
        header("Location:../../views/user/admin/editbdm.php?roleId=".$roleId."&userId=".$userId);
    }
} else {
    header("Location:../../views/user/admin/editbdm.php?roleId=".$roleId."&userId=".$userId);
}

/**
 * Details Validation
 */
function validateDetails($fname, $email, $password, $roleId, $userId) {
    if($fname == "" || $email == "" || $password == "" || $roleId == "" || $userId == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($fname," ") !== false) || (strrpos($email," ") !== false) || (strrpos($password," ") !== false)|| (strrpos($roleId," ") !== false)|| (strrpos($userId," ") !== false)) {
        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
        return false;
    }
    return true;
}

?>