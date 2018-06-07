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
                    <h2 class="text-center">Add New B.D.M</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <form id="addBDMForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/admin/performaddbdm.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2" for="fname">Full Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="fname" id="fname" placeholder="Enter Full Name" class="form-control" onfocusout="validate_fname()">
                                        <p id="fnameErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2" for="email">Email Id</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="email" id="email" placeholder="Enter Email Id" class="form-control" onfocusout="validate_email()">
                                        <p id="emailErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2" for="pass">Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pass" id="pass" placeholder="Enter Password" class="form-control" value="<?php echo DEFAULT_PASSWORD; ?>" readonly>
                                        <p id="passErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="add-btn" type="button" class="btn btn-primary form-btn" onclick="addBDMFormValidation()">Save</button>
                                        <button id="reset-btn" type="button" class="btn btn-warning form-btn" onclick="addBDMFormReset()">Clear</button>
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
        var emailFormatRegEx = new RegExp("^\\w+([\\.-]?\\w+)*@\\w+([\\.-]?\\w+)*(\\.\\w{2,3})+$");
        var fname = "";
        var fnameErrMsg = "";
        var fnameErrFlag = true;
        var email = "";
        var emailErrMsg = "";
        var emailErrFlag = true;
        /**
        name validation */
        function validate_fname() {
            fname = $("#fname").val();
            fnameErrFlag = false;
            fnameErrMsg = "";
            $("#fname").css({"border-color":"green"});
            if(fname == "" || fname == null || fname == undefined) {
                fnameErrFlag = true;
                fnameErrMsg = "Full Name Is Required !";
                $("#fname").css({"border-color":"red"});
            }
            $("#fnameErrMsg").text(fnameErrMsg);
        }

        /**
        email validation */
        function validate_email() {
            email = $("#email").val();
            emailErrFlag = false;
            emailErrMsg = "";
            $("#email").css({"border-color":"green"});
            if(email == "" || email == null || email == undefined) {
                emailErrFlag = true;
                emailErrMsg = "E-Mail Is Required !";
                $("#email").css({"border-color":"red"});
            } else if(!emailFormatRegEx.test(email)) {
                emailErrFlag = true;
                emailErrMsg = "E-Mail Is Not Valid !";
                $("#email").css({"border-color":"red"});
            }
            $("#emailErrMsg").text(emailErrMsg);
        }

        /**
        enter key submit */
        $("#addBDMForm").keypress(function(e) {
            if(e.which == 13) {
                addBDMFormValidation();
            }
        });

        /**
        form validation and submitting */
        function addBDMFormValidation() {
            $("#server-message").text("");
            validate_fname();
            validate_email();
            if(fnameErrFlag == false && emailErrFlag == false) {
                $("#fname").prop('readonly', true);
                $("#email").prop('readonly', true);
                $("#reset-btn").prop('disabled', true);
                $("#add-btn").prop('disabled', true);
                $("#addBDMForm").submit();
            }
        }

        /**
        form reset */
        function addBDMFormReset() {
            fnameErrFlag = true;
            emailErrFlag = true;
            fnameErrMsg = "";
            emailErrMsg = "";
            $("#fnameErrMsg").text("");
            $("#emailErrMsg").text("");
            $("#fname").val("");
            $("#email").val("");
            $("#fname").css({"border-color":"#ccc"});
            $("#email").css({"border-color":"#ccc"});
            $("#server-message").text("");
        }
    </script>
</body>
</html>