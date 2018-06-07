<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
/*include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
  $data = new DatabaseManager();
  $conn = $data->getconnection();*/
  include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');

  $clientService = new ClientService();
  $companyId = $_POST['companyId'];
  $listOfContacts = $clientService->getContactsByCompanyId($companyId);
  
  
 /* 
  $contactSql = "SELECT * FROM client_contacts  where  client_company_id='$companyId'";
  
  $result = mysqli_query($conn,$contactSql); 
 
  $rows = array();
  while($row = mysqli_fetch_assoc($result)){
      $rows[] = $row;
     }*/
     header('Content-Type: application/json');
     echo json_encode($listOfContacts);
     
?>