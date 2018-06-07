<?php

class Mail{

    public $mailSubject;
    public $mailMessage;
    public $mailTo;
    public $mailFrom;
    public $attachment;
    /**
     * Getters
     */
   

    public function getMailSubject() {
        return $this->mailSubject;
    }

    public function getMailMessage() {
        return $this->mailMessage;
    }

    public function getMailTo() {
        return $this->mailTo;
    }

    public function getMailFrom() {
        return $this->mailFrom;
    }

    public function getMailAttachment() {
        return $this->mailAttachment;
    }

    
    /**
     * Setters
     */
    
    public function setMailSubject($mailSubject) {
        $this->mailSubject = $mailSubject;
    }

    public function setMailMessage($mailMessage) {
        $this->mailMessage = $mailMessage;
    }

    public function setMailTo($mailTo) {
        $this->mailTo = $mailTo;
    }

    public function setMailFrom($mailFrom) {
        $this->mailFrom = $mailFrom;
    }

    public function setMailAttachment($mailAttachment) {
        $this->mailAttachment = $mailAttachmentts;
    }


    
}

?>