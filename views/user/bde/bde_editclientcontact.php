<?php

session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');

$data = new DatabaseManager();

$conn = $data->getconnection();



$clientId = $_POST['clientId'];

$clientFirstName = $_POST['clientFirstName'];

$clientLastName = $_POST['clientLastName'];

$clientEmail = $_POST['clientEmail'];

$clientMobile = $_POST['clientMobile'];

$clientCategory = $_POST['clientCategory'];

$clientDesignation = $_POST['clientDesignation'];

$clientAddress = $_POST['clientAddress'];

$clientCity = $_POST['clientCity'];

$clientState = $_POST['clientState'];

$clientCountry = $_POST['clientCountry'];

$clientLinkedInId = $_POST['clientLinkedInId'];

$clientFacebookId = $_POST['clientFacebookId'];

$clientTwitterId = $_POST['clientTwitterId'];

//$clientCompanyId = $_POST['clientCompanyId'];

//$clientDateTime = $_POST['clientDateTime'];



$sql = "update client_contacts set client_contact_first_name='$clientFirstName',client_contact_last_name='$clientLastName',client_contact_email='$clientEmail',client_contact_mobile='$clientMobile',client_contact_category='$clientCategory',client_contact_designation='$clientDesignation',client_contact_address='$clientAddress',city_id='$clientCity',state_id ='$clientState',country_id='$clientCountry',client_contact_linkedin='$clientLinkedInId',client_contact_facebook='$clientFacebookId',client_contact_twitter='$clientTwitterId' where client_contact_id='$clientId'";





$result = mysqli_query($conn,$sql);

 



if($result==true)

{

    $_SESSION['server-msg'] = "<p class='text-center' style='color:green; font-size:14px;'> Client Details edited successfuly</p>";



}else{



    $_SESSION['server-msg'] = "<p class='text-center' style='color:red; font-size:18px;'><h5> No Edit is done</h5></p>";

}



?>

