<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
  include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
  $data = new DatabaseManager();
  $conn = $data->getconnection();

  $user_Id = $_SESSION['userId'];
  $user="select user_emp_id from users where user_id=$user_Id";
  $contact_result = mysqli_query($conn,$user);
  $resfetch = mysqli_fetch_object($contact_result);
  $emp_id= $resfetch->user_emp_id;  
  
 // echo $emp_id;
  $companyId = $_POST['companyId'];
  
 // $contactSql = "SELECT * FROM client_contacts  where  client_company_id='$companyId'";
 //$result = mysqli_query($conn,$contactSql); 
 $bde_sql = "select * from client_contacts where assoc_user_id='$emp_id' and client_company_id='$companyId'";
  
  $result = mysqli_query($conn,$bde_sql); 
  //print_r ($result); 
  $rows = array();
  while($row = mysqli_fetch_assoc($result)){
      $rows[] = $row;
     }
     header('Content-Type: application/json');
     echo json_encode($rows);
     


?>
