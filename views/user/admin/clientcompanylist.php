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
                    <h2 class="text-center">Client Company List</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div id="company-div" class="data-list-wrapper">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Name</th>
                                    <th>Website</th>
                                    <th>Phone</th>
                                    <th>E-Mail</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="company-list"></tbody>
                        </table>
                    </div>
                    <div class="text-center" id="options-div">
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
            url: "<?php echo BASEURL ?>actions/admin/performfetchcompanylist.php",
            data: {
                offset: updateOffset
            },
            success: function(response) {
                var companyListBuilder = "";
                if(response.length == 0 && isUpdateOffsetPristine == true) {
                    $("#company-div").html("<h4 class='text-center'>No Companies Are Available!</h4>");
                    $("#load-more-btn").hide();
                    return;
                } else if(response.length == 0 && isUpdateOffsetPristine == false) {
                    $("#company-div").append("<h4 class='text-center'>No More Companies Are Available!</h4>");
                    $("#load-more-btn").hide();
                    return;
                }
                if(response.length == 0) {
                    $("#company-div").html("<h4 class='text-center'>No Companies Are Available!</h4>");
                    return;
                }
                for(var i=0; i<response.length; i++) {
                    companyListBuilder += "<tr>";
                    companyListBuilder += "<td>" + response[i].name + "</td>";
                    companyListBuilder += "<td>" + response[i].website + "</td>";
                    companyListBuilder += "<td>" + response[i].phone + "</td>";
                    companyListBuilder += "<td>" + response[i].email + "</td>";
                    companyListBuilder += "<td><button class='btn btn-default action-btn' onclick='showCompany(" + response[i].id + ")'><span class='glyphicon glyphicon-eye-open'></span></button><button class='btn btn-default action-btn' onclick='deleteCompany(" + response[i].id + ")'><span class='glyphicon glyphicon-trash'></span></button></td>";
                    companyListBuilder += "</tr>";
                }
                $("#company-list").append(companyListBuilder);
                updateOffset += <?php echo COMPANY_LIST_LIMIT; ?>;
                isUpdateOffsetPristine = false;
                $("#load-more-btn").prop('disabled', false);
            },
            error: function(response) {
                $("#company-div").html("<h4 class='text-center'>Something Went Wrong!</h4>");
                $("#options-div").html("<button id='load-more-btn' class='btn btn-default text-center' onclick='location.reload()'>Reload Page</button>");
            }
        });
    }

    function showCompany(companyId) {
        window.location = 'showcompany.php?companyId=' + companyId;
    }

    function deleteCompany(companyId) {
        var result = confirm("Are You Sure?");
        if(result) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performdeletecompany.php",
                data: {
                    companyId: companyId
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