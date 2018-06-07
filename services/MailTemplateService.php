<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/MailTemplate.php');

class MailTemplateService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function checkTemplateName($mailTemplateName) {
        $stmt = $this->connection->prepare("select * from mail_templates where mail_template_name = ?");
        $stmt->bind_param("s", $mailTemplateName);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkTemplateNameAllowSelf($mailTemplateName, $originalMailTemplateName) {
        if($mailTemplateName === $originalMailTemplateName) {
            return true;
        }
        $stmt = $this->connection->prepare("select * from mail_templates where mail_template_name = ?");
        $stmt->bind_param("s", $mailTemplateName);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveTemplate($mailTemplate) {
        $mailTemplateName = $mailTemplate->getMailTemplateName();
        $mailTemplateHeader = $mailTemplate->getMailTemplateHeader();
        $mailTemplateFooter = $mailTemplate->getMailTemplateFooter();
        $stmt = $this->connection->prepare("insert into mail_templates (mail_template_name, mail_template_header, mail_template_footer) values (?, ?, ?)");
        $stmt->bind_param("sss", $mailTemplateName, $mailTemplateHeader, $mailTemplateFooter);
        $stmt->execute();
        $stmt->close();
    }

    public function updateTemplate($mailTemplate) {
        $mailTemplateId = $mailTemplate->getMailTemplateId();
        $mailTemplateName = $mailTemplate->getMailTemplateName();
        $mailTemplateHeader = $mailTemplate->getMailTemplateHeader();
        $mailTemplateFooter = $mailTemplate->getMailTemplateFooter();
        $stmt = $this->connection->prepare("update mail_templates set mail_template_name = ?, mail_template_header = ?, mail_template_footer = ? where mail_template_id = ?");
        $stmt->bind_param("sssi", $mailTemplateName, $mailTemplateHeader, $mailTemplateFooter, $mailTemplateId);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllTemplates() {
        $stmt = $this->connection->prepare("select * from mail_templates");
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfTemplates = array();
        while($row = $res->fetch_assoc()) {
            $mailTemplate = new MailTemplate();
            $mailTemplate->setMailTemplateId($row['mail_template_id']);
            $mailTemplate->setMailTemplateName($row['mail_template_name']);
            $mailTemplate->setMailTemplateHeader($row['mail_template_header']);
            $mailTemplate->setMailTemplateFooter($row['mail_template_footer']);
            array_push($listOfTemplates, $mailTemplate);
        }
        $stmt->close();
        return $listOfTemplates;
    }

    public function deleteTemplateById($mailTemplateId) {
        $stmt = $this->connection->prepare("delete from mail_templates where mail_template_id = ?");
        $stmt->bind_param("i", $mailTemplateId);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

}

?>