<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/RoleService.php');

$userService = new UserService();
$roleService = new RoleService();
$role = $roleService->getByRoleName("BDM");
$listOfBdms = $userService->getAllByRoleId($role->id);
header('Content-Type: application/json');
echo json_encode($listOfBdms);


?>