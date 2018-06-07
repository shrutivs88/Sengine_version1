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
$managerId = $_POST['managerId'];
$offset = $_POST['offset'];
$listOfBdes = $userService->getAllByManageIdAndOffset($managerId, $offset);
header('Content-Type: application/json');
echo json_encode($listOfBdes);


?>