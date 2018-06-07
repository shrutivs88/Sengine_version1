<?php
session_start();
    
//include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
    $clientService = new ClientService();
    $bdeempid = $_POST['bdeempid'];
    $offset = $_POST["offsetVal"];
    $listOfContactsforbde = array();
    $listOfContactsforbde = $clientService->getContactsByOffsetforbde($bdeempid,$offset);     
        
         header('Content-Type: application/json');
         echo json_encode($listOfContactsforbde);   
?>