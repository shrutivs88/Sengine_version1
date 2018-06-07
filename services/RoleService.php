<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Role.php');

class RoleService {

    private $databaseManager;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function getByRoleName($roleName) {
        $stmt = $this->connection->prepare("select * from roles where role_name = ?");
        $stmt->bind_param("s", $roleName);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $role = new Role();
        $role->setId($row["role_id"]);
        $role->setName($row["role_name"]);
        return $role;
    }
}
?>