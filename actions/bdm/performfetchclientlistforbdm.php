<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
    $clientService = new ClientService();
    //$data = new DatabaseManager();
    //$conn = $data->getConnection();
    $user_Id = $_POST['userid'];
$offset = $_POST["offsetVal"];
$listOfContactsforbdm = array();
$listOfContactsforbdm = $clientService->getContactsByOffsetforbdm($user_Id,$offset);   
        
header('Content-Type: application/json');
echo json_encode($listOfContactsforbdm);   
?>