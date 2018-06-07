<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');

$companyId = $_GET["companyId"];

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
    <script src="<?php echo BASEURL; ?>assets/js/admin/editClientCompanyValidation.js"></script>
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
                            <h2 class="text-center" id="company-name-heading"></h2>
                        </div>
                        <div class="panel-body">
                            <div>
                                <button id="add-btn" class="btn btn-primary action-btn" onclick="addContact()">Add Contact</button>
                                <button id="edit-btn" class="btn btn-warning action-btn btn-identical-dimension" onclick="editCompany()">Edit</button>
                                <button id="save-btn" class="btn btn-success action-btn btn-identical-dimension" onclick="saveCompany()">Save</button>
                                <button id="reset-btn" class="btn btn-danger action-btn btn-identical-dimension" onclick="resetCompany()">Cancel</button>
                            </div>
                            <form id="company-form" action="<?php echo BASEURL; ?>actions/admin/performupdatecompany.php" method="post">
                                <table class="table table-bordered app-table-theme">
                                    <tr id="company-name-tr">
                                        <th>Company Name</th>
                                        <td id="company-name-td"></td>
                                    </tr>
                                    <tr id="company-website-tr">
                                        <th>Company Website</th>
                                        <td id="company-website-td"></td>
                                    </tr>
                                    <tr id="company-address-tr">
                                        <th>Company Address</th>
                                        <td id="company-address-td"></td>
                                    </tr>
                                    <tr id="comapny-phone-tr">
                                        <th>Company Phone</th>
                                        <td id="company-phone-td"></td>
                                    </tr>
                                    <tr id="company-email-tr">
                                        <th>Company Email</th>
                                        <td id="company-email-td"></td>
                                    </tr>
                                    <tr id="company-linkedin-tr">
                                        <th>Company Linkedin</th>
                                        <td id="company-linkedin-td"></td>
                                    </tr>
                                </table>
                            </form>
                            <div id="options-div">
                                <button class="btn btn-primary action-btn" onclick="showContacts()">Show Contacts</button>
                            </div>
                            <div id="contact-div" class="data-list-wrapper">
                                <table class="table table-striped table-hover table-bordered" id="contact-table"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>

        $(document).ready(function() {
            $("#edit-btn").hide();
            $("#reset-btn").hide();
            $("#save-btn").hide();
            loadContact("<?php echo $companyId; ?>");
        });

        function loadContact(companyId) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchcompany.php",
                data: {
                    companyId: companyId
                },
                success: function(companyResponse) {
                    $("#company-name-heading").text('Company "' + companyResponse.name + '"');
                    $("#company-name-td").text(companyResponse.name);
                    $("#company-website-td").text(companyResponse.website);
                    $("#company-address-td").text(companyResponse.address);
                    $("#company-phone-td").text(companyResponse.phone);
                    $("#company-email-td").text(companyResponse.email);
                    $("#company-linkedin-td").text(companyResponse.linkedin);
                    $("#edit-btn").show();
                }
            });
        }

        function addContact() {
            window.location.href = "addclientcontact.php?companyId=<?php echo $companyId; ?>";
        }

        function editCompany() {
            $("#edit-btn").hide();
            buildAllInputFields();
            $("#save-btn").show();
            $("#reset-btn").show();
        }

        function buildAllInputFields() {
            $("#company-form").append("<input type='hidden' name='companyId' value='<?php echo $companyId; ?>'>");
            $("#company-form").append("<input type='hidden' name='companyOriginalWebsite' value='" + $("#company-website-td").text() + "'>");
            $("#company-name-td").html("<input id='companyName' name='companyName' type='text' class='form-control inline-form-control' value='" + $("#company-name-td").text() + "' onfocusout='validateCompanyName()'>");
            $("#company-website-td").html("<input id='companyWebsite' name='companyWebsite' type='text' class='form-control inline-form-control' value='" + $("#company-website-td").text() + "' onfocusout='validateCompanyWebsite()'>");
            $("#company-address-td").html("<textarea id='companyAddress' name='companyAddress' class='form-control' style='resize: none;' onfocusout='validateCompanyAddress()'>" + $("#company-address-td").text() + "</textarea>");
            $("#company-phone-td").html("<input id='companyPhone' name='companyPhone' type='text' class='form-control inline-form-control' value='" + $("#company-phone-td").text() + "' onfocusout='validateCompanyPhone()'>");
            $("#company-email-td").html("<input id='companyEmail' name='companyEmail' type='text' class='form-control inline-form-control' value='" + $("#company-email-td").text() + "' onfocusout='validateCompanyEmail()'>");
            $("#company-linkedin-td").html("<input id='companyLinkedIn' name='companyLinkedIn' type='text' class='form-control inline-form-control' value='" + $("#company-linkedin-td").text() + "' onfocusout='validateCompanyLinkedIn()'>");
        }

        function saveCompany() {
            /**
             * isFormValid implementation is in editClientCompanyValidation.js
             */
            if(isFormValid()) {
                $("#company-form").submit();
            }
        }

        function resetCompany() {
            window.location.reload();
        }

        function showContacts() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchcontactsforcompany.php",
                data: {
                    companyId: <?php echo $companyId; ?> 
                },
                success: function(contactResponse) {
                    var contactListBuilder = "";
                    $("#options-div").html("<h3>Contacts:</h3>");
                    if(contactResponse.length == 0) {
                        $("#contact-div").html("<h4 class='text-center'>No Contacts Are Available!</h4>");
                        return;
                    }
                    contactListBuilder += "<thead>";
                    contactListBuilder += "<tr class='info'>";
                    contactListBuilder += "<th>First Name</th>";
                    contactListBuilder += "<th>Last Name</th>";
                    contactListBuilder += "<th>Email</th>";
                    contactListBuilder += "<th>Mobile</th>";
                    contactListBuilder += "<th>Actions</th>";
                    contactListBuilder += "</tr>";
                    contactListBuilder += "</thead>";
                    contactListBuilder += "<tbody>";
                    for(var i=0; i<contactResponse.length; i++) {
                        contactListBuilder += "<tr>";
                        contactListBuilder += "<td>" + contactResponse[i].firstName + "</td>";
                        contactListBuilder += "<td>" + contactResponse[i].lastName + "</td>";
                        contactListBuilder += "<td>" + contactResponse[i].email + "</td>";
                        contactListBuilder += "<td>" + contactResponse[i].mobile + "</td>";
                        contactListBuilder += "<td><button class='btn btn-default action-btn' onclick='showContact(" + contactResponse[i].id + ")'><span class='glyphicon glyphicon-eye-open'></span></button><button class='btn btn-default action-btn' onclick='deleteContact(" + contactResponse[i].id + ")'><span class='glyphicon glyphicon-trash'></span></button></td>";
                        contactListBuilder += "</tr>";
                    }
                    contactListBuilder += "</tbody>";
                    $("#contact-table").append(contactListBuilder);
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