<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location:../login.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
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
            client_bde_count_fetch();
            
        });
     
         function client_bde_count_fetch(){
            $.ajax({
                url: '<?php echo BASEURL; ?>actions/bdm/performfetchhomeforbdm.php',
                type: 'post',
                data: {
                    userid : "<?php echo $_SESSION['userId']; ?>"
                },
                success:function(response){
                //console.log(response);
                //return;
                
                   $("#count_client").append(response[0]);
                   $("#count_bde").append(response[1]);
                }
            });
         }
          
        
    </script>
    <style>
        #bde_count{
            height:250px;
            width:250px;
            border:1px solid black;
            background-color:white;
            color:white;
            margin:10px;
        }
        #bde{
            text-decoration:none;
        }
        #client{
            text-decoration:none;
        }
        
        #client_count{
            height:250px;
            width:250px;
            border:2px;
            border:1px solid black;
            background-color:white;
            color:white;
            margin:10px;
        }
        #count_bde{
            font-size:100px;
            color:black;
        }
         #count_client{
            font-size:100px;
             color:black;
        }
        h3{
            color:black;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <?php include("sidemenu.php"); ?>
                </div>
                <div class="col-sm-9">
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <!-- Admin Access Only -->
                    <?php if ($_SESSION['role'] == "ADMIN") : ?>
                        <div id="admin-container">
                        <div class="panel panel-default">
                            <div class="panel-heading">Tracking</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a class="home-item-wrapper-link" href="admin/bdmlist.php">
                                            <div class="home-item">
                                                <div class="home-item-name">
                                                    <h3>BDM Count</h3>
                                                </div>
                                                <div class="home-item-value">
                                                    <h1 id="bdm-count"></h1>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a class="home-item-wrapper-link" href="admin/bdelist.php">
                                            <div class="home-item">
                                                <div class="home-item-name">
                                                    <h3>BDE Count</h3>
                                                </div>
                                                <div class="home-item-value">
                                                    <h1 id="bde-count"></h1>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a class="home-item-wrapper-link" href="admin/clientcompanylist.php">
                                            <div class="home-item">
                                                <div class="home-item-name">
                                                    <h3>Client Companies Count</h3>
                                                </div>
                                                <div class="home-item-value">
                                                    <h1 id="client-companies-count"></h1>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a class="home-item-wrapper-link" href="admin/clientcontactlist.php">
                                            <div class="home-item">
                                                <div class="home-item-name">
                                                    <h3>Client Contacts Count</h3>
                                                </div>
                                                <div class="home-item-value">
                                                    <h1 id="client-contacts-count"></h1>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <?php endif; ?>
                    <!-- BDM Access Only -->
                    <?php if ($_SESSION['role'] == "BDM") : ?>
                        <div id="bdm-container">
                            <h2 class="text-center"> TRACKING </h2>
                            <div class="row">
                                <div class="col-sm-2"></div>
                                 <a  href="bdm/bdelist.php">
                                    <div class="col-sm-4" id="bde_count">
                                       <div>
                                            <h3 class="text-center">BDE Count</h3>
                                            <p class="text-center" id="count_bde"> </p>
                                       </div>  
                                    </div>
                                 </a>
                                    <div class="col-sm-1"></div>
                                 <a  href="bdm/clientlist.php">
                                    <div class="col-sm-4" id="client_count">
                                        <div>
                                            <h3 class="text-center">Client Contacts Count</h3>
                                            <p class="text-center" id="count_client"> </p>
                                        </div>
                                    </div>
                                 </a>
                                 <div class="col-sm-1"></div>
                            </div>
                        </div>
                     
                    <?php endif; ?>
                    <!-- BDE Access Only -->
                    <?php if ($_SESSION['role'] == "BDE") : ?>
                        <div id="bde-container" class="role-container">
                            <h2 class="text-center">Welcome BDE</h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div> 
    </div>
    <?php include 'footer.php';?>
    <script>
        $(document).ready(function() {
            loadHomePageData();
        });

        function loadHomePageData() {
            $.ajax({
                type: "GET",
                url: "<?php echo BASEURL ?>actions/admin/performfetchhomedata.php",
                success: function(response) {
                    $("#bdm-count").html(response.bdmsCount);
                    $("#bde-count").html(response.bdesCount);
                    $("#client-companies-count").html(response.clientCompaniesCount);
                    $("#client-contacts-count").html(response.clientContactsCount);
                    console.log(response);
                }
            });
        }
    </script>
</body>
</html>