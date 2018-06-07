<?php
session_start();
/*include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
 $data = new DatabaseManager();
 $conn = $data->getconnection();*/
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/ClientService.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/LocationService.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');
 
 $locationService = new LocationService();
 $clientService = new ClientService();
 $company = new Company();
 $contact = array();
 
 $userId = $_SESSION["userId"];
 //$companyId = $_POST['companyId'];

 setContactDetailsFromCsv();

 function setContactDetailsFromCsv() {
    global $contacts, $locationService;
    if($_FILES['file']['name']=="")
    {
        $_SESSION["server-msg"] = "<p class='text-center'style='color:red;'> Please Upload File !</p>";
        header("Location:../../views/user/bde/bde_csv.php");
   
    }  
    $csvCheck =  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if(!empty($_FILES['file']['name'])&& in_array($_FILES['file']['type'],$csvCheck))
   {
    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
    fgetcsv($csvFile);
    while(($data = fgetcsv($csvFile)) !== false) {
        if($_POST['companyId'] == "" || $data[0] == "" || $data[1] == "" || $data[2] == "" || $data[3] == "" || $data[4] == "" || $data[5] == "" || $data[6] == "" || $data[7] == "" || $data[8] == "" || $data[9] == ""  ){
            $_SESSION["server-msg"] ="<p class='text-center'style='color:red;'> Please Re-Fill the Form, Some data is missed !!</p>";
            error();  
        }
        $data ="";
        }
        fclose($csvFile);
        $data ="";
        $csvFileData = fopen($_FILES['file']['tmp_name'], 'r');
        while(($data = fgetcsv($csvFileData)) !== false) {
            $clientService = new ClientService();
            $country = $locationService->getCountryByName($data[9]);
            
            $state = $locationService->getStateByName($data[8]);
           
            $city = $locationService->getCityByName($data[7]);
            $contact = new Contact();
            $contact->setCountry(0);
            $contact->setState(0);
            $contact->setCity(0);
         
                $contact->setCountry($country->id);
          
        
           
                    $contact->setState($state->id);
              
         
               
                    $contact->setCity($city->id);
               
          
                $contact->setFirstName($data[0]);
                $contact->setLastName($data[1]);
                $contact->setEmail($data[2]);
                $contact->setMobile($data[3]);
                $contact->setCategory($data[4]);
                $contact->setDesignation($data[5]);
                $contact->setAddress($data[6]);
                $contact->setLinkedIn($data[10]);
                $contact->setFacebook($data[11]);
                $contact->setTwitter($data[12]);
                $contact->setCompany($_POST['companyId']);
                
                $setContactDetailsFromCsv = $clientService->addClientContact($contact);
                $setContactDetailsFromCsv="";
            
           
        
        }
        $_SESSION["server-msg"] ="<p class='text-center' style='color:green;'> File Uploaded Successffuly!</p>";
        header("Location:../../views/user/bde/bde_clientlist.php");
        
    }else{
        $_SESSION["server-msg"] ="<p class='text-center'style='color:red;'> Please Upload CSV file Only!</p>";
       error();
    }
 }


 function error(){
         header("Location:../../views/user/bde/bde_csv.php"); 
        //fclose($csvFileData);
        exit(0);
    }
 
 


    
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 /*
 if(function_exists('date_default_timezone_set')) 
    {
        date_default_timezone_set("Asia/Kolkata");
        $php_timestamp_date = date("Y-m-d H:i:s");
    }
    
      $mang = "select * from users where user_id = '$userId'";       
      //$mang = "select user_manager_id from users where user_id = '$userId'";
      $mang_query= mysqli_query($conn,$mang);
      if($row = mysqli_fetch_object($mang_query)){
        $userManagerId  = $row->user_manager_id;
        $userEmpId  = $row->user_emp_id;
        //echo $userManagerId;
       // die;
       
      }
                if($_FILES['file']['name']=="")
                {
                    $_SESSION["server-msg"] = "<p class='text-center'style='color:red;'> Please Upload File !</p>";
               
                }    
                
           $FileCsv = $_FILES['file']['name'];
           $path_parts = pathinfo($FileCsv);
           $ext = $path_parts['extension'];  
           if($ext == "csv" ) 
           {    
        $csvCheck =  array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

        if(!empty($_FILES['file']['name'])&& in_array($_FILES['file']['type'],$csvCheck))
        {
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            fgetcsv($csvFile);

            while(($data = fgetcsv($csvFile)) !==FALSE){
                  //fetch country id by country name and set id if exsits else set 0
                $country_sql="select * from countries where country_name='$data[9]'";    
                $country_res = mysqli_query($conn, $country_sql);
                $country_row = mysqli_fetch_object($country_res);
                $state_sql="select * from states where state_name='$data[8]'";
                $state_res = mysqli_query($conn, $state_sql);
                $state_row = mysqli_fetch_object($state_res);
                $city_sql="select * from cities where city_name='$data[7]'";
                $city_res = mysqli_query($conn, $city_sql);
                $city_row = mysqli_fetch_object($city_res);
                
                $clientCountry = 0;
                if($country_row != null || $country_row !="" || $country_row !="undefined") {
                    $clientCountry = $country_row->country_id; 
                }else{
                     error();  
               }

                $clientState = 0;
                if($state_row != null || $state_row != "" || $state_row !="undefined" ) {
                    if($state_row->country_id == $clientCountry) {
                          $clientState = $state_row->state_id;        
                    }else{
                        
                        error();  
                    }
                }

                $clientCity = 0;
                if($city_row != null || $city_row != "" || $city_row != "undefined") {
                    if($city_row->country_id == $clientCountry && $city_row->state_id == $clientState) {
                     $clientCity = $city_row->city_id; 
                    }else{
                         error();  
                    }
                }   
                $clientFirstName = $data[0];
                $clientLastName = $data[1];
                $clientEmail = $data[2];
                $clientMobile = $data[3];
                $clientCategory = $data[4];
                $clientDesignation = $data[5];
                $clientAddress = $data[6];
                $clientLinkedInId = $data[10];
                $clientFacebookId = $data[11];
                $clientTwitterId = $data[12];
                $clientCompanyId = $companyId;
                $userManagerId =  $userManagerId; 
              
                $sql_csv = "insert into client_contacts(client_contact_first_name,client_contact_last_name,client_contact_email,client_contact_mobile,client_contact_category,client_contact_designation,client_contact_address,city_id,state_id,country_id,client_contact_linkedin,client_contact_facebook,client_contact_twitter,client_company_id,client_contact_status,client_contact_added,assoc_manager_id,assoc_user_id,email_timeout)values('$clientFirstName','$clientLastName','$clientEmail','$clientMobile','$clientCategory','$clientDesignation','$clientAddress','$clientCity','$clientState','$clientCountry','$clientLinkedInId','$clientFacebookId','$clientTwitterId','$clientCompanyId','New','$php_timestamp_date','$userManagerId','$userEmpId','24')"; 
                $db = mysqli_query($conn,$sql_csv);
                header("Location:../../views/user/bde_clientlist.php");
            }
                $_SESSION["server-msg"] ="<p class='text-center' style='color:green;'> File Uploaded Successffuly!</p>";
        }else{
            $_SESSION["server-msg"] ="<p class='text-center'style='color:red;'> Please Re-Fill the Form, Some data is missed !!</p>";
            error();   
        } 
        //if(!empty($_FILES['file']['name'])&& in_array($_FILES['file']['type'],$csvCheck))
        //{
          //  $_SESSION["server-msg"] ="<p class='text-center'style='color:red;'> Please Re-Fill the Form, Some data is missed !</p>"; 
          //  error();
      //  } 

           }else {
                $_SESSION["server-msg"] ="<p class='text-center'style='color:red;'> Please Upload CSV file Only!</p>";
        error();
           }
       function error(){
       // $_SESSION["server-msg"] ="<p class='text-center'style='color:red;'>   </p>"; 
            header("Location:../../views/user/bde_csv.php"); 
           fclose($csvFile);
           exit(0);
       }*/
       
 ?>