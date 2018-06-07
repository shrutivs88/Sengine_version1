<?php
session_start();
/*include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getconnection();*/
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
$clientService = new ClientService();
$company = new Company();

setCompanyDetails();


function setCompanyDetails() {
    global $company;
    $company->setId($_POST["companyId"]);
    $company->setName($_POST["companyName"]);
    $company->setWebsite($_POST["companyWebsite"]);
    $company->setAddress($_POST["companyAddress"]);
    $company->setPhone($_POST["companyPhone"]);
    $company->setEmail($_POST["companyEmail"]);
    $company->setLinkedIn($_POST["companyLinkedIn"]);
}


       
$companyUpdate = $clientService->updateCompany($company);
/*$companyId=$_POST['companyId'];
$companyName=$_POST['companyName'];
$companyWebsite=$_POST['companyWebsite'];
$companyEmail=$_POST['companyEmail'];
$companyPhone=$_POST['companyPhone'];
$companyLinkedIn=$_POST['companyLinkedIn'];
$companyAddress=$_POST['companyAddress'];

$sql ="update client_companies set client_company_name='$companyName',client_company_website='$companyWebsite', client_company_email='$companyEmail',client_company_phone='$companyPhone',client_company_linkedin='$companyLinkedIn',client_company_address='$companyAddress' where client_company_id='$companyId'";
mysqli_query($conn, $sql);
exit();
*/





?>


