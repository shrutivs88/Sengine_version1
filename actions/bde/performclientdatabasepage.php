<?php
session_start();
/*include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getconnection();*/
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/LocationService.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');

//$locationService = new LocationService();
$clientService = new ClientService();

$contact = new Contact();


$userId = $_SESSION["userId"];

$offset = $_POST['offsetVal'];


$fetchclient = $clientService->fetchclientdata($userId,$offset);
       
//var_dump($fetchclient);
//die;
header('Content-Type: application/json');
echo json_encode($fetchclient);



/*
//LIMIT $limit OFFSET $offset
$mang = "select user_emp_id from users where user_id ='$userId'";

$mang_query= mysqli_query($conn,$mang);

if($row = mysqli_fetch_object($mang_query)){

  $userEmpId  = $row->user_emp_id;
 
}
$sql = "SELECT * FROM client_contacts where assoc_user_id ='$userEmpId' LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn,$sql);

$rows = array();
while($res = mysqli_fetch_assoc($result)){
    $rows[] = $res;
   
}
header('Content-Type: application/json');
echo json_encode($rows);*/
 
?>
