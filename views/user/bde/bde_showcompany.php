<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
  $data = new DatabaseManager();
  $conn = $data->getconnection();


  $companyId = $_POST["companyId"];
$sql ="select * from client_companies where client_company_id='$companyId'";

$res = mysqli_query($conn,$sql);
$response = new stdClass();
if($row = mysqli_fetch_object($res))
{   
   //echo " $CompanyName = $row->companyName";
    //$userEmpId  = $row->user_emp_id;
    $response->companyId = $row->client_company_id;
    $response->companyName = $row->client_company_name;
    $response->companyWebsite = $row->client_company_website;
    $response->companyEmail = $row->client_company_email;
    $response->companyPhone = $row->client_company_phone;
    $response->companyLinkedIn = $row->client_company_linkedin;
    $response->companyAddress = $row->client_company_address;
   
}

header('Content-Type: application/json');
echo json_encode($response);



  ?>
