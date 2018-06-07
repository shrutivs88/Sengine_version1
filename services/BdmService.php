<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/Openssl.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/User.php');

class BdmService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function deleteById($userId, $empId) {
        $affected_rows = 0;
        $stmt = $this->connection->prepare("select * from users where user_manager_id = ?");
        $stmt->bind_param("i", $empId);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows === 0) {
            $stmt = $this->connection->prepare("delete from users where user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $affected_rows = $stmt->affected_rows;
        }
        $stmt->close();
        return $affected_rows;
    }

}