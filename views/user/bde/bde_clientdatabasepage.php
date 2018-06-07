<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getconnection();
$userId = $_SESSION["userId"];

$limit = $_POST["limitVal"];
$offset = $_POST["offsetVal"];
//LIMIT $limit OFFSET $offset
$mang = "select user_emp_id from users where user_id ='$userId'";

//$mang = "select user_manager_id from users where user_id = '$userId'";
$mang_query= mysqli_query($conn,$mang);

//if($row = $mang_query->fetch_assoc())
if($row = mysqli_fetch_object($mang_query)){
 // $userManagerId  = $row->user_manager_id;
  $userEmpId  = $row->user_emp_id;
 
}
$sql = "SELECT * FROM client_contacts where assoc_user_id ='$userEmpId' LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn,$sql);
 //var_dump($result);
 //die;
$rows = array();
while($res = mysqli_fetch_assoc($result)){
    $rows[] = $res;
   
}
header('Content-Type: application/json');
echo json_encode($rows);
 
?>
