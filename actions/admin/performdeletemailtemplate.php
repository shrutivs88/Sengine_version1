<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/MailTemplateService.php');

$mailTemplateService = new MailTemplateService();
$mailTemplateId = $_POST['mailTemplateId'];

$affected_rows = $mailTemplateService->deleteTemplateById($mailTemplateId);
if($affected_rows == 0) {
    $_SESSION['serverMsg'] = "Template was not deleted!";
    return;
}
$_SESSION['serverMsg'] = "Template was deleted Successfully!";

?>