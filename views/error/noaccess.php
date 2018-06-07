<?php
session_start();
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
    <?php
    if(!isset($_SESSION["email"])) {
        include($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/views/navbar-unauth.php');
    } else {
        include($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/views/user/navbar.php');
    }
    ?>
    <div class="content-view">
        <div class="container-fluid">
            <div class="noaccess-msg">
                <h2 class="text-center">You're trying to access a <span style="color:red;">Fobidden<span> resource</h2>
                <h3 class="text-center"><a href="<?php echo BASEURL ?>views/login.php">&lt;&lt; Go Back</a></h3>
            </div>
        </div>
    </div>
    <?php
    if(!isset($_SESSION["email"])) {
        include($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/views/footer.php');
    } else {
        include($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/views/user/footer.php');
    }
    ?>
</body>
</html>