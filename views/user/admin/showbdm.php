<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/UserService.php');

$userService = new UserService();
$bdeId = $_GET["bdeId"];
$bde = $userService->getUserById($bdeId);
$bdm = $userService->getUserByEmpId($bde->getManager());

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
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="text-center">B.D.M Of "<?php echo $bde->getName(); ?>"</h2>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-info" role="alert">
                                <button class="btn btn-info action-btn btn-identical-dimension" onclick="showBdeList()">Back</button>
                            </div>
                            <table class="table table-bordered app-table-theme">
                                <tr>
                                    <th>Full Name</th>
                                    <td><?php echo $bdm->getName(); ?></td>
                                </tr>
                                <tr>
                                    <th>E-Mail Address</th>
                                    <td><?php echo $bdm->getEmail(); ?></td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td><?php echo $bdm->getPassword(); ?></td>
                                </tr>
                            </table>
                            <div class="alert alert-danger" role="alert">
                                <button class="btn btn-danger action-btn btn-identical-dimension" onclick="unassignBde()">Unassign</button><span>Note: Unassign does NOT remove the BDE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        function unassignBde() {
            var result = confirm("Are You Sure?");
            if(result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASEURL ?>actions/admin/performunassignbde.php",
                    data: {
                        bdeId: <?php echo $bde->getId(); ?>
                    },
                    success: function(response) {
                        window.location = 'bdelist.php';
                    }
                });
            }
        }

        function showBdeList() {
            window.location.href = 'bdelist.php';
        }
    </script>
</body>
</html>