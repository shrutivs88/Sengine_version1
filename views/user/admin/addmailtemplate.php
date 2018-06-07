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
    <script src="<?php echo BASEURL; ?>assets/js/admin/addMailTemplateValidation.js"></script>
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
                    <h2 class="text-center">Configurations / Mail Configuration / Mail Template / Add Template</h2>
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
                            <button id="back-btn" class="btn btn-primary action-btn btn-identical-dimension" onclick="gotoMailTemplatePage()">Back</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <form id="mailTemplateForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/admin/performaddmailtemplate.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Template Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="templateName" id="templateName" placeholder="Enter Template Name" class="form-control" onfocusout="validateTemplateName()">
                                        <p id="templateNameErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Template Header</label>
                                    <div class="col-sm-9">
                                        <textarea name="templateHeader" id="templateHeader" style="resize: none;" placeholder="Enter Template Header" class="form-control" onfocusout="validateTemplateHeader()"></textarea>
                                        <p id="templateHeaderErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Template Footer</label>
                                    <div class="col-sm-9">
                                        <textarea name="templateFooter" id="templateFooter" placeholder="Enter Template Footer" class="form-control" onfocusout="validateTemplateFooter()"></textarea>
                                        <p id="templateFooterErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="add-btn" type="button" class="btn btn-primary form-btn" onclick="mailTemplateFormValidation()">Save</button>
                                        <button id="reset-btn" type="button" class="btn btn-warning form-btn" onclick="mailTemplateFormReset()">Clear</button>
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
        function gotoMailTemplatePage() {
            window.location.href = "mailtemplate.php";
        }
    </script>
</body>
</html>