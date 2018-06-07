<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
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
                    <h2 class="text-center">Configurations / Locations Configuration</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row text-center menu-bar">
                        <div class="col-sm-12">
                            <button id="back-btn" class="btn btn-primary action-btn btn-identical-dimension" onclick="gotoConfigPage()">Back</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <a class="config-item-wrapper-link" href="addlocation.php">
                                <div class="config-item">
                                    <div class="config-item-thumbnail">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="config-item-name">
                                        <h3>Add Locations</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3">
                            <a class="config-item-wrapper-link" href="locationlist.php">
                                <div class="config-item">
                                    <div class="config-item-thumbnail">
                                        <span class="glyphicon glyphicon-list"></span>
                                    </div>
                                    <div class="config-item-name">
                                        <h3>Locations List</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        function gotoConfigPage() {
            window.location.href = "configurations.php";
        }
    </script>
</body>
</html>
                    