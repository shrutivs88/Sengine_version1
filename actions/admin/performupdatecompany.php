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
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
$clientService = new ClientService();
$company = new Company();
$companyOriginalWebsite = $_POST['companyOriginalWebsite'];

setCompanyDetails();
saveCompanyDetails();

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

function saveCompanyDetails() {
    global $clientService, $company, $companyOriginalWebsite;
    $contactValidityStatus = validateCompanyDetails();
    if($contactValidityStatus === true) {
        if($clientService->checkCompanyWebsiteAllowSelf($company->getWebsite(), $companyOriginalWebsite)) {
            $clientService->updateCompany($company);
            $_SESSION['serverMsg'] = "Client Company Updated Successfully!";
            header("Location:../../views/user/admin/clientcompanylist.php");
            exit;
        } else {
            $_SESSION['serverMsg'] = ERR_COMPANY_EXISTS;
            header("Location:../../views/user/admin/showcontact.php?companyId=".$company->getId());
            exit;
        }
    } else {
        $_SESSION['serverMsg'] = $contactValidityStatus;
        header("Location:../../views/user/admin/showcontact.php?companyId=".$company->getId());
        exit;
    }
}

function validateCompanyDetails() {
    global $company;
    if($company->getName() == "" || $company->getWebsite() == "" || 
        $company->getAddress() == "" || $company->getPhone() == "" || 
            $company->getEmail() == "" || $company->getLinkedIn() == "") {
        return ERR_BLANK;
    } else if((strrpos($company->getWebsite()," ") !== false) || (strrpos($company->getAddress()," ") !== false) || 
                (strrpos($company->getPhone()," ") !== false) || (strrpos($company->getEmail()," ") !== false) || 
                    (strrpos($company->getLinkedIn()," ") !== false)) {
                        return ERR_WHITESPACE;
    }
    return true;
}

?>