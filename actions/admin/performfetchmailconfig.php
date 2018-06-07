<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/MailConfigService.php');
$mailConfigService = new MailConfigService();
$mailConfig = $mailConfigService->getMailConfig();
header('Content-Type: application/json');
echo json_encode($mailConfig);


?>