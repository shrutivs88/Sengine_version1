<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/Openssl.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/User.php');

class BdeService {

    private $databaseManager;
    private $openssl;
    private $connection;
    private $user;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->openssl = new Openssl();
        $this->connection = $this->databaseManager->getConnection();
        $this->user = new User();
    }

    /**
     * Unassign a bde
     */
    public function unassignBde($userId) {
        $stmt = $this->connection->prepare("update users set user_manager_id = 0 where user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Assign a bde 
     */
    public function assignBde($bdeId, $managerId) {
        $stmt = $this->connection->prepare("update users set user_manager_id = ? where user_id = ?");
        $stmt->bind_param("ii", $managerId, $bdeId);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Delete by user id
     */
    public function deleteById($userId) {
        $stmt = $this->connection->prepare("delete from users where user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

}