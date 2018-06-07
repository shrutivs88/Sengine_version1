<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/BdeService.php');

$bdeService = new BdeService();
$bdeId = $_POST["bdeId"];
$managerId = $_POST["managerId"];

$bdeService->assignBde($bdeId, $managerId);
$_SESSION['serverMsg'] = "BDE Was Assigned Successfully!";

?>