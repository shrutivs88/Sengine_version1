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
                    <h2 class="text-center">Client Contact List</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div id="contact-div" class="data-list-wrapper">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Actions</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="contact-list"></tbody>
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
            url: "<?php echo BASEURL ?>actions/admin/performfetchcontactlist.php",
            data: {
                offset: updateOffset
            },
            success: function(response) {
                var contactListBuilder = "";
                if(response.length == 0 && isUpdateOffsetPristine == true) {
                    $("#contact-div").html("<h4 class='text-center'>No Contacts Are Available!</h4>");
                    $("#load-more-btn").hide();
                    return;
                } else if(response.length == 0 && isUpdateOffsetPristine == false) {
                    $("#contact-div").append("<h4 class='text-center'>No More Contacts Are Available!</h4>");
                    $("#load-more-btn").hide();
                    return;
                }
                if(response.length == 0) {
                    $("#contact-div").html("<h4 class='text-center'>No Contacts Are Available!</h4>");
                    return;
                }
                for(var i=0; i<response.length; i++) {
                    contactListBuilder += "<tr>";
                    contactListBuilder += "<td>" + response[i].firstName + "</td>";
                    contactListBuilder += "<td>" + response[i].lastName + "</td>";
                    contactListBuilder += "<td>" + response[i].email + "</td>";
                    contactListBuilder += "<td>" + response[i].mobile + "</td>";
                    contactListBuilder += "<td><button class='btn btn-default action-btn' onclick='showContact(" + response[i].id + ")'><span class='glyphicon glyphicon-eye-open'></span></button><button class='btn btn-default action-btn' onclick='deleteContact(" + response[i].id + ")'><span class='glyphicon glyphicon-trash'></span></button></td>";
					
					if((response[i].status=="Send Proposal")||(response[i].status=="New")) 
					{
						contactListBuilder += "<td><a href='sendproposal.php?contactId=" + response[i].id + "'><p style='color:green;'>Send Proposal</p></a></td>";                          
					}
                    else
					{
						contactListBuilder += "<td><p style='color:red;'>Proposal Sent</p></td>"; 
					} 
						
                    contactListBuilder += "</tr>";
                }
                $("#contact-list").append(contactListBuilder);
                updateOffset += <?php echo CONTACT_LIST_LIMIT; ?>;
                isUpdateOffsetPristine = false;
                $("#load-more-btn").prop('disabled', false);
            },
            error: function(response) {
                $("#contact-div").html("<h4 class='text-center'>Something Went Wrong!</h4>");
                $("#options-div").html("<button id='reload-btn' class='btn btn-default text-center' onclick='location.reload()'>Reload Page</button>");
            }
        });
    }

    function showContact(contactId) {
        window.location = 'showcontact.php?contactId=' + contactId;
    }

    function deleteContact(contactId) {
        var result = confirm("Are You Sure?");
        if(result) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performdeletecontact.php",
                data: {
                    contactId: contactId
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