<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');

$from = $_POST["fromAddr"];
$to = $_POST["toAddr"];
$subject = $_POST["subject"];
$message = $_POST["message"];
$originalMsg = $_POST["message"];
$originalMsg_sent = $_POST["message"];
$contactId = $_POST["contactId"];

if(!validateDetails()) {
    exit();
}
$headers =  "From: ".$_POST["fromAddr"];
if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set("Asia/Kolkata");
    $php_timestamp_date = date("Y-m-d H:i:s");
}
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
$message .= "--{$mime_boundary}\n";
if(($_FILES['attach1']['name'] !== "") || isset($_FILES['attach2']['tmp_name']) || isset($_FILES['attach3']['tmp_name'])) {
    $allowedExtensions = array("pdf","doc","docx","gif","jpeg","jpg","png","zip","txt");
    $files = array();
    foreach($_FILES as $name=>$file) {
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
        if(!in_array($ext,$allowedExtensions)) {
            $_SESSION['serverMsg'] = "File $file_name has the extensions $ext which is not allowed";
            error();     
        }
        if($file_size_kb > 1000) {  
            $_SESSION['serverMsg'] = "Attach file size $file_size_kb kb.Please Uplod file less than 1000kb";
            error();                                                          
        }
        array_push($files,$file);
    }
    for($x=0; $x<count($files); $x++) {
        $file = fopen($files[$x]['tmp_name'], "rb");
        $data = fread($file, filesize($files[$x]['tmp_name']));
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
if($ok == true) { 
    $databaseManager = new DatabaseManager();
    $conn = $databaseManager->getConnection();
    $sql_mail_config = "select * from mail_config";
    $res_mail_config = mysqli_query($conn, $sql_mail_config);
    $row_mail_config = mysqli_fetch_object($res_mail_config);
    $host = $row_mail_config->mail_config_host;
    $username = $row_mail_config->mail_config_user_name;
    $in = "INBOX.Sent";
    $host_mail='{'.$host.'}'.$in;
    $password = $row_mail_config->mail_config_password;                                    
    $stream = imap_open($host_mail, $username, $password);     
    imap_append($stream, $host_mail, "From: $username\r\n"
        . "To: $to\r\n"
        . "Subject: $subject\r\n"
        . "\r\n". "$originalMsg_sent\r\n");
    imap_close($stream);     
    $fileNames = array();
    foreach($_FILES as $name=>$file) {
        $file_name = $file['name'];
        array_push($fileNames, $file_name);
    }
    $attach=implode(',',$fileNames);         
    $status="Proposal Sent";
    $admin_id = $_SESSION['userId'];
    /**
     * fetch assoc manager id using client id
     */
    $assoc_manager_id_sql = "select assoc_manager_id from client_contacts where client_contact_id='$contactId'";
    $assoc_manager_id_res = mysqli_query($conn,$assoc_manager_id_sql);
    $assoc_manager_id_row = mysqli_fetch_object($assoc_manager_id_res);
    $assoc_manager_id = $assoc_manager_id_row->assoc_manager_id;

    $bdm_user_id_sql = "select user_id from users where  user_emp_id='$assoc_manager_id'";
    $bdm_user_id_res = mysqli_query($conn,$bdm_user_id_sql);
    $bdm_user_id_row = mysqli_fetch_object($bdm_user_id_res);
    $bdm_user_id = $bdm_user_id_row->user_id;

    $resupdate="update client_contacts set client_contact_status='$status' where client_contact_id='$contactId'";
    mysqli_query($conn,$resupdate); 
    $id=$_GET['id'];
    $sqlsent="insert into email_logs(email_log_user_id,email_log_from,email_log_to,email_log_subject,email_log_message,email_log_attachment,email_log_sent_time)values('$bdm_user_id','$from','$to','$subject','$originalMsg','$attach','$php_timestamp_date')";
    mysqli_query($conn,$sqlsent);
    $sqlupdate="select * from mail_activities where mail_activity_to='$to'";
    $rupdate = mysqli_query($conn,$sqlupdate);
    $count=mysqli_num_rows($rupdate);                    
    if($count == 0) {
        $sqlactivity="insert into mail_activities(mail_activity_user_id,mail_activity_from,mail_activity_to,mail_activity_subject,mail_activity_message,mail_activity_attachment,mail_activity_sent_time)values('$bdm_user_id','$from','$to','$subject','$originalMsg','$attach','$php_timestamp_date')"; 
        mysqli_query($conn,$sqlactivity);
    } else {
        $sqla="update mail_activities set mail_activity_subject='$subject', mail_activity_message='$originalMsg',mail_activity_attachment='$attach', mail_activity_sent_time='$php_timestamp_date' where mail_activity_to='$to'";
        mysqli_query($conn,$sqla);
    } 
    $_SESSION['serverMsg'] ="Mail Sent Successfully !";
    header("Location:../../views/user/admin/clientcontactlist.php");            
} else { 
    $_SESSION['serverMsg'] = "Mail Not Sent for: " .$to;
    error();                                           
} 
          
function error() {             
    header("Location:../../views/user/admin/clientcontactlist.php");
    exit(0);
}

function validateDetails() {
    global $subject, $message;
    if($subject == "" || $message == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    }
    return true;
}

?>