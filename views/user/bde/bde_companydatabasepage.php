<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getconnection();



$limit = $_POST["limitVal"];
$offset = $_POST["offsetVal"];
$companysql = "select * from client_companies  LIMIT $limit OFFSET $offset";
$res = mysqli_query($conn,$companysql);
$rows = array();
while($row = mysqli_fetch_assoc($res)){
    $rows[] = $row;
   }
   header('Content-Type: application/json');
   echo json_encode($rows);
  
?>
