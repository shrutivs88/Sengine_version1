<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
if(!isset($_SESSION["email"])) {
    header("Location:login.php");
}
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
    <script src="<?php echo BASEURL; ?>assets/js/bootstrap.min.js"></script>
    <style> button a{color:white;}</style>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
   
            <!-- BDE Access Only -->
            <?php if ($_SESSION['role'] == "BDE") : ?>
                <div id="bde-container">
                    <h2 class="text-center">Client Contacts Via CSV</h2>
                    <br>
                    <?php
                        
                        if(isset($_SESSION["server-msg"])) {
                            echo $_SESSION["server-msg"];
                            unset($_SESSION["server-msg"]);
                        }
                        
                    ?>
               <form action="<?php echo BASEURL; ?>actions/bde/perfromfetchcsvfile.php" method="POST" enctype="multipart/form-data">     
                       <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                        <label> CSV File</label>
                                        <input type="file" name="file" id="file">
                                    </div>
                                    <div class="form-group">
                                        <label>Company Names</label>
                                        <select name="companyId" class="form-control">
                                            <option value=""> Choose Companies </option>
                                            <?php
                                     include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
                                      $data = new DatabaseManager();
                                      $conn = $data->getconnection();    

                                    $sql = "select * from client_companies";
                                    $res= mysqli_query($conn,$sql);

                                    while($row =mysqli_fetch_object($res)){
                                            ?>
                                            <option value="<?php echo $row->client_company_id ?>"><?php echo $row->client_company_name ?></option>
                                            <?php

                                    }
                                            ?>
                                        </select>
                                    </div>
                                   
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="import" name="import"> Upload File </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-md-offset-4">
                                          <!--<button type="button" class="btn btn-success"><a href='../../assets/csv/TemplateFile.csv' download> Download Template <span class="glyphicon glyphicon-download-alt"></span></a></button>-->
                                          <a href='../../../assets/csv/sta-contact-template.csv' download> Download Template <span class="glyphicon glyphicon-download-alt"></span></a>
                                        </div>
                                    </div> 
                                </div>    
                               
                            </div>
                            <div class="col-sm-4"></div>
                           
                    </form>
                       </div>
                       
                </div>
            <?php endif; ?>
        </div> 
    </div>
    <?php include 'footer.php';?>
    
</body>
</html>