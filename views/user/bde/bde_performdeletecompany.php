<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
  $data = new DatabaseManager();
  $conn = $data->getconnection();


$companyId = $_POST['companyId'];

$sql ="delete from client_companies where client_company_id='$companyId'";
$clientSql = "delete from client_contacts where client_company_id='$companyId'";
$res = mysqli_query($conn,$sql);
 mysqli_query($conn,$clientSql);

 if($res==true){
 $_SESSION['serverMsg'] = "<p class='text-center' style='color:green;'>Company and it's associated contacts are deleted Successfully!</p>";
 }else{
    $_SESSION['serverMsg'] = "<p class='text-center' style='color:red;'>Company and it's associated contacts are not deleted!</p>";
    return;
 }

?>