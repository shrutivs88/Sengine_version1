<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

if(!isset($_SESSION["serverData"])) {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');

$errContacts = $_SESSION['serverData'];
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
                    <h2 class="text-center">Failed To Add Some Client Contact</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                                <?php
                                    foreach ($errContacts as $key=>$value) {
                                        echo "<h3>Contact ".($key+1)."</h3>";
                                        echo "<table class='table table-bordered app-table-theme'>";
                                        echo "<tr class='err-reason'>";
                                        echo "<th>Reason</th>";
                                        echo "<td>".$value["errMsg"]."</td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<th>First Name</th>";
                                        echo "<td>".$value["errContact"]->firstName."</td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<th>Last Name</th>";
                                        echo "<td>".$value["errContact"]->lastName."</td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<th>Email</th>";
                                        echo "<td>".$value["errContact"]->email."</td>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<th>Mobile</th>";
                                        echo "<td>".$value["errContact"]->mobile."</td>";
                                        echo "</tr>";
                                        echo "</table>";
                                    }
                                ?>
                            <div>
                                <h3 class="text-center"><a href="<?php echo BASEURL ?>views/login.php">&lt;&lt; Go Back</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
</body>
</html>