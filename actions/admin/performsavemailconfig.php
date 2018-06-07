<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/MailConfigService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/MailConfig.php');

$mailConfigService = new MailConfigService();

$mailConfigHost = $_POST['mailConfigHost'];
$mailConfigUserName = $_POST['mailConfigUserName'];
$mailConfigPassword = $_POST['mailConfigPassword'];

if(validateDetails($mailConfigHost, $mailConfigUserName, $mailConfigPassword)) {
    $mailConfig = new MailConfig();
    $mailConfig->setMailConfigHost($mailConfigHost);
    $mailConfig->setMailConfigUserName($mailConfigUserName);
    $mailConfig->setMailConfigPassword($mailConfigPassword);
    if($mailConfigService->checkMailConfig()) {
        $mailConfigService->saveMailConfig($mailConfig);
    } else {
        $mailConfigService->updateMailConfig($mailConfig);
    }
    $_SESSION['serverMsg'] = "Mail Config Saved Successfully!";
}
header("Location:../../views/user/admin/mailsetup.php");
exit();

/**
 * Details Validation
 */
function validateDetails($mailConfigHost, $mailConfigUserName, $mailConfigPassword) {
    if($mailConfigHost == "" || $mailConfigUserName == "" || $mailConfigPassword == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($mailConfigHost," ") !== false) || (strrpos($mailConfigUserName," ") !== false) || (strrpos($mailConfigPassword," ") !== false)) {
        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
        return false;
    }
    return true;
}

?>