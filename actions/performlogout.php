<?php
session_start();
if(isset($_SESSION['email'])) {
    unset($_SESSION['role']);
    unset($_SESSION['email']);
    unset($_SESSION['userId']);
    if(isset($_SESSION["serverData"])) {
        unset($_SESSION['serverData']);
    }
}
header("Location: ../views/login.php");
?>