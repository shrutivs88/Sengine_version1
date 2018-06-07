<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
if(!isset($_SESSION["email"])) {
    header("Location:login.php");
}

 //include '../../utility/DatabaseManager.php';
 $data = new DatabaseManager();
 $conn = $data->getConnection();
$templateid = $_POST['template']; 


$sql = "select mail_template_header,mail_template_footer from mail_templates where mail_template_id='$templateid'";
 
  
$result = mysqli_query($conn,$sql);

$template_array = array();

while( $row = mysqli_fetch_array($result) ){
    //$template_id = $row['template_id'];
    //$template_name = $row['$template_name'];
    $header=$row['mail_template_header'];
    $footer=$row['mail_template_footer'];

    $template_array[] = array("header" => $header, "footer" => $footer);
}

// encoding array to json format
echo $header; 
echo "\n";
echo "\n";
echo $footer;
echo "\n";


?>