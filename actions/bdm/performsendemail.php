<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/MailService.php');
$mailService = new MailService();
//include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
//$data = new DatabaseManager();
//$conn = $data->getConnection();
$orginalFrom  = $_SESSION['email'];
error_reporting(E_ALL);
ini_set('display_errors', 1); 
$bdmid = $_SESSION['userId'];

  $id=$_GET['id'];

/*  
 $email="vidyanaghhik329@gmagfil.com" ;
  list($userName, $mailDomain) = split("@", $email); 
if (checkdnsrr($mailDomain, "MX")) { 
  echo "this is a valid email domain!"; 
} 
else { 
    echo "this email domain doesn't exist! bad dog! no biscuit!"; 
   
} 

if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
    echo("$email is a valid email address");
} else {
    echo("$email is not a valid email address");
}
        


if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
 $_SESSION['errormsg'] = "Please Enter Email Id ";
    
      error();
} */
  
  if(($_POST['sub'] != "")&&($_POST['msg'] != "")) {
    $subject=$_POST['sub'];
    $message=$_POST['msg'];   
  }
  else{
       $_SESSION['errormsg'] = "Please Enter valid Details ";
       $_SESSION['sub'] =  $_POST['sub'];
       
       $_SESSION['msg'] = $_POST['msg'];
    
      error();
  }
  
   
    
    // $_SESSION['errormsg'] = "";
     $to = $_POST['to'] ;
     $originalMsg = $_POST['msg'];
     $originalMsg_sent = $_POST['msg'];
     $from = $_POST['from'];
     $headers =  "From: ".$_POST['from'];
   
    if(function_exists('date_default_timezone_set'))
    {
        date_default_timezone_set("Asia/Kolkata");
        $php_timestamp_date = date("Y-m-d H:i:s");
     
    }

    /**
    * New Logic - allow  without file
    */
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
    $message .= "--{$mime_boundary}\n";    

    if(($_FILES['attach1']['name'] !== "") || isset($_FILES['attach2']['tmp_name']) || isset($_FILES['attach3']['tmp_name']))  {
        $allowedExtensions = array("pdf","doc","docx","gif","jpeg","jpg","png","zip","txt");
        $files = array();
        foreach($_FILES as $name=>$file)                                 
        {
            if($file['name'] == "") {
                continue;
            }
            $file_name = $file['name']; 
            $temp_name = $file['tmp_name'];
            $file_type = $file['type'];
            $file_size = $file['size'];//size in KBs
            $file_size_kb = $file_size/1024; 
           
        $path_parts = pathinfo($file_name);
           $ext = $path_parts['extension'];
             
            if(!in_array($ext,$allowedExtensions))
            {
                 $_SESSION['errormsg'] = "File $file_name has the extensions $ext which is not allowed";
                  $_SESSION['sub'] =  $_POST['sub'];
       
                     $_SESSION['msg'] = $_POST['msg'];
                   error();     
            } 
            
            if($file_size_kb > 1000 )
             {  
               $_SESSION['errormsg'] = "Attach file size $file_size_kb kb.Please Uplod file less than 1000kb";
                $_SESSION['sub'] =  $_POST['sub'];
       
                $_SESSION['msg'] = $_POST['msg'];
                error();     
                                                                     
             }  
                  
                    array_push($files,$file);
                
            
        }
        
        for($x=0;$x<count($files);$x++)
        {
            $file = fopen($files[$x]['tmp_name'],"rb");
            $data = fread($file,filesize($files[$x]['tmp_name']));
            fclose($file);
            $data = chunk_split(base64_encode($data));
            $name = $files[$x]['name']; 
            $originalMsg_sent .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" .  
            "Content-Disposition: attachment;\n" . " filename=\"$name\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
         
            $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" . 
            "Content-Disposition: attachment;\n" . " filename=\"$name\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            $message .= "--{$mime_boundary}\n";   
        }
        
  }


   $ok = mail($to, $subject, $message, $headers);
     
   if ($ok == true)
     { 
        



        $sql_mail_config="select * from mail_config";
        $res_mail_config = mysqli_query($conn,$sql_mail_config);
        $row_mail_config=mysqli_fetch_object($res_mail_config);
        $host = $row_mail_config->mail_config_host;
        $username = $row_mail_config->mail_config_user_name;
        $in = "INBOX.Sent";
        $host_mail='{'.$host.'}'.$in;
        $password = $row_mail_config->mail_config_password;                                    
         $stream = imap_open($host_mail, $username, $password);     
         imap_append($stream, $host_mail
                   , "From: $username\r\n"
                   . "To: $to\r\n"
                   . "Subject: $subject\r\n"
                   . "\r\n"
                   . "$originalMsg_sent\r\n"
                   );
         imap_close($stream);
         
         $fileNames = array();
            foreach($_FILES as $name=>$file)
            {
                $file_name = $file['name']; 
                array_push($fileNames, $file_name);
            }
            $attach=implode(',',$fileNames);
             
                 $status="Proposal Sent";
             
            
           // var_dump($attach);
   
           $resupdate="update client_contacts set client_contact_status='$status' where client_contact_id='$id'";
           mysqli_query($conn,$resupdate); 
           $id=$_GET['id'];
           $sqlsent="insert into email_logs(email_log_user_id,email_log_from,email_log_to,email_log_subject,email_log_message,email_log_attachment,email_log_sent_time)values('$bdmid','$orginalFrom','$to','$subject','$originalMsg','$attach','$php_timestamp_date')";
           mysqli_query($conn,$sqlsent);
          
            
            $sqlupdate="select * from mail_activities where mail_activity_to='$to'";
           
            $rupdate = mysqli_query($conn,$sqlupdate);
            
            $count=mysqli_num_rows($rupdate);
            //var_dump($count);
               
  
           // echo $count;  
                                
            if($count == 0)
            {
                  $sqlactivity="insert into mail_activities(mail_activity_user_id,mail_activity_from,mail_activity_to,mail_activity_subject,mail_activity_message,mail_activity_attachment,mail_activity_sent_time)values('$bdmid','$orginalFrom','$to','$subject','$originalMsg','$attach','$php_timestamp_date')"; 
                  
                  
                 mysqli_query($conn,$sqlactivity);
                
            }
            else
            {
                $sqla="update mail_activities set mail_activity_subject='$subject', mail_activity_message='$originalMsg',mail_activity_attachment='$attach', mail_activity_sent_time='$php_timestamp_date' where mail_activity_to='$to'";
                mysqli_query($conn,$sqla);
            } 
            
              //echo "<script type='text/javascript'>alert('Mail Sent Successfully!!...');</script>";
              $_SESSION['successmsg'] ="Mail Sent Successfully!....";
            
              
              if(isset($_GET['empid']))
              {    $empid = $_GET['empid'];
                   header("Location:../../views/user/bdm/bdeclientlist.php?bdeid=$empid");
              }elseif(isset($_GET['companyId'])){
              
                 $companyId=$_GET['companyId'];
                header("Location:../../views/user/bdm/showContactsDetails.php?companyId=$companyId"); 
             }else{
                  header("Location:../../views/user/bdm/clientlist.php");
              }
                
                  
                
     } 
     else 
     { 
            //echo "<script type='text/javascript'>alert('Mail not sent try again!!...');</script>";
            $_SESSION['errormsg'] = "Mail Not Sent!..";
             $_SESSION['sub'] =  $_POST['sub'];
       
       $_SESSION['msg'] = $_POST['msg'];
                   error();                                           
     } 
        
      

  
   
  function error()
  {              if(isset($_GET['empid'])){
                    $id=$_GET['id'];
                    $source=$_GET['source'];
                    $empid=$_GET['empid'];
                    header("Location:../../views/user/bdm/email_send.php?empid=$empid&source= &id=$id"); 
                 }elseif(isset($_GET['companyId'])){
                    $id=$_GET['id'];
                     $companyId=$_GET['companyId'];
                    header("Location:../../views/user/bdm/email_send.php?id=$id&companyId=$companyId"); 
                 }else{
                      $id=$_GET['id'];
                     header("Location:../../views/user/bdm/email_send.php?id=$id");
                 }
                 
             
     exit(0);
  }
    
?>