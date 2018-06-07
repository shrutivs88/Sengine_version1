<?php
session_start();

  include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
  include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
  $clientService = new ClientService();
$companyId = $_POST['companyId'];

$companyDelete = $clientService->deleteCompanyByIdCascadeDeleteContacts($companyId);

?>