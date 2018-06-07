<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/MailConfig.php');

class MailConfigService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function getMailConfig() {
        $stmt = $this->connection->prepare("select * from mail_config");
        $stmt->execute();
        $res = $stmt->get_result();
        $mailConfig = new MailConfig();
        if($row = $res->fetch_assoc()) {
            $mailConfig->setMailConfigHost($row['mail_config_host']);
            $mailConfig->setMailConfigUserName($row['mail_config_user_name']);
            $mailConfig->setMailConfigPassword($row['mail_config_password']);
        }
        $stmt->close();
        return $mailConfig;
    }

    public function saveMailConfig($mailConfig) {
        $mailConfigHost = $mailConfig->getMailConfigHost();
        $mailConfigUserName = $mailConfig->getMailConfigUserName();
        $mailConfigPassword = $mailConfig->getMailConfigPassword();
        $stmt = $this->connection->prepare("insert into mail_config (mail_config_host, mail_config_user_name, mail_config_password) values (?, ?, ?)");
        $stmt->bind_param("sss", $mailConfigHost, $mailConfigUserName, $mailConfigPassword);
        $stmt->execute();
        $stmt->close();
    }

    public function updateMailConfig($mailConfig) {
        $mailConfigHost = $mailConfig->getMailConfigHost();
        $mailConfigUserName = $mailConfig->getMailConfigUserName();
        $mailConfigPassword = $mailConfig->getMailConfigPassword();
        $stmt = $this->connection->prepare("update mail_config set mail_config_host = ?, mail_config_user_name = ?, mail_config_password = ? limit 1");
        $stmt->bind_param("sss", $mailConfigHost, $mailConfigUserName, $mailConfigPassword);
        $stmt->execute();
        $stmt->close();
    }

    public function checkMailConfig() {
        $stmt = $this->connection->prepare("select * from mail_config");
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>