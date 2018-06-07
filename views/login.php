<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');

if(isset($_SESSION["email"])) {
    header("Location:user/home.php");
}
$_SESSION['fromLogin'] = true;
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
    <?php include 'navbar-unauth.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <h3 class="text-center">Login</h3>
            <hr>
            <div class="server-message" id="server-message">
                <?php
                if(isset($_SESSION["serverMsg"])) {
                    echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                    unset($_SESSION['serverMsg']);
                }
                ?>
            </div>
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6 form-bg">
                    <br>
                    <form id="loginForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/performauth.php" method="post">
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
                                <input type="password" name="pass" id="pass" placeholder="Enter Password" class="form-control" onfocusout="validate_password()">
                                <p id="passErrMsg"></p>
                            </div>
                        </div>
                        <div class="form-group form-group-mod"> 
                            <div class="col-sm-12 text-center">
                                <button id="login-btn" type="button" class="btn btn-primary form-btn" onclick="loginFormValidation()">Login</button>
                                <button id="reset-btn" type="button" class="btn btn-warning form-btn" onclick="loginFormReset()">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        var emailFormatRegEx = new RegExp("^\\w+([\\.-]?\\w+)*@\\w+([\\.-]?\\w+)*(\\.\\w{2,3})+$");
        var email = "";
        var emailErrMsg = "";
        var emailErrFlag = true;
        var pass = "";
        var passErrMsg = "";
        var passErrFlag = true;
        
        /**
        Email Validation */
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
        passowrd validation */
        function validate_password() {
            pass = $("#pass").val();
            passErrFlag = false;
            passErrMsg = "";
            $("#pass").css({"border-color":"green"});
            if(pass == "" || pass == null || pass == undefined) {
                passErrFlag = true;
                passErrMsg = "Password Is Required !";
                $("#pass").css({"border-color":"red"});
            }
            $("#passErrMsg").text(passErrMsg);
        }

        /**
        Enter Key Submit */
        $("#loginForm").keypress(function(e) {
            if(e.which == 13) {
                loginFormValidation();
            }
        });

        /**
        Form validation and submitting */
        function loginFormValidation() {
            $("#server-message").text("");
            validate_email();
            validate_password();
            if(emailErrFlag == false && passErrFlag == false) {
                $("#email").prop('readonly', true);
                $("#pass").prop('readonly', true);
                $("#login-btn").prop('disabled', true);
                $("#reset-btn").prop('disabled', true);
                $("#loginForm").submit();
            }
        }

        /**
        Form reset */
        function loginFormReset() {
            emailErrFlag = true;
            passErrFlag = true;
            emailErrMsg = "";
            passErrMsg = "";
            $("#emailErrMsg").text("");
            $("#passErrMsg").text("");
            $("#email").val("");
            $("#pass").val("");
            $("#email").css({"border-color":"#ccc"});
            $("#pass").css({"border-color":"#ccc"});
            $("#server-message").text("");
        }
    </script>
</body>
</html>