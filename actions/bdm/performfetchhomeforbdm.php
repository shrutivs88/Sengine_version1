<?php
session_start();
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
    $data = new DatabaseManager();
    $conn = $data->getConnection();
    $user_Id = $_POST['userid'];

          $sql_bdm = "select user_emp_id from users where user_id='$user_Id'";  
          $res_bdm = mysqli_query($conn, $sql_bdm);
          $result_bdm = mysqli_fetch_object($res_bdm);
          $bdm_emp_id = $result_bdm->user_emp_id;
           $bde_bdm_count=array();
          $sql_client_count = "select * from client_contacts where assoc_manager_id='$bdm_emp_id'";  
          $res_client_count = mysqli_query($conn, $sql_client_count);
          $result_client_count = mysqli_num_rows($res_client_count);
          //echo $result_client_count;
           array_push($bde_bdm_count,$result_client_count);
          $sql_bde_count = "select * from users where user_manager_id='$bdm_emp_id'";  
          $res_bde_count = mysqli_query($conn, $sql_bde_count);
          $result_bde_count = mysqli_num_rows($res_bde_count);
          array_push($bde_bdm_count,$result_bde_count);
           //echo $result_bde_count;
         
         header('Content-Type: application/json');
         echo json_encode($bde_bdm_count);   
?>