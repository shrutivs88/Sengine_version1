<?php

session_start();

/*include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getconnection();
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');


$clientService = new ClientService();
$contact = new Contact();
$clientId = $_POST['clientId'];

setContactDetails();


function setContactDetails(){
    global $contact;
    $contact->setId($_POST['clientId']);
    $contact->setFirstName($_POST['clientFirstName']);
    $contact->setLastName($_POST['clientLastName']);
    $contact->setEmail($_POST['clientEmail']);
    $contact->setCategory($_POST['clientCategory']);
    $contact->setDesignation($_POST['clientDesignation']);
    $contact->setMobile($_POST['clientMobile']);
    $contact->setCountry($_POST['clientCountry']);
    $contact->setState($_POST['clientState']);
    $contact->setCity($_POST['clientCity']);
    $contact->setAddress($_POST['clientAddress']);
    $contact->setLinkedIn($_POST['clientLinkedInId']);
    $contact->setFacebook($_POST['clientFacebookId']);
    $contact->setTwitter($_POST['clientTwitterId']);

}
/*
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
$clientTwitterId = $_POST['clientTwitterId'];*/


$updateOfContacts = $clientService->updateContactsByContactId($clientId,$contact);
 
if($updateOfContacts==true)
{
 $_SESSION['server-msg'] = "<p class='text-center' style='color:green; font-size:14px;'> Client Details updated successfuly</p>";
}else{

 $_SESSION['server-msg'] = "<p class='text-center' style='color:red; font-size:18px;'> No Edit is done</p>";
}



header('Content-Type: application/json');
echo json_encode($updateOfContacts);




//$clientCompanyId = $_POST['clientCompanyId'];

//$clientDateTime = $_POST['clientDateTime'];
/*
$sql = "update client_contacts set client_contact_first_name='$clientFirstName',client_contact_last_name='$clientLastName',client_contact_email='$clientEmail',client_contact_mobile='$clientMobile',client_contact_category='$clientCategory',client_contact_designation='$clientDesignation',client_contact_address='$clientAddress',city_id='$clientCity',state_id ='$clientState',country_id='$clientCountry',client_contact_linkedin='$clientLinkedInId',client_contact_facebook='$clientFacebookId',client_contact_twitter='$clientTwitterId' where client_contact_id='$clientId'";
$result = mysqli_query($conn,$sql);
if($result==true)
{
 $_SESSION['server-msg'] = "<p class='text-center' style='color:green; font-size:18px;'> Client Details edited successfuly</p>";
}else{

 $_SESSION['server-msg'] = "<p class='text-center' style='color:red; font-size:18px;'> No Edit is done</p>";
}
*/
?>

