<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
  $data = new DatabaseManager();
  $conn = $data->getconnection();

  $userId = $_SESSION["userId"];
  $companyId = $_GET['companyId'];

  if(function_exists('date_default_timezone_set')) 
  {
  date_default_timezone_set("Asia/Kolkata");
  $php_timestamp_date = date("Y-m-d H:i:s");

  }

  //$companyWebSql="SELECT DISTINCT client_company_website from client_companies";
//$companyWebQuery = mysqli_query($conn,$companyWebSql);
     $email= array();
  $clientFirstName = $_POST['clientFirstName'];  
  $clientLastName = $_POST['clientLastName'];
   $Email = $_POST["clientEmail"];
   $Email2 = $_POST["clientEmail2"];
   $Email3 = $_POST["clientEmail3"];
      array_push($email,$Email);
              if(isset($Email2)&&($Email3)){
                array_push($email,$Email2,$Email3);
                $clientEmail = implode(',',$email);
              }else{
                array_push($email,$Email2);
                $clientEmail = implode(',',$email);
              }
             // var_dump($clientEmail);
             // die;
  $clientMobile = $_POST["clientMobile"];
  $clientCategory =$_POST["clientCategory"];
  $clientDesignation = $_POST["clientDesignation"];
  $clientAddress = $_POST["clientAddress"];
  $clientCountry = $_POST["clientCountry"];
  $clientState = $_POST["clientState"];
  $clientCity =$_POST["clientCity"];
  $clientLinkedInId = $_POST["clientLinkedInId"];
  $clientFacebookId = $_POST["clientFacebookId"];
  $clientTwitterId = $_POST["clientTwitterId"];
  $clientCompanyId = $_POST["companyId"];
  $clientCompanyName = $_POST["companyName"];


  //run query and get manager id and employeej is
  $mang = "select * from users where user_id ='$userId'";
  $mang_query= mysqli_query($conn,$mang);
  if($row = mysqli_fetch_object($mang_query)){
    $userManagerId  = $row->user_manager_id;
    $userEmpId  = $row->user_emp_id;
  }
  // set it to below query
  $clientCompanysql = "insert into client_contacts(client_contact_first_name,client_contact_last_name,client_contact_email,client_contact_mobile,client_contact_category,client_contact_designation,client_contact_address,country_id,state_id,city_id,client_contact_linkedin,client_contact_facebook,client_contact_twitter,client_company_id,client_contact_status,client_contact_added,assoc_manager_id,assoc_user_id)
  values('$clientFirstName','$clientLastName','$clientEmail','$clientMobile','$clientCategory','$clientDesignation','$clientAddress','$clientCountry','$clientState','$clientCity','$clientLinkedInId','$clientFacebookId','$clientTwitterId','$clientCompanyId','New','$php_timestamp_date','$userManagerId','$userEmpId')";

  $companyClientquery= mysqli_query($conn,$clientCompanysql);
    
 //header("Location:AddCompanyClientDetalis.php?companyId=".$clientCompanyId."&companyName=".clientCompanyName);
   
 $_SESSION["server-msg"] = "<p class='text-center' style='color:green;'><h5>Client Added Successfully!</h5></p>";
  //header("Location:clientlist.php");
  header("Location:bde_showcontactsdetails.php?companyId=$companyId");

  ?>