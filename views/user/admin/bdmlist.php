<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/RoleService.php');

$roleService = new RoleService();
$role = $roleService->getByRoleName("BDM");

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
                    <h2 class="text-center">B.D.M List</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div id="bdm-div">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="info">
                                    <th>Full Name</th>
                                    <th>E-Mail Address</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="bdm-list"></tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button id="load-more-btn" class="btn btn-default text-center" onclick="loadByLimit()">Load More</button>
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
                url: "<?php echo BASEURL ?>actions/admin/performfetchbdmlist.php",
                data: {
                    offset: updateOffset,
                    roleId: <?php echo $role->getId(); ?>
                },
                success: function(response) {
                    if(response.length == 0 && isUpdateOffsetPristine == true) {
                        $("#bdm-div").html("<h4 class='text-center'>No BDMs Are Available!</h4>");
                        $("#load-more-btn").hide();
                        return;
                    } else if(response.length == 0 && isUpdateOffsetPristine == false) {
                        $("#bdm-div").append("<h4 class='text-center'>No More BDMs Are Available!</h4>");
                        $("#load-more-btn").hide();
                        return;
                    }
                    var bdmListBuilder = "";
                    if(response.length == 0) {
                        $("#bdm-div").html("<h4 class='text-center'>No BDMs Are Available!</h4>");
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        bdmListBuilder += "<tr>";
                        bdmListBuilder += "<td>" + response[i].name + "</td>";
                        bdmListBuilder += "<td>" + response[i].email + "</td>";
                        bdmListBuilder += "<td>" + response[i].password + "</td>";
                        bdmListBuilder += "<td><button title='Show BDEs' class='btn btn-default action-btn' onclick='showBDEs(" + response[i].id + ")'><span class='glyphicon glyphicon-pawn'></span></button><button title='Edit' class='btn btn-default action-btn' onclick='editBdm(" + response[i].id + ")'><span class='glyphicon glyphicon-edit'></span></button><button title='Delete' class='btn btn-default action-btn' onclick='deleteBdm(" + response[i].id + "," + response[i].empId + ")'><span class='glyphicon glyphicon-trash'></span></button></td>";
                        bdmListBuilder += "</tr>";
                    }
                    $("#bdm-list").append(bdmListBuilder);
                    updateOffset += <?php echo BDM_LIST_LIMIT; ?>;
                    isUpdateOffsetPristine = false;
                    $("#load-more-btn").prop('disabled', false);
                }
            });
        }

        function editBdm(userId) {
            window.location = 'editbdm.php?roleId=' + <?php echo $role->getId(); ?> + '&' + 'userId=' + userId;
        }

        function showBDEs(userId) {
            window.location = 'showbdes.php?bdmId=' + userId;
        }

        function deleteBdm(userId, empId) {
            var result = confirm("Are You Sure?");
            if(result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASEURL ?>actions/admin/performdeletebdm.php",
                    data: {
                        userId: userId,
                        empId: empId
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>