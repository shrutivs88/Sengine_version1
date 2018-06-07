<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/MailTemplateService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/MailTemplate.php');

$mailTemplateService = new MailTemplateService();

$templateName = $_POST['templateName'];
$templateHeader = $_POST['templateHeader'];
$templateFooter = $_POST['templateFooter'];

if(validateDetails($templateName, $templateHeader, $templateFooter)) {
    $mailTemplate = new MailTemplate();
    $mailTemplate->setMailTemplateName($templateName);
    $mailTemplate->setMailTemplateHeader($templateHeader);
    $mailTemplate->setMailTemplateFooter($templateFooter);
    $_SESSION['serverMsg'] = "Failed To Add Template: Mail Template Already Exists !";
    if($mailTemplateService->checkTemplateName($templateName)) {
        $mailTemplateService->saveTemplate($mailTemplate);
        $_SESSION['serverMsg'] = "Mail Template Saved Successfully !";
    }
}
header("Location:../../views/user/admin/addmailtemplate.php");
exit();

/**
 * Details Validation
 */
function validateDetails($templateName, $templateHeader, $templateFooter) {
    if($templateName == "" || $templateHeader == "" || $templateFooter == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    }
    return true;
}

?>