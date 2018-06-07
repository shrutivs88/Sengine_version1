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
$bdmId = $_GET["bdmId"];
$user = $userService->getUserById($bdmId);
$managerId = $user->getEmpId();


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
                            <h2 class="text-center">B.D.Es of "<?php echo $user->getName(); ?>"</h2>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-info" role="alert">
                                <button class="btn btn-info action-btn btn-identical-dimension" onclick="showBdmList()">Back</button>
                            </div>
                            <div id="bde-div">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="info">
                                            <th>Full Name</th>
                                            <th>E-Mail Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bde-list"></tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <button id="load-more-btn" class="btn btn-default text-center" onclick="loadByLimit()">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        var updateOffset = 0;
        var isUpdateOffsetPristine = true;

        $(document).ready(function() {
            loadByLimit();
        });

        function loadByLimit() {
            $("#load-more-btn").prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchbdelistforbdm.php",
                data: {
                    offset: updateOffset,
                    managerId: <?php echo $managerId; ?>
                },
                success: function(response) {
                    if(response.length == 0 && isUpdateOffsetPristine == true) {
                        $("#bde-div").html("<h4 class='text-center'>No BDEs Are Assigned!</h4>");
                        $("#load-more-btn").hide();
                        return;
                    } else if(response.length == 0 && isUpdateOffsetPristine == false) {
                        $("#bde-div").append("<h4 class='text-center'>No More BDEs Are Assigned!</h4>");
                        $("#load-more-btn").hide();
                        return;
                    }
                    var bdeListBuilder = "";
                    if(response.length == 0) {
                        $("#bde-div").html("<h4 class='text-center'>No BDEs Are Assigned!</h4>");
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        bdeListBuilder += "<tr>";
                        bdeListBuilder += "<td>" + response[i].name + "</td>";
                        bdeListBuilder += "<td>" + response[i].email + "</td>";
                        bdeListBuilder += "<td><button class='btn btn-danger' onclick='unassignBde(" + response[i].id + ")'>Unassign</button></td>";
                        bdeListBuilder += "</tr>";
                    }
                    $("#bde-list").append(bdeListBuilder);
                    updateOffset += <?php echo BDE_LIST_LIMIT; ?>;
                    isUpdateOffsetPristine = false;
                    $("#load-more-btn").prop('disabled', false);
                }
            });
        }

        function unassignBde(userId) {
            var result = confirm("Are You Sure?");
            if(result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASEURL ?>actions/admin/performunassignbde.php",
                    data: {
                        bdeId: userId
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        }

        function showBdmList() {
            window.location.href = 'bdmlist.php';
        }

    </script>
</body>
</html>