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
    <script src="<?php echo BASEURL; ?>assets/js/admin/mailConfigValidation.js"></script>
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
                    <h2 class="text-center">Configurations / Mail Configuration / Mail Setup</h2>
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
                            <button id="back-btn" class="btn btn-primary action-btn btn-identical-dimension" onclick="gotoMailConfigPage()">Back</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <form id="mailConfigForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/admin/performsavemailconfig.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Host</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="mailConfigHost" id="mailConfigHost" placeholder="Enter Host" class="form-control" onfocusout="validateMailConfigHost()">
                                        <p id="mailConfigHostErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">User Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="mailConfigUserName" id="mailConfigUserName" placeholder="Enter User Name" class="form-control" onfocusout="validateMailConfigUserName()">
                                        <p id="mailConfigUserNameErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Password</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="mailConfigPassword" id="mailConfigPassword" placeholder="Enter Password" class="form-control" onfocusout="validateMailConfigPassword()">
                                        <p id="mailConfigPasswordErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="add-btn" type="button" class="btn btn-primary form-btn" onclick="mailConfigFormValidation()">Save</button>
                                        <button id="reset-btn" type="button" class="btn btn-warning form-btn" onclick="mailConfigFormReset()">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        function gotoMailConfigPage() {
            window.location.href = "mailconfiguration.php";
        }

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo BASEURL ?>actions/admin/performfetchmailconfig.php",
                success: function(response) {
                    $("#mailConfigHost").val(response.mailConfigHost);
                    $("#mailConfigUserName").val(response.mailConfigUserName);
                    $("#mailConfigPassword").val(response.mailConfigPassword);
                }
            });
        });
        
    </script>
</body>
</html>         