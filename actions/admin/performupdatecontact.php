<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');
$clientService = new ClientService();
$contact = new Contact();
$originalEmail = $_POST["contact-original-email"];
setContactDetails();
saveContactDetails();

function setContactDetails() {
    global $contact;
    $contact->setId($_POST['contact-id']);
    $contact->setFirstName($_POST['contact-first-name']);
    $contact->setLastName($_POST['contact-last-name']);
    $contact->setEmail($_POST['contact-email']);
    $contact->setCategory($_POST['contact-category']);
    $contact->setDesignation($_POST['contact-designation']);
    $contact->setMobile($_POST['contact-mobile']);
    $contact->setCountry($_POST['contact-country']);
    $contact->setState($_POST['contact-state']);
    $contact->setCity($_POST['contact-city']);
    $contact->setAddress($_POST['contact-address']);
    $contact->setLinkedIn($_POST['contact-linkedin']);
    $contact->setFacebook($_POST['contact-facebook']);
    $contact->setTwitter($_POST['contact-twitter']);
}

function saveContactDetails() {
    global $clientService, $contact, $originalEmail;
    $contactValidityStatus = validateContactDetails();
    if($contactValidityStatus === true) {
        if($clientService->checkContactEmailAllowSelf($contact->getEmail(), $originalEmail)) {
            $clientService->updateContact($contact);
            $_SESSION['serverMsg'] = "Client Contact Updated Successfully!";
            header("Location:../../views/user/admin/clientcontactlist.php");
            exit;
        } else {
            $_SESSION['serverMsg'] = ERR_CONTACT_EXISTS;
            header("Location:../../views/user/admin/showcontact.php?contactId=".$contact->getId());
            exit;
        }
    } else {
        $_SESSION['serverMsg'] = $contactValidityStatus;
        header("Location:../../views/user/admin/showcontact.php?contactId=".$contact->getId());
        exit;
    }
}

function validateContactDetails() {
    global $contact;
    if($contact->getFirstName() == "" || $contact->getLastName() == "" || $contact->getEmail() == "" || 
        $contact->getCategory() == "" || $contact->getDesignation() == "" || $contact->getMobile() == "" || 
            $contact->getCity() == "" || $contact->getState() == "" || $contact->getCountry() == "" || 
                $contact->getAddress() == "" || $contact->getLinkedIn() == "" || $contact->getFacebook() == "" || 
                    $contact->getTwitter() == "") {
                        return ERR_BLANK;
                    }
                    return true;
}

?>