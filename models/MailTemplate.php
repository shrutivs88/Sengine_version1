<?php

class MailTemplate {

    public $mailTemplateId;
    public $mailTemplateName;
    public $mailTemplateHeader;
    public $mailTemplateFooter;

    /**
     * Getters
     */
    public function getMailTemplateId() {
        return $this->mailTemplateId;
    }

    public function getMailTemplateName() {
        return $this->mailTemplateName;
    }

    public function getMailTemplateHeader() {
        return $this->mailTemplateHeader;
    }

    public function getMailTemplateFooter() {
        return $this->mailTemplateFooter;
    }
    
    /**
     * Setters
     */
    public function setMailTemplateId($mailTemplateId) {
        $this->mailTemplateId = $mailTemplateId;
    }

    public function setMailTemplateName($mailTemplateName) {
        $this->mailTemplateName = $mailTemplateName;
    }

    public function setMailTemplateHeader($mailTemplateHeader) {
        $this->mailTemplateHeader = $mailTemplateHeader;
    }

    public function setMailTemplateFooter($mailTemplateFooter) {
        $this->mailTemplateFooter = $mailTemplateFooter;
    }
    
}

?>