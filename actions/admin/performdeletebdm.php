<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/BdmService.php');

$bdmService = new BdmService();
$userId = $_POST['userId'];
$empId = $_POST['empId'];

$affected_rows = $bdmService->deleteById($userId, $empId);
if($affected_rows == 0) {
    $_SESSION['serverMsg'] = "You cannot delete this BDM: BDEs are still assigned!";
    return;
}
$_SESSION['serverMsg'] = "BDM was deleted Successfully!";

?>