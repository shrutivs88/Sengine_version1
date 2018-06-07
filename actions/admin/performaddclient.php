<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location:../login.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/LocationService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');

$locationService = new LocationService();
$clientService = new ClientService();
$company = new Company();
$contacts = array();
$errContacts= array();
$companyName = $_POST["companyName"];
$companyWebsite = $_POST["companyWebsite"];
$companyAddress = $_POST["companyAddress"];
$companyPhone = $_POST["companyPhone"];
$companyEmail = $_POST["companyEmail"];
$companyLinkedIn = $_POST["companyLinkedIn"];
if(isset($_POST["assignToBdm"])) {
    $assignToBdm = $_POST["assignToBdm"];
} else {
    /** bde's can set their manager in here */
    $assignToBdm = "";
}
if(isset($_POST["assignToBde"])) {
    $assignToBde = $_POST["assignToBde"];
} else {
    /** bde's can set their id in here */
    $assignToBde = "";
}
$clientTotalContacts = $_POST["clientTotalContacts"];
setCompanyDetails();
if(validateCompanyDetails()) {
    global $clientTotalContacts;
    if($clientService->checkCompanyWebsite($companyWebsite)) {
        $max_client_company_id = $clientService->saveCompany($company);
        if($clientTotalContacts > 0 || !empty($_FILES['contactsCSV']['name'])) {
            setContactDetails($max_client_company_id); 
            setContactDetailsFromCsv($max_client_company_id);
            saveContactDetails();
            if(count($errContacts) > 0) {
                $_SESSION['serverMsg'] = "Client Added Successfully But Some Contacts Were Not Added!";
                $_SESSION['serverData'] = $errContacts;
                header("Location:../../views/user/admin/failedcontacts.php");
                exit;
            }
        }
        $_SESSION['serverMsg'] = "Client Added Successfully!";
        header("Location:../../views/user/admin/clientcompanylist.php");
    } else {
        $_SESSION['serverMsg'] = "Client Company With This Website Is Already Uploaded";
        header("Location:../../views/user/admin/addclient.php");
    }
} else {
    header("Location:../../views/user/admin/addclient.php");
}

/**
 * Validate Compamny
 */
function validateCompanyDetails() {
    global $company;
    if($company->getName() == "" || $company->getWebsite() == "" || 
        $company->getAddress() == "" || $company->getPhone() == "" || 
            $company->getEmail() == "" || $company->getLinkedIn() == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($company->getWebsite()," ") !== false) || 
                (strrpos($company->getPhone()," ") !== false) || (strrpos($company->getEmail()," ") !== false) || 
                    (strrpos($company->getLinkedIn()," ") !== false)) {
                        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
                        return false;
    }
    return true;
}

/**
 * Set Company
 */
function setCompanyDetails() {
    global $company, $assignToBdm, $assignToBde;
    $company->setName($GLOBALS['companyName']);
    $company->setWebsite($GLOBALS['companyWebsite']);
    $company->setAddress($GLOBALS['companyAddress']);
    $company->setPhone($GLOBALS['companyPhone']);
    $company->setEmail($GLOBALS['companyEmail']);
    $company->setLinkedIn($GLOBALS['companyLinkedIn']);
    $company->setAssocManager($assignToBdm);
    $company->setAssocUser($assignToBde);
}

 /**
  * Validate Contacts
  */
function validateContactDetails($contact) {
    if($contact->getFirstName() == "" || $contact->getLastName() == "" || $contact->getEmail() == "" || 
        $contact->getCategory() == "" || $contact->getDesignation() == "" || $contact->getMobile() == "" || 
            $contact->getCity() === "" || $contact->getState() === "" || $contact->getCountry() === "" || 
                $contact->getAddress() == "" || $contact->getLinkedIn() == "" || $contact->getFacebook() == "" || 
                    $contact->getTwitter() == "") {
                        return ERR_BLANK;
                    }
                    return true;
}

/**
 * Set Contacts From Form
 */
