<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/Openssl.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/User.php');

class UserService {

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
     * Check if email exists
     */
    public function checkEmail($email) {
        $stmt = $this->connection->prepare("select * from users where user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check if email exists, allow same email id
     */
    public function checkEmailAllowSelf($email, $originalEmail) {
        if($email === $originalEmail) {
            return true;
        }
        $stmt = $this->connection->prepare("select * from users where user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Save new user
     */
    public function saveUser($fname, $email, $password, $role) {
        $this->connection->query("lock tables users write");
        $query = $this->connection->query("select max(user_emp_id) from users");
        $max_user_emp_id = $query->fetch_assoc()['max(user_emp_id)'];
        $user_emp_id = $max_user_emp_id + 1;
        $password = $this->openssl->encrypt($password);
        $stmt = $this->connection->prepare("insert into users (user_emp_id ,user_name, user_email, user_password, role_id) values (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $user_emp_id, $fname, $email, $password, $role);
        $stmt->execute();
        $stmt->close();
        $this->connection->query("unlock tables");
    }

    /**
     * Update existing user
     */
    public function updateUser($fname, $email, $password, $role, $userId) {
        $password = $this->openssl->encrypt($password);
        $stmt = $this->connection->prepare("update users set user_name = ?, user_email = ?, user_password = ?, role_id = ? where user_id = ?");
        $stmt->bind_param("sssii", $fname, $email, $password, $role, $userId);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Update profile [self]
     */
    public function updateProfile($fname, $email, $password, $userId) {
        $password = $this->openssl->encrypt($password);
        $stmt = $this->connection->prepare("update users set user_name = ?, user_email = ?, user_password = ? where user_id = ?");
        $stmt->bind_param("sssi", $fname, $email, $password, $userId);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Get user by user id
     */
    public function getUserById($userId) {
        $stmt = $this->connection->prepare("select * from users where user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = new User();
        if($row = $res->fetch_assoc()) {
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setPassword($this->openssl->decrypt($row['user_password']));
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
        }
        $stmt->close();
        return $user;
    }

    /**
     * Get user by emp id
     */
    public function getUserByEmpId($empId) {
        $stmt = $this->connection->prepare("select * from users where user_emp_id = ?");
        $stmt->bind_param("i", $empId);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = new User();
        if($row = $res->fetch_assoc()) {
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setPassword($this->openssl->decrypt($row['user_password']));
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
        }
        $stmt->close();
        return $user;
    }

    /**
     * Get all users by role id
     */
    public function getAllByRoleId($roleId) {
        $stmt = $this->connection->prepare("select * from users where role_id = ? order by user_id desc");
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfUsers = array();
        while($row = $res->fetch_assoc()) {
            $user = new User();
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setPassword($this->openssl->decrypt($row['user_password']));
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
            array_push($listOfUsers, $user);
        }
        $stmt->close();
        return $listOfUsers;
    }

    /**
     * Get all users by role id and offset
     */
    public function getAllByRoleIdAndOffset($roleId, $offset) {
        $limit = BDM_LIST_LIMIT;
        $stmt = $this->connection->prepare("select * from users where role_id = ? order by user_id desc limit ?,?");
        $stmt->bind_param("iii", $roleId, $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfUsers = array();
        while($row = $res->fetch_assoc()) {
            $user = new User();
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setPassword($this->openssl->decrypt($row['user_password']));
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
            array_push($listOfUsers, $user);
        }
        $stmt->close();
        return $listOfUsers;
    }

    public function getAllByManagerId($managerId) {
        $stmt = $this->connection->prepare("select * from users where user_manager_id = ?");
        $stmt->bind_param("i", $managerId);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfUsers = array();
        while($row = $res->fetch_assoc()) {
            $user = new User();
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setPassword($this->openssl->decrypt($row['user_password']));
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
            array_push($listOfUsers, $user);
        }
        $stmt->close();
        return $listOfUsers;
    }

    /**
     * Get all users by manager id and offset 
     */
    public function getAllByManageIdAndOffset($managerId, $offset) {
        $limit = BDM_LIST_LIMIT;
        $stmt = $this->connection->prepare("select * from users where user_manager_id = ? limit ?,?");
        $stmt->bind_param("iii", $managerId, $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfUsers = array();
        while($row = $res->fetch_assoc()) {
            $user = new User();
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setPassword($this->openssl->decrypt($row['user_password']));
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
            array_push($listOfUsers, $user);
        }
        $stmt->close();
        return $listOfUsers;
    }

    public function getCountByRoleId($roleId) {
        $query = $this->connection->query("select count(user_id) from users where role_id = '$roleId'");
        $count_users = $query->fetch_assoc()['count(user_id)'];
        return $count_users;
    }
    
//BDM SERVICES

    public function getBdesForBdm($user_Id,$offset){
        $limit = BDM_LIST_LIMIT;
        //$query = $this->connection->query("select user_emp_id from users where user_id= '$user_Id'")
        $stmt = $this->connection->prepare("select user_emp_id from users where user_id = ? ");
        $stmt->bind_param("i", $user_Id);
        $stmt->execute();
        $res = $stmt->get_result();
        //$listOfBdm = array();
        $result = $res->fetch_assoc();
        $empId = $result['user_emp_id'];
        $roleId = 3;
        $stmt_bdm = $this->connection->prepare("select * from users where user_manager_id = ? and role_id=? limit ?,? ");
        $stmt_bdm->bind_param("iiii",$empId,$roleId,$offset, $limit);
        $stmt_bdm->execute();
        $res_bdm = $stmt_bdm->get_result();
        $listOfBdms = array();
        while($row = $res_bdm->fetch_assoc()) {
            $user = new User();
            $user->setId($row['user_id']);
            $user->setEmpId($row['user_emp_id']);
            $user->setName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setRole($row['role_id']);
            $user->setManager($row['user_manager_id']);
            array_push($listOfBdms, $user);
        }
        $stmt_bdm->close();
        return $listOfBdms;
    }

}
?>