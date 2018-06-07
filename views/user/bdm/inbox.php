<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getConnection();
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
    <script>
         
         $(document).ready(function() {
            inbox_fetch_list();
         });
     
         function inbox_fetch_list(){
             //alert();
            $.ajax({
                url: '<?php echo BASEURL; ?>actions/bdm/performfetchinboxlistofmail.php',  
                type: 'post',
                data: {
                    userid : "<?php echo $_SESSION['userId']; ?>"
                },
                success:function(response){
                //console.log(response);
                //return;
                    $("#inbox").append(response); 
                }
            });
         }
</script>
    <style>
    
    #head{
        background-color:gray;
        color:white;
    }
    
    tr{
        border: 2px solid gray;
    }
        th{
            text-align:center;
        }
        #msg{
            text-align:justify;
        }
        
    </style>
</head>
<body>
   
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <!-- Admin Access Only -->
            <?php if ($_SESSION['role'] == "ADMIN") : ?>
                <div id="admin-container">
                    <h2 class="text-center">Admin</h2>
                </div>
            <?php endif; ?>
            <!-- BDM Access Only -->
            <?php if ($_SESSION['role'] == "BDM") : ?>
             <?php
                  if(isset($_SESSION['successmsg']))
                  {
                       $successmsg =  $_SESSION['successmsg'] ;
                       echo "<div class='alert alert-success text-center'>" .$successmsg."</div>";
                       unset( $_SESSION['successmsg']);
                  
                  }
                 ?>
             <?php
                if(isset($_SESSION['userId']))
                {
                    $user_Id= $_SESSION['userId'];
                }
                
                     
             ?>
           
           
            <h3 class="text-center">  Inbox  </h3>
            <div class="row">
                <div clss="col-sm-1"></div>
                <div clss="col-sm-10" style="overflow-x:auto;"> 
                    <div id="bdm-container" style="overflow-y:auto;">
                    <table class="table table-striped table-bordered">
                        <thead id="head">
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>Message</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody id="inbox">
                            
                 
                    </tbody>
                    </table>
                    </div>
                    </div>
                    <div clss="col-sm-1">
                    </div>
                   </div>
               
            <?php endif; ?>
            <!-- BDE Access Only -->
            <?php if ($_SESSION['role'] == "BDE") : ?>
                <div id="bde-container">
                    <h2 class="text-center">BDE</h2>
                </div>
            <?php endif; ?>
        </div> 
    </div>
    <?php include 'footer.php';?>

</body>
</html>