function setContactDetails($client_company_id) {
    global $clientTotalContacts, $contacts, $assignToBdm, $assignToBde;
    for($i = 1; $i <= $clientTotalContacts; $i++) {
        $contact = new Contact();
        $contact->setFirstName($_POST['contact_form_'.$i.'_firstName']);
        $contact->setLastName($_POST['contact_form_'.$i.'_lastName']);
        $contact->setEmail($_POST['contact_form_'.$i.'_email']);
        $contact->setCategory($_POST['contact_form_'.$i.'_category']);
        $contact->setDesignation($_POST['contact_form_'.$i.'_designation']);
        $contact->setMobile($_POST['contact_form_'.$i.'_mobile']);
        $contact->setCountry($_POST['contact_form_'.$i.'_country']);
        $contact->setState($_POST['contact_form_'.$i.'_state']);
        $contact->setCity($_POST['contact_form_'.$i.'_city']);
        $contact->setAddress($_POST['contact_form_'.$i.'_address']);
        $contact->setLinkedIn($_POST['contact_form_'.$i.'_linkedin']);
        $contact->setFacebook($_POST['contact_form_'.$i.'_facebook']);
        $contact->setTwitter($_POST['contact_form_'.$i.'_twitter']);
        $contact->setCompany($client_company_id);
        $contact->setAssocManager($assignToBdm);
        $contact->setAssocUser($assignToBde);
        $contact->setEmailTimeout(24);
        array_push($contacts, $contact);
    }
}

/**
 * Set Contacts From CSV
 */

function setContactDetailsFromCsv($max_client_company_id) {
    global $contacts, $assignToBdm, $assignToBde, $locationService;
    $csvMimes =  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['contactsCSV']['name']) && in_array($_FILES['contactsCSV']['type'], $csvMimes)) {
        $contactsCSVFile = fopen($_FILES['contactsCSV']['tmp_name'], 'r');
        fgetcsv($contactsCSVFile);
        while(($data = fgetcsv($contactsCSVFile)) !== false) {
            $country = $locationService->getCountryByName($data[9]);
            $state = $locationService->getStateByName($data[8]);
            $city = $locationService->getCityByName($data[7]);
            $contact = new Contact();
            $contact->setCountry(0);
            $contact->setState(0);
            $contact->setCity(0);
            if($country->id != null) {
                $contact->setCountry($country->id);
            }
            if($state->id != null) {
                if($state->country == $country->id) {
                    $contact->setState($state->id);
                }
            }
            if($city->id != null) {
                if($city->country == $country->id && $city->state == $state->id) {
                    $contact->setCity($city->id);
                }
            }
            $contact->setFirstName($data[0]);
            $contact->setLastName($data[1]);
            $contact->setEmail($data[2]);
            $contact->setMobile($data[3]);
            $contact->setCategory($data[4]);
            $contact->setDesignation($data[5]);
            $contact->setAddress($data[6]);
            $contact->setLinkedIn($data[10]);
            $contact->setFacebook($data[11]);
            $contact->setTwitter($data[12]);
            $contact->setCompany($max_client_company_id);
            $contact->setAssocManager($assignToBdm);
            $contact->setAssocUser($assignToBde);
            $contact->setEmailTimeout(24);
            array_push($contacts, $contact);
        }
    }
 }

/**
 * Save Contacts
 */
function saveContactDetails() {
    global $contacts, $errContacts, $clientService;
    for($i = 0; $i < count($contacts); $i++) {
        $contactValidityStatus = validateContactDetails($contacts[$i]);
        if($contactValidityStatus === true) {
            if($clientService->checkContactEmail($contacts[$i]->getEmail())) {
                $clientService->saveContact($contacts[$i]);
            } else {
                array_push($errContacts, array("errContact"=>$contacts[$i], "errMsg"=>ERR_CONTACT_EXISTS));
            }
        } else {
            array_push($errContacts, array("errContact"=>$contacts[$i], "errMsg"=>$contactValidityStatus));
        }   
    }
}

?>