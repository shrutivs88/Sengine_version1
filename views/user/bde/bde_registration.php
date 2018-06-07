<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
if(!isset($_SESSION["email"])) {
    header("Location:login.php");
}
$userId = $_SESSION["userId"];
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
    <script src="<?php echo BASEURL; ?>assets/js/bde/validation.js"></script>
    <style>
    .imp{
        vertical-align: super;
        font-size: 7px;
        color:red;
        }
    .modal-header{
        background-color:skyblue;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php';?>
<div class="content-view">
    <div class="container-fluid">
        <!-- BDE Access Only -->
            <?php if ($_SESSION['role'] == "BDE") : ?>
                <div id="bde-container">
                    <h2 class="text-center"> Add Client</h2>
                    <h5 class="text-center">Fields marked with a <span class="glyphicon glyphicon-asterisk imp"></span> are required</h5><br>
                        <?php
                            if(isset($_SESSION["server-msg"])){
                            echo $_SESSION["server-msg"];    
                            unset($_SESSION["server-msg"]);
                            }
                         ?>
                    <form action="#" id="form1">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Company Name: <span class="glyphicon glyphicon-asterisk imp"></span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input id="companyName" name="companyName" type="text" class="form-control" placeholder="Enter Company Name" onfocusout="validateCompanyName()">
                                        <i style="color:red" id="companyNameError" ></i>
                                    </div>
                                </div><!-- row end -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Company Website: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input id="companyWebsite" name="companyWebsite" type="text" class="form-control" placeholder="Enter Website URL" onfocusout="validateCompanyWebsite()">
                                        <i style="color:red" id="companyWebsiteError"></i>
                                    </div>
                                </div><!-- row end -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Company Email id: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input id="companyEmail" name="companyEmail" class="form-control" type="text" placeholder="Enter Company email-id"  onfocusout="validateCompanyEmail()">
                                        <i style="color:red" id="companyEmailError"></i>
                                    </div>
                                </div><!-- row end -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Company Phone: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input id="companyPhone" name="companyPhone" type="text" class="form-control" placeholder="Enter Company phone number" onfocusout="validateCompanyPhone()">
                                        <i style="color:red" id="companyPhoneError"></i>
                                    </div>
                                </div><!-- row end -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Company LinkedIN Id: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input id="companyLinkedIn" name="companyLinkedIn" type="text" class="form-control" placeholder="Company linked in id" onfocusout="validateCompanyLinkedIn()">
                                        <i style="color:red" id="companyLinkedInError"></i>
                                    </div>
                                </div><!-- row end -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Company Address: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea  id="companyAddress" name="companyAddress" class="form-control" placeholder="Enter Comapny address here" onfocusout="validateCompanyAddress()"></textarea>
                                        <i style="color:red" id="companyAddressError"></i>
                                    </div>
                                </div><!-- row end -->
                            </div>
                    </form>       
                </div><!--container end-->
                        <div class="col-sm-6 col-sm-offset-3">
                            <button type="button" class="btn btn-primary" onclick="addcontact()" data-toggle="modal" data-target="#exampleModal" id="myBtn">
                                Add a Contact </button>
                            <p id="total-clients"></p> 
                                <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetContacts()"><span aria-hidden="true">&times;</span></button>
                                        <div class="modal-header">      
                                            <h2 class="modal-title text-center"  id="exampleModalLabel">Client Details</h2>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="text-center">Fields marked with a <span class="glyphicon glyphicon-asterisk imp"></span> are required</h5>         
                                            <!-- input field start here -->
                                                <br>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>First Name: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input id="clientFirstName" name="clientFirstName" type="text" class="form-control" placeholder="Enter Your First Name"   form="form1" onfocusout="validateClientFirstName()">
                                                            <i style="color:red" id="clientFirstNameError"></i>                                
                                                        </div>
                                                    </div><!-- row end -->
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Last Name: <span class="glyphicon glyphicon-asterisk imp"></span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input id="clientLastName" name="clientLastName" type="text" class="form-control" placeholder="Enter Your Last Name"    form="form1" onfocusout="validateClientLastName()">
                                                            <i style="color:red" id="clientLastNameError"></i>                               
                                                        </div>
                                                    </div><!-- row end -->
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Email id: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                        </div>
                                                        <div class="col-sm-8" >
                                                            <div class="form-group" id="emailBtn">
                                                                <input id="clientEmail" name="clientEmail" type="text" class="form-control email-append-input" placeholder="Enter Your email-id" form="form1" onfocusout="validateClientEmail()"> 
                                                                <i style="color:red" id="clientEmailError"></i>
                                                            </div> 
                                                            <button id="add-another-email-btn" type="button" onclick="addAnotherEmail()">Add Another Email</button> 
                                                        </div>
                                                    </div>
                                                </div><!-- row end -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label>Mobile No.: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input id="clientMobile" name="clientMobile" type="text" class="form-control" placeholder="Enter Your contact number "    form="form1" onfocusout="validateClientMobile()">
                                                        <i style="color:red" id="clientMobileError"></i>
                                                    </div>
                                                </div><!-- row end -->
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label>Category: <span class="glyphicon glyphicon-asterisk imp"></span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input  id="clientCategory" name="clientCategory" placeholder="Enter your category"  class="form-control"  onfocusout="validateClientCategoty()">
                                                        <i style="color:red" id="clientCategoryError"></i>
                                                    </div>
                                                </div><!-- row end -->
                                            </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Designation: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input  id="clientDesignation" name="clientDesignation" placeholder="Enter your designation" class="form-control" onfocusout="validateClientDesignation()">
                                                    <i style="color:red" id="clientDesignationError"></i>
                                                </div>
                                            </div><!-- row end -->
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Address: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" placeholder="Enter your address here" name="clientAddress" id="clientAddress" form="form1" onfocusout="validateClientAddress()"></textarea>
                                                    <i style="color:red" id="clientAddressError"></i>
                                                </div>
                                            </div><!-- row end -->
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Country: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select id="clientCountry" name="clientCountry"  class="form-control"  onfocusout="validateClientCountry()">
                                                        <option value="">Select Country</option>
                                                    </select>
                                                    <i style="color:red" id="clientCountryError"></i>
                                                </div>
                                            </div><!-- row end -->
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>State: <span class="glyphicon glyphicon-asterisk imp"></span> </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select  id="clientState" name="clientState"  class="form-control" onfocusout="validateClientState()">
                                                        <option value="">Select State</option>
                                                    </select>
                                                    <i style="color:red" id="clientStateError"></i>
                                                </div>
                                            </div><!-- row end -->
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>City: <span class="glyphicon glyphicon-asterisk imp"></span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select id="clientCity" name="clientCity"  class="form-control" onfocusout="validateClientCity()">
                                                        <option value="">Select City</option>
                                                    </select>
                                                    <i style="color:red" id="clientCityError"></i>
                                                </div>
                                            </div><!-- row end --> 
                                        </div> 
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>LinkedIn Id: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input  id="clientLinkedInid"  name="clientLinkedInid" type="text"  class="form-control" placeholder="Please Provide Linkedin id"    form="form1" onfocusout="validateClientLinkedIn()">
                                                    <i style="color:red" id="clientLinkedInError"></i>
                                                </div>
                                            </div><!-- row end -->  
                                        </div>          
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Facebook Id: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input id="clientFacebookid" name="clientFacebookid" type="text" class="form-control" placeholder="Please Provide facebook id"    form="form1"  onfocusout="validateClientFacebookId()">
                                                    <i style="color:red" id="clientFacebookIdError"></i>
                                                </div>
                                            </div><!-- row end -->
                                        </div>    
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Twitter Id: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input id="clientTwitterid" name="clientTwitterid" type="text"  class="form-control" placeholder="Please Provide twitter id"    form="form1" onfocusout="validateClientTwitterId()">
                                                    <i style="color:red" id="clientTwitterIdError"></i>
                                                </div>
                                            </div><!-- row end -->
                                        </div>
                                        <div class="form-group">
                                            <div class="row text-center">
                                                <input type="button" value="SaveContact"  id="saveClient" class="btn btn-success"  onClick="saveClient()">
                                                <input  type="button" value="Reset"  class="btn btn-danger" onclick="resetInputField()">  
                                            </div><!-- row end -->
                                        </div>
                                    </div> <!-- input field end here -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row text-center">
                            <button type="button" onclick="submitForm1()" id="submitbtn" class="btn btn-success" value="submit" form="form1">Submit</button>
                            <button type="reset" onclick="resetForm1InputField()" id="resetbtn" class="btn btn-danger" value="reset" form="form1">Clear</button>
                        </div>
                    </div><!-- row end -->
            </div> 
        </div>
        <?php endif; ?>
    </div> 
</div>
    <?php include 'footer.php';?>
<script>
    function submitForm1() 
        {
        
            validateCompanyName();
            validateCompanyWebsite();
            validateCompanyEmail();
            validateCompanyPhone();
            validateCompanyLinkedIn();
            validateCompanyAddress();

            if((companyNameErrorFlag == false) && (companyWebsiteErrorFlag == false) && 
                (companyEmailErrorFlag == false) && (companyPhoneErrorFlag == false) && 
                    (companyLinkedInErrorFlag == false) && (companyAddressErrorFlag == false))
                        {    
                        $.ajax({
                            data: {
                                userId: <?php echo $userId; ?>,
                                companyName: "" + $("#companyName").val(),
                                companyWebsite: "" + $("#companyWebsite").val(),
                                companyEmail: "" + $("#companyEmail").val(),
                                companyPhone : "" + $("#companyPhone").val(),
                                companyLinkedIn: "" + $("#companyLinkedIn").val(),
                                companyAddress: "" + $("#companyAddress").val(),
                                clientDetails: clients
                                  },
                            url: '<?php echo BASEURL; ?>actions/bde/performaddclientcompany.php',
                            method: 'POST', 
                            success: function(response) {
                                console.log(response);
                              window.location.href="bde_clientlist.php";
                                }
                            });
                         
                        }
        }
    var countries = [];
    var states = [];
    var cities = [];
    $(document).ready(function() {
        preInitilizeLocationChainingEffectBeginByInitCountry();
        $("#clientCountry").change(function() {
            var countryId = $("#clientCountry").val();
            $("#clientState").html("<option value=''>Select State</option>");
            $("#clientCity").html("<option value=''>Select City</option>");
            if($("#clientCountry").val() != "") {
                loadStatesByCountryIdFromStatesArray(countryId);
            }
        });
        $("#clientState").change(function() {
            var stateId = $("#clientState").val();
            $("#clientCity").html("<option value=''>Select City</option>");
            if($("#clientState").val() != "") {
                loadCitiesByStateIdFromCitiesArray(stateId);
            }
        });
    });
    function preInitilizeLocationChainingEffectBeginByInitCountry() {
        /**Loading all countries */
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL ?>actions/bde/locationDetails.php",
            data: {
                locationType:"country-all"
            },
            success: function(response) {
                countries = response.data;
                initStatesChainingEffect();
            }
        });
    }
    function initStatesChainingEffect() {
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL ?>actions/bde/locationDetails.php",
            data: {
                locationType:"state-all"
            },
            success: function(response) {
                states = response.data;
                initCitiesChainingEffect();
            }
        });
    }
    function initCitiesChainingEffect() {
          $.ajax({
            type: "post",
            url: "<?php echo BASEURL ?>actions/bde/locationDetails.php",
            data: {
                locationType:"city-all"
            },
            success: function(response) {
                cities = response.data;
            }
        });
    }
    function addcontact(){
        addanotherbtn=2;
        var modalCountryBuilder = "<option value=''>Select Country</option>";
        jQuery.each(countries, function( index, value ) {
            modalCountryBuilder += "<option value='" + value.country_id + "'>" + value.country_name + "</option>";
        });
        $("#clientCountry").html(modalCountryBuilder);

    }



    function loadStatesByCountryIdFromStatesArray(countryId) {

        var modalStateBuilder = "<option value=''>Select State</option>";

        jQuery.each(states, function( index, value ) {

            if(value.country_id == countryId) {

                modalStateBuilder += "<option value='" + value.state_id + "'>" + value.state_name + "</option>";

            }

        });

        $("#clientState").html(modalStateBuilder);

    }



    function loadCitiesByStateIdFromCitiesArray(stateId) {

        var modalCityBuilder = "<option value=''>Select City</option>";

        jQuery.each(cities, function( index, value ) {

            if(value.state_id == stateId) {

                modalCityBuilder += "<option value='" + value.city_id + "'>" + value.city_name + "</option>";

            }

        });

        $("#clientCity").html(modalCityBuilder);

    }



   var limit=3;

    var addanotherbtn=2;

    function addAnotherEmail() 

    {

            if(addanotherbtn <= limit) 

            {

                $('#emailBtn').append("<input type='text' class='form-control email-append-input' placeholder='Enter Your email-id'   form='form1' onfocusout='validateClientEmail"+ addanotherbtn +"()'  id='clientEmail"+ addanotherbtn +"' name='clientEmail" + addanotherbtn + "'><i style='color:red' id='clientEmailError"+ addanotherbtn +"'></i>");

                if(addanotherbtn === limit)

                $('#add-another-email-btn').hide();   

                 addanotherbtn++;

                  return;

            }     

    }    

  function resetForm1InputField()

  {

            $("#companyName").text("");

            $("#companyName").val("");

            $("#companyName").css({"border-color":"#ccc"});
           
            $("#companyNameError").text("");



            $("#companyWebsite").text("");

            $("#companyWebsite").val("");

            $("#companyWebsite").css({"border-color":"#ccc"});

            $("#companyWebsiteError").text("");


            $("#companyEmail").text("");

            $("#companyEmail").val("");

            $("#companyEmail").css({"border-color":"#ccc"});

            $("#companyEmailError").text("");



            $("#companyPhone").text("");

            $("#companyPhone").val("");

            $("#companyPhone").css({"border-color":"#ccc"});

            $("#companyPhoneError").text("");



            $("#companyLinkedIn").text("");

            $("#companyLinkedIn").val("");

            $("#companyLinkedIn").css({"border-color":"#ccc"});

            $("#companyLinkedInError").text("");



            $("#companyAddress").text("");

            $("#companyAddress").val("");

            $("#companyAddress").css({"border-color":"#ccc"});

            $("#companyAddressError").text("");


  }  

  function resetContacts(){

            $("#clientFirstName").text("");

            $("#clientFirstName").val("");

            $("#clientFirstName").css({"border-color":"#ccc"});

            $("#clientFirstNameError").text("");





            $("#clientLastName").text("");

            $("#clientLastName").val("");

            $("#clientLastName").css({"border-color":"#ccc"});

            $("#clientLastNameError").text("");



            //first email id reset

            $("#clientEmail").text("");

            $("#clientEmail").val("");

            $("#clientEmail").css({"border-color":"#ccc"});

            $("#clientEmailError").text("");



            //second email id reset

            $("#clientEmail2").text("");

            $("#clientEmail2").val("");

            $("#clientEmail2").css({"border-color":"#ccc"});

            $("#clientEmailError").text("");



            //third email id reset

            $("#clientEmail3").text("");

            $("#clientEmail3").val("");

            $("#clientEmail3").css({"border-color":"#ccc"});

            $("#clientEmailError").text("");



            $("#clientMobile").text("");

            $("#clientMobile").val("");

            $("#clientMobile").css({"border-color":"#ccc"});

            $("#clientMobileError").text("");



            $("#clientCategory").text("");

            $("#clientCategory").val("");

            $("#clientCategory").css({"border-color":"#ccc"});

            $("#clientCategoryError").text("");



            $("#clientDesignation").text("");

            $("#clientDesignation").val("");

            $("#clientDesignation").css({"border-color":"#ccc"});

            $("#clientDesignationError").text("");


            $("#clientAddress").text("");

            $("#clientAddress").val("");

            $("#clientAddress").css({"border-color":"#ccc"});

            $("#clientAddressError").text("");
            
            
            $("#clientCountry").text("");

            $("#clientCountry").val("");

            $("#clientCountry").css({"border-color":"#ccc"});

            $("#clientCountryError").text("");
            
            
            $("#clientState").text("");

            $("#clientState").val("");

            $("#clientState").css({"border-color":"#ccc"});

            $("#clientStateError").text("");
            
            
            $("#clientCity").text("");

            $("#clientCity").val("");

            $("#clientCity").css({"border-color":"#ccc"});

            $("#clientCityError").text("");
            
            
            


            $("#clientLinkedInid").text("");

            $("#clientLinkedInid").val("");

            $("#clientLinkedInid").css({"border-color":"#ccc"});

          

            

            $("#clientFacebookid").text("");

            $("#clientFacebookid").val("");

            $("#clientFacebookid").css({"border-color":"#ccc"});

           



            

            $("#clientTwitterid").text("");

            $("#clientTwitterid").val("");

            $("#clientTwitterid").css({"border-color":"#ccc"});

           



          $('#clientEmail2').remove();

            $('#clientEmail3').remove();

          $("#clientEmailError2").text("");

          $("#clientEmailError3").text("");

          $('#add-another-email-btn').show();

          

      }

   

    </script>

</body>

</html>