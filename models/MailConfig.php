<?php

class MailConfig {

    public $mailConfigHost;
    public $mailConfigUserName;
    public $mailConfigPassword;

    /**
     * Getters
     */
    public function getMailConfigHost() {
        return $this->mailConfigHost;
    }

    public function getMailConfigUserName() {
        return $this->mailConfigUserName;
    }

    public function getMailConfigPassword() {
        return $this->mailConfigPassword;
    }
    
    /**
     * Setters
     */
    public function setMailConfigHost($mailConfigHost) {
        $this->mailConfigHost = $mailConfigHost;
    }

    public function setMailConfigUserName($mailConfigUserName) {
        $this->mailConfigUserName = $mailConfigUserName;
    }

    public function setMailConfigPassword($mailConfigPassword) {
        $this->mailConfigPassword = $mailConfigPassword;
    }

}

?>