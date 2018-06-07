<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/RoleService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');

$roleService = new RoleService();
$userService = new UserService();
$clientService = new ClientService();

$bdmRole = $roleService->getByRoleName("BDM");
$bdeRole = $roleService->getByRoleName("BDE");

$count_bdms = $userService->getCountByRoleId($bdmRole->getId());
$count_bdes = $userService->getCountByRoleId($bdeRole->getId());
$count_client_companies = $clientService->getCountOfCompanies();
$count_client_contacts = $clientService->getCountOfContacts();

$response = new stdClass();
$response->bdmsCount = $count_bdms;
$response->bdesCount = $count_bdes;
$response->clientCompaniesCount = $count_client_companies;
$response->clientContactsCount = $count_client_contacts;

header('Content-Type: application/json');
echo json_encode($response);

//$userService->getCountByRoleId();

?>