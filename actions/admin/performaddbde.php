<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/RoleService.php');

$userService = new UserService();
$roleService = new RoleService();
$role = $roleService->getByRoleName("BDE");
$fname = $_POST['fname'];
$email = $_POST['email'];

if(validateDetails($fname, $email)) {
    if($userService->checkEmail($email)) {
        $userService->saveUser($fname, $email, DEFAULT_PASSWORD, $role->getId());
        $_SESSION['serverMsg'] = "BDE Registered Successfully!";
        header("Location:../../views/user/admin/bdelist.php");
    } else { 
        $_SESSION['serverMsg'] = "E-Mail ID Is Already Taken!";
        header("Location:../../views/user/admin/addbde.php");
    }
} else {
    header("Location:../../views/user/admin/addbde.php");
}

/**
 * Details Validation
 */
function validateDetails($fname, $email) {
    if($fname == "" || $email == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($fname," ") !== false) || (strrpos($email," ") !== false)) {
        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
        return false;
    }
    return true;
}

?>