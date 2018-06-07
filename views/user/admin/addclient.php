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
    <script src="<?php echo BASEURL; ?>assets/js/admin/addClientCompanyValidation.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/admin/addClientContactValidation.js"></script>
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
                    <h2 class="text-center">Add New Client</h2>
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
                            <form id="addClientForm" class="form-horizontal" enctype="multipart/form-data" action="<?php echo BASEURL; ?>actions/admin/performaddclient.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyName" id="companyName" placeholder="Enter Company Name" class="form-control" onfocusout="validateCompanyName()">
                                        <p id="companyNameErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Website</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyWebsite" id="companyWebsite" placeholder="Enter Company Website" class="form-control" onfocusout="validateCompanyWebsite()">
                                        <p id="companyWebsiteErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyPhone" id="companyPhone" placeholder="Enter Company Phone" class="form-control" onfocusout="validateCompanyPhone()">
                                        <p id="companyPhoneErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company E-Mail</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyEmail" id="companyEmail" placeholder="Enter Company Email" class="form-control" onfocusout="validateCompanyEmail()">
                                        <p id="companyEmailErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company LinkedIn</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyLinkedIn" id="companyLinkedIn" placeholder="Enter Company LinkedIn" class="form-control" onfocusout="validateCompanyLinkedIn()">
                                        <p id="companyLinkedInErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Address</label>
                                    <div class="col-sm-9">
                                        <textarea name="companyAddress" id="companyAddress" placeholder="Enter Company Address" class="form-control" style="resize: none;" onfocusout="validateCompanyAddress()"></textarea>
                                        <p id="companyAddressErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Assign To BDM</label>
                                    <div class="col-sm-9">
                                        <select id="assignToBdm" name="assignToBdm" class="form-control" onfocusout="validateAssignToBdm()">
                                            <option value="">Select BDM</option>
                                        </select>
                                        <p id="assignToBdmErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Assign To BDE</label>
                                    <div class="col-sm-9">
                                        <select id="assignToBde" name="assignToBde" class="form-control" onfocusout="validateAssignToBde()">
                                            <option value="">Select BDE</option>
                                        </select>
                                        <p id="assignToBdeErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Contacts Form</label>
                                    <div class="col-sm-9">
                                        <div id="contacts-form-upload" class="form-group-mod-vertical-partition">
                                            <div id="client-contact-pool" class="client-contact-pool">
                                                <button id="add-contact-btn" type="button" class="btn btn-default form-btn" onclick="showContactForm()"><span class="glyphicon glyphicon-plus"></span> Add Contact</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Contacts CSV</label>
                                    <div class="col-sm-9">
                                        <div id="contacts-csv-upload" class="form-group-mod-vertical-partition">
                                            <div id="client-contact-pool" class="client-contact-pool">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input name="contactsCSV" type="file" class="btn btn-default">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="../../../assets/csv/sta-contact-template.csv" class="btn btn-info" download>Download Template</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' id='clientTotalContacts' name='clientTotalContacts' value="0">
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="add-btn" type="button" class="btn btn-primary form-btn" onclick="addClientFormValidation()">Save</button>
                                        <button id="reset-btn" type="button" class="btn btn-warning form-btn" onclick="addClientFormReset()">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="contactModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-mod">
            <div class="modal-content">
                <div class="modal-header modal-header-mod">
                    <h4 class="modal-title">Contact Form</h4>
                </div>
                <div class="modal-body">
                    <form id="addContactForm" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-first-name-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter First Name" class="form-control" onfocusout="validateContactFirstName()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-last-name-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Last Name" class="form-control" onfocusout="validateContactLastName()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-email-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">E-Mail</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter E-Mail Address" class="form-control" onfocusout="validateContactEmail()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-category-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Category</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Category" class="form-control" onfocusout="validateContactCategory()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-designation-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Designation</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Designation" class="form-control" onfocusout="validateContactDesignation()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-mobile-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Mobile" class="form-control" onfocusout="validateContactMobile()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-country-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Country</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" onfocusout="validateContactCountry()">
                                            <option value="">Select Country</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-state-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">State</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" onfocusout="validateContactState()">
                                            <option value="">Select State</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-city-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">City</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" onfocusout="validateContactCity()">
                                            <option value="">Select City</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-linkedin-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">LinkedIn</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter LinkedIn" class="form-control" onfocusout="validateContactLinkedIn()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-facebook-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Facebook</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Facebook" class="form-control" onfocusout="validateContactFacebook()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-twitter-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Twitter</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Twitter" class="form-control" onfocusout="validateContactTwitter()">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-address-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Address</label>
                                    <div class="col-sm-9">
                                        <textarea placeholder="Enter Address" class="form-control" style="resize: none;" onfocusout="validateContactAddress()"></textarea>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer modal-footer-mod">
                    <button id="contactModalSuccessBtn" type="button" class="btn btn-primary form-btn btn-identical-dimension"></button>
                    <button id="contactModalFailBtn" type="button" class="btn btn-danger form-btn btn-identical-dimension"></button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        var contactId = 0;

        function showContactForm() {
            $("#contactModalSuccessBtn").attr('onclick', 'addContactFieldsToMainForm()');
            $("#contactModalSuccessBtn").text('Add');
            $("#contactModalFailBtn").attr('onclick', 'cancelContact()');
            $("#contactModalFailBtn").text('Cancel');
            $("#contactModal").modal();
            loadCountriesIntoContactForm();
        }

        function cancelContact() {
            addContactFormReset();
            $('#contactModal').modal('toggle');
        }

        function validateContactFields() {
            validateContactFirstName();
            validateContactLastName();
            validateContactEmail();
            validateContactCategory();
            validateContactDesignation();
            validateContactMobile();
            validateContactCountry();
            validateContactState();
            validateContactCity();
            validateContactLinkedIn();
            validateContactFacebook();
            validateContactTwitter();
            validateContactAddress();
            if(contactFirstNameErrFlag == false && contactLastNameErrFlag == false && contactEmailErrFlag == false && 
                contactCategoryErrFlag == false && contactDesignationErrFlag == false && contactMobileErrFlag == false &&
                    contactCountryErrFlag == false && contactStateErrFlag == false && contactCityErrFlag == false && 
                        contactLinkedInErrFlag == false && contactFacebookErrFlag == false && contactTwitterErrFlag == false &&
                            contactAddressErrFlag == false) {
                                return true;
                            }
                            return false;          
        }

        /**
        Note: Main form is addClientForm 
        */
        function addContactFieldsToMainForm() {
            if(validateContactFields()) {
                contactId++;
                $('#clientTotalContacts').val(contactId);
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_firstName'  name='contact_form_" + contactId + "_firstName' value='" + $("#contact-first-name-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_lastName' name='contact_form_" + contactId + "_lastName' value='" + $("#contact-last-name-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_email' name='contact_form_" + contactId + "_email' value='" + $("#contact-email-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_category' name='contact_form_" + contactId + "_category' value='" + $("#contact-category-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_designation' name='contact_form_" + contactId + "_designation' value='" + $("#contact-designation-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_mobile' name='contact_form_" + contactId + "_mobile' value='" + $("#contact-mobile-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_country' name='contact_form_" + contactId + "_country' value='" + $("#contact-country-div select").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_state' name='contact_form_" + contactId + "_state' value='" + $("#contact-state-div select").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_city' name='contact_form_" + contactId + "_city' value='" + $("#contact-city-div select").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_linkedin' name='contact_form_" + contactId + "_linkedin' value='" + $("#contact-linkedin-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_facebook' name='contact_form_" + contactId + "_facebook' value='" + $("#contact-facebook-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_twitter' name='contact_form_" + contactId + "_twitter' value='" + $("#contact-twitter-div input").val() + "'>");
                $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_address' name='contact_form_" + contactId + "_address' value='" + $("#contact-address-div textarea").val() + "'>");
                $('#client-contact-pool').prepend("<div id='cmplx-btn-" + contactId + "' class='cmplx-btn btn btn-success form-btn'><div title='Edit Contact' class='cmplx-btn-wrapper' onclick='editContact(" + contactId + ")'>" + $("#contact-first-name-div input").val() + "</div><div class='cmplx-options-wrapper'><span title='Remove Contact' class='glyphicon glyphicon-remove' onclick='deleteContact(" + contactId + ")'></span></div></div>");
                addContactFormReset();
                $('#contactModal').modal('toggle');
            }
        }

        /**
        Edit Contact Ops
        */
        function editContact(id) {
            $("#contactModalSuccessBtn").attr('onclick', 'updateContact(' + id + ')');
            $("#contactModalSuccessBtn").text('Update');
            $("#contactModalFailBtn").attr('onclick', 'cancelUpdateContact()');
            $("#contactModalFailBtn").text('Cancel');
            $('#contactModal').modal();
            repopulateModal(id);
        }

        function repopulateModal(id) {
            $("#contact-first-name-div input").val($("#contact_form_" + id + "_firstName").val());
            $("#contact-last-name-div input").val($("#contact_form_" + id + "_lastName").val());
            $("#contact-email-div input").val($("#contact_form_" + id + "_email").val());
            $("#contact-category-div input").val($("#contact_form_" + id + "_category").val());
            $("#contact-designation-div input").val($("#contact_form_" + id + "_designation").val());
            $("#contact-mobile-div input").val($("#contact_form_" + id + "_mobile").val());
            $("#contact-country-div select").val($("#contact_form_" + id + "_country").val());
            $("#contact-state-div select").val($("#contact_form_" + id + "_state").val());
            $("#contact-city-div select").val($("#contact_form_" + id + "_city").val());
            $("#contact-linkedin-div input").val($("#contact_form_" + id + "_linkedin").val());
            $("#contact-facebook-div input").val($("#contact_form_" + id + "_facebook").val());
            $("#contact-twitter-div input").val($("#contact_form_" + id + "_twitter").val());
            $("#contact-address-div textarea").val($("#contact_form_" + id + "_address").val());
        }

        function updateContact(id) {
            if(validateContactFields()) {
                $("#contact_form_" + id + "_firstName").val($("#contact-first-name-div input").val());
                $("#contact_form_" + id + "_lastName").val($("#contact-last-name-div input").val());
                $("#contact_form_" + id + "_email").val($("#contact-email-div input").val());
                $("#contact_form_" + id + "_category").val($("#contact-category-div input").val());
                $("#contact_form_" + id + "_designation").val($("#contact-designation-div input").val());
                $("#contact_form_" + id + "_mobile").val($("#contact-mobile-div input").val());
                $("#contact_form_" + id + "_country").val($("#contact-country-div select").val());
                $("#contact_form_" + id + "_state").val($("#contact-state-div select").val());
                $("#contact_form_" + id + "_city").val($("#contact-city-div select").val());
                $("#contact_form_" + id + "_linkedin").val($("#contact-linkedin-div input").val());
                $("#contact_form_" + id + "_facebook").val($("#contact-facebook-div input").val());
                $("#contact_form_" + id + "_twitter").val($("#contact-twitter-div input").val());
                $("#contact_form_" + id + "_address").val($("#contact-address-div textarea").val());
                $("#cmplx-btn-" + id + " .cmplx-btn-wrapper").html($("#contact-first-name-div input").val());
                addContactFormReset();
                $('#contactModal').modal('toggle');
            }
        }

        function cancelUpdateContact() {
            addContactFormReset();
            $('#contactModal').modal('toggle');
        }

        /**
        Delete Contact Ops
        */
        function deleteContact(id) {
            var result = confirm("Are You Sure?");
            if(result) {
                $("#contact_form_" + id + "_firstName").remove();
                $("#contact_form_" + id + "_lastName").remove();
                $("#contact_form_" + id + "_email").remove();
                $("#contact_form_" + id + "_category").remove();
                $("#contact_form_" + id + "_designation").remove();
                $("#contact_form_" + id + "_mobile").remove();
                $("#contact_form_" + id + "_country").remove();
                $("#contact_form_" + id + "_state").remove();
                $("#contact_form_" + id + "_city").remove();
                $("#contact_form_" + id + "_linkedin").remove();
                $("#contact_form_" + id + "_facebook").remove();
                $("#contact_form_" + id + "_twitter").remove();
                $("#contact_form_" + id + "_address").remove();
                $("#cmplx-btn-" + id).remove();
                contactId--;
                $('#clientTotalContacts').val(contactId);
                if(contactId == 0) {
                    return;
                } 
                shiftContactFieldsInMainForm(id);
            }
        }

        function shiftContactFieldsInMainForm(id) {
            var originalContactId = contactId + 1;
            var firstName;
            var lastName;
            var email;
            var designation;
            var category;
            var mobile;
            var country;
            var state;
            var city;
            var linkedin;
            var facebook;
            var twitter;
            var address;
            for(var j = id; j <= originalContactId; j++) {
                firstName = $("#contact_form_" + (j+1) + "_firstName").val();
                $("#contact_form_" + (j+1) + "_firstName").attr('id', 'contact_form_' + j + '_firstName');
                $("#contact_form_" + j + "_firstName").attr('name', 'contact_form_' + j + '_firstName');
                $("#contact_form_" + j + "_firstName").val(firstName);
                lastName = $("#contact_form_" + (j+1) + "_lastName").val();
                $("#contact_form_" + (j+1) + "_lastName").attr('id', 'contact_form_' + j + '_lastName');
                $("#contact_form_" + j + "_lastName").attr('name', 'contact_form_' + j + '_lastName');
                $("#contact_form_" + j + "_lastName").val(lastName);
                email = $("#contact_form_" + (j+1) + "_email").val();
                $("#contact_form_" + (j+1) + "_email").attr('id', 'contact_form_' + j + '_email');
                $("#contact_form_" + j + "_email").attr('name', 'contact_form_' + j + '_email');
                $("#contact_form_" + j + "_email").val(email);
                category = $("#contact_form_" + (j+1) + "_category").val();
                $("#contact_form_" + (j+1) + "_category").attr('id', 'contact_form_' + j + '_category');
                $("#contact_form_" + j + "_category").attr('name', 'contact_form_' + j + '_category');
                $("#contact_form_" + j + "_category").val(category);
                designation = $("#contact_form_" + (j+1) + "_designation").val();
                $("#contact_form_" + (j+1) + "_designation").attr('id', 'contact_form_' + j + '_designation');
                $("#contact_form_" + j + "_designation").attr('name', 'contact_form_' + j + '_designation');
                $("#contact_form_" + j + "_designation").val(designation);
                mobile = $("#contact_form_" + (j+1) + "_mobile").val();
                $("#contact_form_" + (j+1) + "_mobile").attr('id', 'contact_form_' + j + '_mobile');
                $("#contact_form_" + j + "_mobile").attr('name', 'contact_form_' + j + '_mobile');
                $("#contact_form_" + j + "_mobile").val(mobile);
                country = $("#contact_form_" + (j+1) + "_country").val();
                $("#contact_form_" + (j+1) + "_country").attr('id', 'contact_form_' + j + '_country');
                $("#contact_form_" + j + "_country").attr('name', 'contact_form_' + j + '_country');
                $("#contact_form_" + j + "_country").val(country);
                state = $("#contact_form_" + (j+1) + "_state").val();
                $("#contact_form_" + (j+1) + "_state").attr('id', 'contact_form_' + j + '_state');
                $("#contact_form_" + j + "_state").attr('name', 'contact_form_' + j + '_state');
                $("#contact_form_" + j + "_state").val(state);
                city = $("#contact_form_" + (j+1) + "_city").val();
                $("#contact_form_" + (j+1) + "_city").attr('id', 'contact_form_' + j + '_city');
                $("#contact_form_" + j + "_city").attr('name', 'contact_form_' + j + '_city');
                $("#contact_form_" + j + "_city").val(city);
                linkedin = $("#contact_form_" + (j+1) + "_linkedin").val();
                $("#contact_form_" + (j+1) + "_linkedin").attr('id', 'contact_form_' + j + '_linkedin');
                $("#contact_form_" + j + "_linkedin").attr('name', 'contact_form_' + j + '_linkedin');
                $("#contact_form_" + j + "_linkedin").val(linkedin);
                facebook = $("#contact_form_" + (j+1) + "_facebook").val();
                $("#contact_form_" + (j+1) + "_facebook").attr('id', 'contact_form_' + j + '_facebook');
                $("#contact_form_" + j + "_facebook").attr('name', 'contact_form_' + j + '_facebook');
                $("#contact_form_" + j + "_facebook").val(facebook);
                twitter = $("#contact_form_" + (j+1) + "_twitter").val();
                $("#contact_form_" + (j+1) + "_twitter").attr('id', 'contact_form_' + j + '_twitter');
                $("#contact_form_" + j + "_twitter").attr('name', 'contact_form_' + j + '_twitter');
                $("#contact_form_" + j + "_twitter").val(twitter);
                address = $("#contact_form_" + (j+1) + "_address").val();
                $("#contact_form_" + (j+1) + "_address").attr('id', 'contact_form_' + j + '_address');
                $("#contact_form_" + j + "_address").attr('name', 'contact_form_' + j + '_address');
                $("#contact_form_" + j + "_address").val(address);
            }
        }  

        /**
         * Load AJAX data
         */

        $(document).ready(function() {
            loadAllBdms();
            $("#assignToBdm").change(function() {
                var bdmEmpId = $("#assignToBdm").val();
                if(bdmEmpId == "" || bdmEmpId == null || bdmEmpId == undefined) {
                    var optionsBuilder = "<option value=''>Select BDE</option>";
                    $("#assignToBde").html(optionsBuilder);
                    return;
                }
                loadBdesForBdm(bdmEmpId);
            });
            $("#contact-country-div select").change(function() {
                var stateOptionsBuilder = "<option value=''>Select State</option>";
                var cityOptionsBuilder = "<option value=''>Select City</option>";
                if($("#contact-country-div select").val() !== "") {    
                    loadStatesForCountry($("#contact-country-div select").val());
                    $("#contact-city-div select").html(cityOptionsBuilder);
                    return;
                }
                $("#contact-state-div select").html(stateOptionsBuilder);
                $("#contact-city-div select").html(cityOptionsBuilder);
                    
            });
            $("#contact-state-div select").change(function() {
                var cityOptionsBuilder = "<option value=''>Select City</option>";
                if($("#contact-state-div select").val() !== "") {
                    loadCitiesForState($("#contact-state-div select").val());
                    return;
                }
                $("#contact-city-div select").html(cityOptionsBuilder);
                    
            });
        });
        
        function loadBdesForBdm(bdmEmpId) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchbdelistallforbdm.php",
                data: {
                    bdmEmpId: bdmEmpId
                },
                success: function(response) {
                    var optionsBuilder = "<option value=''>Select BDE</option>";
                    for(var i=0; i<response.length; i++) {
                        optionsBuilder += "<option value='" + response[i].empId + "'>";
                        optionsBuilder += response[i].name;
                        optionsBuilder += "</option>";
                    }
                    $("#assignToBde").html(optionsBuilder);
                }
            });
        }

        function loadAllBdms() {
            $.ajax({
                type: "GET",
                url: "<?php echo BASEURL ?>actions/admin/performfetchbdmlistall.php",
                success: function(response) {
                    var optionsBuilder = "<option value=''>Select BDM</option>";
                    for(var i=0; i<response.length; i++) {
                        optionsBuilder += "<option value='" + response[i].empId + "'>";
                        optionsBuilder += response[i].name;
                        optionsBuilder += "</option>";
                    }
                    $("#assignToBdm").html(optionsBuilder);
                }
            });
        }

        function loadCountriesIntoContactForm() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                data: {
                    locationType: "country"
                },
                success: function(response) {
                    if(response.length == 0) {
                        return;
                    }
                    var optionsBuilder = "<option value=''>Select Country</option>";
                    for(var i=0; i<response.length; i++) {
                        optionsBuilder += "<option value='" + response[i].id + "'>";
                        optionsBuilder += response[i].name;
                        optionsBuilder += "</option>";
                    }
                    $("#contact-country-div select").html(optionsBuilder);
                }
            });
        }
        
        function loadStatesForCountry(countryId) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                data: {
                    locationType: "state",
                    countryId: countryId
                },
                success: function(response) {
                    var optionsBuilder = "<option value=''>Select State</option>";
                    if(response.length == 0) {
                        $("#contact-state-div select").html(optionsBuilder);
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        optionsBuilder += "<option value='" + response[i].id + "'>";
                        optionsBuilder += response[i].name;
                        optionsBuilder += "</option>";
                    }
                    $("#contact-state-div select").html(optionsBuilder);
                }
            });
        }

        function loadCitiesForState(stateId) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                data: {
                    locationType: "city",
                    stateId: stateId
                },
                success: function(response) {
                    var optionsBuilder = "<option value=''>Select City</option>";
                    if(response.length == 0) {
                        $("#contact-city-div select").html(optionsBuilder);
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        optionsBuilder += "<option value='" + response[i].id + "'>";
                        optionsBuilder += response[i].name;
                        optionsBuilder += "</option>";
                    }
                    $("#contact-city-div select").html(optionsBuilder);
                }
            });
        }

    </script>
</body>
</html>