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
$role = $roleService->getByRoleName("BDE");

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
                    <h2 class="text-center">B.D.E List</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div id="bde-div">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="info">
                                    <th>Full Name</th>
                                    <th>E-Mail Address</th>
                                    <th>Password</th>
                                    <th>Status</th>
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
                url: "<?php echo BASEURL ?>actions/admin/performfetchbdelist.php",
                data: {
                    offset: updateOffset,
                    roleId: <?php echo $role->getId(); ?>
                },
                success: function(response) {
                    if(response.length == 0 && isUpdateOffsetPristine == true) {
                        $("#bde-div").html("<h4 class='text-center'>No BDEs Are Available!</h4>");
                        $("#load-more-btn").hide();
                        return;
                    } else if(response.length == 0 && isUpdateOffsetPristine == false) {
                        $("#bde-div").append("<h4 class='text-center'>No More BDEs Are Available!</h4>");
                        $("#load-more-btn").hide();
                        return;
                    }
                    var bdeListBuilder = "";
                    if(response.length == 0) {
                        $("#bde-div").html("<h4 class='text-center'>No BDEs Are Available!</h4>");
                        return;
                    }
                    var status = false;
                    for(var i=0; i<response.length; i++) { 
                        if(response[i].manager == 0) {
                            status = false;
                        } else {
                            status = true;
                        }
                        bdeListBuilder += "<tr>";
                        bdeListBuilder += "<td>" + response[i].name + "</td>";
                        bdeListBuilder += "<td>" + response[i].email + "</td>";
                        bdeListBuilder += "<td>" + response[i].password + "</td>";
                        if(status == true) {
                            bdeListBuilder += "<td><span style='color:green;'>ASSIGNED</span></td>";
                            bdeListBuilder += "<td><button title='Show BDM' class='btn btn-default action-btn' onclick='showBDM(" + response[i].id + ")'><span class='glyphicon glyphicon-knight'></span></button><button title='Edit' class='btn btn-default action-btn' onclick='editBde(" + response[i].id + ")'><span class='glyphicon glyphicon-edit'></span></button><button title='Delete' class='btn btn-default action-btn' onclick='deleteBde(" + response[i].id + ")'><span class='glyphicon glyphicon-trash'></span></button></td>";
                        } else {
                            bdeListBuilder += "<td><span style='color:red;'>UNASSIGNED</span></td>";
                            bdeListBuilder += "<td><button title='Assign BDM' class='btn btn-default action-btn' onclick='assignBDM(" + response[i].id + ")'><span class='glyphicon glyphicon-plus'></span></button><button title='Edit' class='btn btn-default action-btn' onclick='editBde(" + response[i].id + ")'><span class='glyphicon glyphicon-edit'></span></button><button title='Delete' class='btn btn-default action-btn' onclick='deleteBde(" + response[i].id + ")'><span class='glyphicon glyphicon-trash'></span></button></td>";
                        }
                        bdeListBuilder += "</tr>";
                    }
                    $("#bde-list").append(bdeListBuilder);
                    updateOffset += <?php echo BDE_LIST_LIMIT; ?>;
                    isUpdateOffsetPristine = false;
                    $("#load-more-btn").prop('disabled', false);
                }
            });
        }

        function editBde(userId) {
            window.location = 'editbde.php?roleId=' + <?php echo $role->getId(); ?> + '&' + 'userId=' + userId;
        }

        function deleteBde(userId) {
            var result = confirm("Are You Sure?");
            if(result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASEURL ?>actions/admin/performdeletebde.php",
                    data: {
                        userId: userId
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        }

        function showBDM(userId) {
            window.location = 'showbdm.php?bdeId=' + userId;
        }

        function assignBDM(userId) {
            window.location = 'assignbdm.php?bdeId=' + userId;
        }

    </script>
</body>
</html>