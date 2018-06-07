<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');

  include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
  $clientService = new ClientService();
$clientId = $_POST["clientId"];

$clientContact = $clientService->getContactById($clientId);     
        


header('Content-Type: application/json');
echo json_encode($clientContact);



  ?>