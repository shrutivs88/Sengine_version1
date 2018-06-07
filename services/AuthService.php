<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/Openssl.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/User.php');

class AuthService {

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
     * User Authentication Subroutine
     */
    public function performAuthentication($email, $password) {
        $userId = ""; 
        $stmt = $this->connection->prepare("select * from users where user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();   
        if($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $decrypted_password = $this->openssl->decrypt($row["user_password"]);
            if($password == $decrypted_password) {
                $this->user->setId($row["user_id"]);
                $this->user->setName($row["user_name"]);
                $this->user->setEmail($row["user_email"]);
                $this->user->setPassword($row["user_password"]);
                $this->user->setRole($row["role_id"]);
                return $row["user_id"];
            }
            $_SESSION['serverMsg'] = "E-Mail ID And Password Didn't Match!";
            return false;
        } else {
            $_SESSION['serverMsg'] = "E-Mail ID Is Not Registered!";
            return false;
        }
    }

    /**
     * User Authorization Subroutine
     */
    public function performAuthorization() {
        $stmt = $this->connection->prepare("select * from roles where role_id = ?");
        $role = $this->user->getRole();
        $stmt->bind_param("i", $role);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row["role_name"];
    }

}
?>