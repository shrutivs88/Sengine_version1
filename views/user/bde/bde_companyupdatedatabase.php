<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getconnection();

$companyId=$_POST['companyId'];
$companyName=$_POST['companyName'];
$companyWebsite=$_POST['companyWebsite'];
$companyEmail=$_POST['companyEmail'];
$companyPhone=$_POST['companyPhone'];
$companyLinkedIn=$_POST['companyLinkedIn'];
$companyAddress=$_POST['companyAddress'];

$sql ="update client_companies set client_company_name='$companyName',client_company_website='$companyWebsite', client_company_email='$companyEmail',client_company_phone='$companyPhone',client_company_linkedin='$companyLinkedIn',client_company_address='$companyAddress' where client_company_id='$companyId'";
mysqli_query($conn, $sql);
exit();



?>


