<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
    $clientService = new ClientService();
$companyId = $_POST['companyId'];
$userId = $_SESSION['userId'];
$offset = $_POST["offsetVal"];
$listOfContactsforcompany = array();
$listOfContactsforcompany = $clientService->getContactsByOffsetforcompany($userId,$companyId,$offset);    
      
     header('Content-Type: application/json');
     echo json_encode($listOfContactsforcompany);   
?>