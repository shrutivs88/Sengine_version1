<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
if(!isset($_SESSION["email"])) {
    header("Location:login.php");
}
 $from = $_SESSION["email"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales Team Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/styles.css" />
    <script src="<?php echo BASEURL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/chrome_fix.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/bootstrap.min.js"></script>
    
    <style>
        label{
              margin-left:8px;
        }
        
        td, tr, tbody, tfoot{
            border:0px;
        }
       
        
    </style>
    
    
    
    
    <script>
    //fetching message template using ajax
      $(document).ready(function(){

      $("#template").change(function(){
        var templateid = $(this).val();
       // alert(templateid) ;
       
        $.ajax({
            url: '<?php echo BASEURL; ?>actions/bdm/performfetchmessagetemplate.php',
            type: 'post',
            data: {template:templateid},
            dataType: 'text',
            success:function(response){
               
                
                     $("#msg").html(response);
                     validateMsg();
                    
        
            }
        });
      });
      })
    </script>
    
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <!-- Admin Access Only -->

            <!-- BDM Access Only -->
            <?php if ($_SESSION['role'] == "BDM") : ?>
            <?php
                if(isset($_SESSION['errormsg']))
                {
                    echo "<div class='alert alert-danger text-center'>" .$_SESSION['errormsg']."</div>";
                    unset($_SESSION['errormsg']); 
                } 
            ?>
                
            <div id="bdm-container" class="container">
                <?php
                    //include '../../utility/DatabaseManager.php';
                    $data = new DatabaseManager();
                    $conn = $data->getConnection();
                     
                    $cid = $_GET['id'];
                     
                    
                        
                    $sql_client="select * from client_contacts where client_contact_id='$cid'";
                    $result_client=mysqli_query($conn,$sql_client);
                    $row=mysqli_fetch_object($result_client);
                    $client_emails = $row->client_contact_email;   
                    $client_email = array();
                    $client_email = explode(',',$client_emails); 
                    $sql_from="select mail_config_user_name from mail_config";
                    $result_from=mysqli_query($conn,$sql_from);
                    $row_from=mysqli_fetch_object($result_from);  
                 
               
               if(isset($_GET['source'])){
                         $source=$_GET['source']; 
                         $empid=$_GET['empid'];
                       ?>   
                     
                <form id="emailForm" action="<?php echo BASEURL;?>actions/bdm/performsendemail.php?empid=<?php echo $empid; ?><?php echo '&';?>source=<?php echo $source; ?><?php echo '&';?>id=<?php echo $cid; ?>" method="POST" enctype="multipart/form-data">
                <?php 
               }elseif(isset($_GET['companyId'])){
                   ?>
                <form id="emailForm" action="<?php echo BASEURL;?>actions/bdm/performsendemail.php?id=<?php echo $cid; ?><?php echo '&';?>companyId=<?php echo $_GET['companyId'] ; ?>" method="POST" enctype="multipart/form-data"> 
                <?php
               }else{
                   ?>
                   <form id="emailForm" action="<?php echo BASEURL;?>actions/bdm/performsendemail.php?id=<?php echo $cid; ?>" method="POST" enctype="multipart/form-data"> 
                   <?php
               }
                ?>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9">
                            <!-- Panel start-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title"> <h3 class="text-center"> <i> Send Email </i></h3> </div>
                                </div>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row"> 
                                            <div class="col-sm-3">
                                                <label> From : </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="from" class="form-control" value="<?php echo $row_from->mail_config_user_name;?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label> To : </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="to" class="form-control" value="<?php echo $client_email[0]; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label> Subject : </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <?php
                                                    if(isset($_SESSION['sub']))
                                                    {
                                                ?>
                                                        <input type="text" name="sub" id="sub" placeholder="max char 70" class="form-control" size="70" maxlength="70" onfocusout="validateSubject()" value="<?php echo $_SESSION['sub'];?>">
                                                        <?php
                                                            unset($_SESSION['sub']);
                                                    }  
                                                    else
                                                    {
                                                        ?>
                                                            <input type="text" name="sub" id="sub" class="form-control" size="70" placeholder="max char 70" maxlength="70" onfocusout="validateSubject()">
                                                            <?php
                                                    }
                                                            ?>
                                                            <i id="suberror" style="color:red"></i>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <!-- dropdown of templates-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label> Template : </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <?php
                                                    $template_sql="select * from mail_templates";
                                                    $template_res=mysqli_query($conn,$template_sql); 
                                                ?>
                                                <?php
                                                    if(isset($_SESSION['template']))
                                                    {
                                                ?>
                                                <select name="template" id="template"  class="form-control">
                                                    <option value=""> Choose Template </option>
                                                        <?php
                                                            while($template_row = mysqli_fetch_object($template_res)){
                                                        ?>
                                                    <option value="<?php echo $template_row->mail_template_id; ?>"> <?php echo $template_row->mail_template_name; ?> </option>
                                                        <?php
                                                            }
                                                        ?>  
                                                </select>
                                                <?php
                                                    unset($_SESSION['template']);
                                                    }  
                                                    else
                                                    {
                                                ?>
                                                
                                                <select name="template" id="template"  class="form-control">
                                                    <option value=""> Choose Template </option>
                                                        <?php
                                                            while($template_row = mysqli_fetch_object($template_res)){
                                                        ?>
                                                    <option value="<?php echo $template_row->mail_template_id; ?>"> <?php echo $template_row->mail_template_name; ?> </option>
                                                        <?php
                                                    }
                                                        ?>
                                                </select>
                                                        <?php
                                                            }
                                                        ?>
                                                <i id="templateerror" style="color:red"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label> Message : </label>
                                            </div>
                                            <div class="col-sm-9">               
                                                <?php
                                                    if(isset($_SESSION['msg']))
                                                    {
                                                ?>
                                                <textarea placeholder="max char 900" name="msg" style="resize:none;" id="msg" rows="10" cols="70" maxlength="900"  class="form-control" onfocusout="validateMsg()"><?php echo $_SESSION['msg'];?></textarea>
                                                <?php
                                                    unset($_SESSION['msg']);
                                                    }
                                                    else
                                                    {
                                                ?>
                                                <textarea placeholder="max char 900"  name="msg" id="msg" rows="10" cols="70" maxlength="900" class="form-control" onfocusout="validateMsg()"></textarea>
                                                <?php
                                                    }
                                                ?>  
                                                <i id="msgerror" style="color:red"></i>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label> Attachment : </label>
                                            </div>
                                            <div class="col-sm-9"> 
                                            <table id="file-attachment-table" class="file-attachment-table">
                                            <tbody id="file-upload-btns">
                                                <tr id="btn-row-1">
                                                    <td colspan="2">
                                                        <input type="file" class="file-attach" name="attach1" id="file1" onchange="validateattachment('file1')">
                                                    </td>
                                                 
                                                </tr>
                                             
                                            </tbody>
                                          
                                           <tfoot id="file-upload-actions">
                                           <tr> <td><i id="attacherror" style="color:red"></i></td> </tr>
                                       
                                                <tr>
                                                    <td id="addfile">
                                                            <button type="button" id="add-another-file-btn" class="btn btn-primary btn-sm" onclick="addAnotherFile()">Add Another File</button>
                                                    </td>
                                                    <td>
                                                        <button type="button" id="remove-file-btn" class="btn btn-warning btn-sm" onclick="removeFile()">Remove File</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        </div>
                                    </div>   
                                </div>
                                <input type="hidden"  name="clientid" value="<?php  echo $cid;?>">
                                <div class="panel-footer">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <button type="button"  class="btn btn-primary" onclick="validate()"> Send </button>
                                                <?php
                                                   if(isset($_GET['empid'])) {
                                                     ?>
                                                     <a href="bdeclientlist.php?bdeid=<?php echo $_GET['empid'];?>" ><button type="button"  class="btn btn-danger"> Cancel </button></a>
                                                     <?php  
                                                   }elseif(isset($_GET['companyId'])){
                                                       ?>
                                                    <a href="showContactsDetails.php?companyId=<?php echo $_GET['companyId'];?>" ><button type="button"  class="btn btn-danger"> Cancel </button></a>
                                                    <?php
                                                    }
                                                     else{
                                                    ?> 
                                                    <a href="clientlist.php" ><button type="button"  class="btn btn-danger"> Cancel </button></a>
                                                    <?php  
                                                   }
                                                   ?>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Panel Ends-->
                            </div>
                            <div class="col-sm-1">
                            </div>
                         </div>
                    </form>
                </div>
            <?php endif; ?>
            <!-- BDE Access Only -->
           
        </div> 
    </div>
    <?php include 'footer.php';?>
    <script type="text/javascript">
    var fileIndex = 2;
        var isFileOneEmpty = true;
        var isFileTwoEmpty = true;
        var isFileThreeEmpty = true;
    var attachErrorFlag;
    var attachErrorFlag = false;
      var fileid;
    //adding another button on click
    function addAnotherFile() {
            if(fileIndex > 3) {
                return;
            }
            var previousAttachment = $("#file" + (fileIndex-1)).val();
            if(previousAttachment == "" || previousAttachment == null || previousAttachment == undefined) {
                alert("No File Selected");
                return;
            }
            var fileRowBuilder = "<tr id='btn-row-" + fileIndex + "'>";
            fileRowBuilder += "<td colspan='2'><input type='file' class='fileAttach' name='attach" + fileIndex + "' id='file" + fileIndex + "' onchange=validateattachment('file" + fileIndex + "')></td>";
            fileRowBuilder += "</tr>";
            $("#file-upload-btns").append(fileRowBuilder);
            fileIndex++;
            if(fileIndex > 3){
                $("#add-another-file-btn").remove();
                //document.getElementById("addfile").style.visibility = 'hidden';
            }
        }

        function removeFile() {
            
            if(fileIndex <= 2) {
                $("#file" + (fileIndex-1)).val("");
                attachErrorMsg = "";
                document.getElementById("attacherror").innerHTML = attachErrorMsg;
             return;
            }else{
               fileIndex--;
            $("#btn-row-" + fileIndex).remove();
            attachErrorMsg = "";
            document.getElementById("attacherror").innerHTML = attachErrorMsg;
            if(fileIndex == 2){
               
                document.getElementById("add-another-file-btn").disabled = false; 
               
            } 
            if(fileIndex == 3){
                 $("#addfile").append("<button type='button' id='add-another-file-btn' class='btn btn-primary btn-sm' onclick='addAnotherFile()'>Add Another File</button>");
                 //document.getElementById("addfile").style.visibility = 'visible';
            }
            }
           
        }
  
       var subErrorFlag = true; 
        var subErrorMsg = "";
        var msgErrorFlag = true; 
        var msgErrorMsg = "";
        var templateErrorFlag = true;  
        var templateErrorMsg = ""; 
           
        function validateSubject()
        {
            var sub = $("#sub").val().trim();
            if((sub == "") || (sub == "null")){
                subErrorFlag = true;
                $("#sub").css({"border":"2px solid red"}) ;
                subErrorMsg ="Please Enter Subject";
                
            }else{
                 subErrorFlag = false;
               $("#sub").css({"border":"1px solid LightGray"}) ;
               subErrorMsg = ""; 
            }
            document.getElementById("suberror").innerHTML = subErrorMsg;  
            
              
        }
          
          function validateMsg() {
            var msg = $("#msg").val().trim();
            if((msg == "") || (msg == "null"))
            {
                msgErrorFlag = true;
                $("#msg").css({"border":"2px solid red"}) ;
                msgErrorMsg = "Please Enter Message"; 
                 
                
            }  else{
               msgErrorFlag = false; 
                $("#msg").css({"border":"1px solid LightGray"}) ;
                msgErrorMsg = "";
            } 
            document.getElementById("msgerror").innerHTML = msgErrorMsg;   
            
             
        }
        
       /* function validatetemplate(){
             var template = $("#template").val().trim();
        //// alert(template);
            if((template == "") || (template == "null"))
            {
              templateErrorFlag = true;
                $("#template").css({"border":"2px solid red"}) ;
               templateErrorMsg = "Please select template"; 
                 
                
            }  else{
               templateErrorFlag = false; 
                $("#template").css({"border":"1px solid LightGray"}) ;
                templateErrorMsg = "";
            } 
             document.getElementById("templateerror").innerHTML = templateErrorMsg;   
            
            
        }
        var attachErrorFlag1 = true;
        var attachErrorFlag2 = true;
        var attachErrorFlag3 = true;*/
    
        

        function validateattachment(attachid){
           
            var fileName = document.getElementById(attachid).value;
               if((fileName == "") || (fileName == null) || (fileName == undefined))
               {
                   attachErrorMsg = "";
                  
                    attachErrorFlag = false;  
                }else{
                        var attach_size_kb = document.getElementById(attachid).files[0].size/1024; 
                        var fileName = document.getElementById(attachid).value;
                        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
                            if(ext =="pdf" || ext=="doc" || ext=="docx" || ext=="gif" || ext=="jpeg" || ext=="jpg" || ext=="png" || ext=="zip" || ext=="txt")
                            {
                                 
                                 
                                if(attach_size_kb > 1000) {
                                       // alert("Attach file size attach1_size_kb kb.Please Uplod file less than 1000kb");
                                        attachErrorFlag = true;
                                     
                                        attachErrorMsg = "Please upload a file less than 1000kb";
                                        
                                        document.getElementById("add-another-file-btn").disabled = true;
                                }else{
                                document.getElementById("add-another-file-btn").disabled = false;
                                attachErrorFlag = false;
                                attachErrorMsg = "";
                                }
                             
                               
                            } else{
                               // alert("Please Upload pdf, doc, docx, gif, jpeg, jpg, png, gif, txt,zip Extension Files Only");
                                attachErrorMsg = "Please Upload pdf, doc, docx, gif, jpeg, jpg, png, gif, txt Extension Files Only";
                             
                                attachErrorFlag = true;
                                if(fileIndex <=3){
                                    document.getElementById("add-another-file-btn").disabled = true;
                                }
                                
                                
                            }
                        
                        }
                        document.getElementById("attacherror").innerHTML = attachErrorMsg;
                }
                 
          
         
                 function validate()
                 {
                   validateSubject();
                   validateMsg();
           
                    if(subErrorFlag == false && msgErrorFlag == false && attachErrorFlag == false){
                        submitForm();  
                    }else{
                        showErrors();
                    }
            }


                function submitForm() {
                    $("#emailForm").submit();
                } 
                           
                function showErrors() {
                    alert("Please Enter Valid Details");
                }   
    </script>
     
</body>
</html>