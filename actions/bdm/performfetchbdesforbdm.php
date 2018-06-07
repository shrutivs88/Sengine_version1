<?php
session_start();


include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');

    $userService = new UserService();
    $user_Id = $_POST['userid'];
    $offset = $_POST["offsetVal"];
         
    $listOfBdes = $userService->getBdesForBdm($user_Id,$offset);
       
         header('Content-Type: application/json');
         echo json_encode($listOfBdes);   
?>
