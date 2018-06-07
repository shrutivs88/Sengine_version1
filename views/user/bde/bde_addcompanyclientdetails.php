<?php

session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');

if(!isset($_SESSION["email"])) {

    header("Location:login.php");

}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');

$data = new DatabaseManager();

$conn = $data->getconnection();



$companyId = $_GET['companyId'];

//$comapnyName = $_GET['companyName'];



$companyNameSql = "select client_company_name from client_companies where client_company_id='$companyId' ";

$result = mysqli_query($conn,$companyNameSql);

while($row = mysqli_fetch_object($result)){

  // var_dump($row);

   //die;

    $client_company_name  = $row->client_company_name;

}

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

    <script src="<?php echo BASEURL; ?>assets/js/bde/addCompanyClientDetailsValidation.js"></script>

    <style>

    .imp{

        vertical-align: super;

        font-size: 7px;

        color:red;

    }

    </style>

    <script>

    var countries = [];

    var states = [];

    var cities = [];



        function saveContactForm() {

            if(validateContactFields()) {

                //console.log($("#addContactForm").attr('href'));

                $("#addContactForm").submit();

            }

        }



      



function validateContactFields() {

            validateClientFirstName();

            validateClientLastName();

            validateClientEmail();

            validateClientMobile();

            validateClientCategoty();

            validateClientDesignation();

            validateClientCity();

            validateClientState();

            validateClientCountry();

            validateClientAddress();

            validateClientLinkedIn();

            validateClientFacebookId();

            validateClientTwitterId();



            if((clientFirstNameErrorFlag == false)&&(clientLastNameErrorFlag==false)&&(clientEmailErrorFlag==false)&&

            (clientMobileErrorFlag==false)&&(clientCategoryErrorFlag==false)&&(clientDesignationErrorFlag==false)&&(clientCityErrorFlag==false)&&

            (clientStateErrorFlag==false)&&(clientCountryErrorFlag==false)&&(clientAddressErrorFlag==false)) {

                                return true;

                            }

                            return false;          

        }

       

        $(document).ready(function() {

            loadCountriesJsonAndSetCountry();



            $("#clientCountry").change(function() {

                var countryId = $("#clientCountry").val();

                $("#clientState").html("<option value=''>Select State</option>");

                if($("#clientCountry").val() != "") {

                    loadStatesByCountryIdJson(countryId);

                }

                $("#clientCity").html("<option value=''>Select City</option>");

            });



        $("#clientState").change(function() {

            $("#clientCity").html("<option value=''>Select City</option>");

            if($("#clientState").val() != "") {

                loadCitiesByStateIdJson($("#clientState").val());

            }

        });



    });  

        

    function loadStatesByCountryIdJson(countryId){

        $.ajax({

            type: "post",

            url: "<?php echo BASEURL;?>actions/bde/locationDetails.php",

            data: {

                country_id:countryId,

                locationType: "state-all-by-country-id"

            },

            success: function(response) {

                states = response;

                var optionsStates = "<option value=''>Select State</option>";

                        for(var j=0; j<response.length; j++) {

                            optionsStates += "<option value='" + response[j].state_id + "'>";

                            optionsStates += response[j].state_name;

                            optionsStates += "</option>";

                        }

                        $("#clientState").html(optionsStates);

            }

        });

    }

    

    function loadCitiesByStateIdJson(stateId) {

        $.ajax({

            type: "post",

            url: "<?php echo BASEURL;?>actions/bde/locationDetails.php",

            data: {

                state_id: stateId,

                locationType: "city-all-by-state-id"

            },

            success: function(response) {

                cities = response;

                var optionsCities = "<option value=''>Select City</option>";

                        for(var i=0; i<response.length; i++) {

                            optionsCities += "<option value='" + response[i].city_id + "'>";

                            optionsCities += response[i].city_name;

                            optionsCities += "</option>";

                        }

                        $("#clientCity").html(optionsCities);

            }

        });

    }

        

    function loadCountriesJsonAndSetCountry() {

        $.ajax({

            type: "post",

            url: "<?php echo BASEURL;?>actions/bde/locationDetails.php",

            data: {

                locationType:"country-all"

            },

            success: function(response) {

                countries = response;

                var optionsCountry = "<option value=''>Select Country</option>";

                        for(var i=0; i<response.data.length; i++) {

                            optionsCountry += "<option value='" + response.data[i].country_id + "'>";

                            optionsCountry += response.data[i].country_name;

                            optionsCountry += "</option>";

                        }

                        $("#clientCountry").html(optionsCountry);

            }

        });

    }



    function resetLocations() {

        var optionsCountry = "<option value=''>Select Country</option>";

        for(var i=0; i<countries.data.length; i++) {

            optionsCountry += "<option value='" + countries.data[i].country_id + "'>";

            optionsCountry += countries.data[i].country_name;

            optionsCountry += "</option>";

        }

        $("#clientCountry").html(optionsCountry);



    }



    var limit=3;

    var addanotherbtn=2;

    function addAnotherEmail() 

    {

            if(addanotherbtn <= limit) 

            {

                $('#emailbtn').append("<br><input type='text' class='form-control' placeholder='Enter Your email-id'+addanotherbtn+'   form='form1' onfocusout='validateClientEmail"+ addanotherbtn +"()'  id='clientEmail"+ addanotherbtn +"' name='clientEmail" + addanotherbtn + "'><i style='color:red' id='clientEmailError"+ addanotherbtn +"'></i>");

                if(addanotherbtn === limit)

                $('#add-another-email-btn').hide();   

                 addanotherbtn++;

                  return;

            }     

    }    



</script>

</head>

<body>

<?php include 'navbar.php';?>

    <div class="content-view">

        <div class="container-fluid">

        <a href="bde_companyclientlist.php"><button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-chevron-left"></span>Go Back </button></a>

            <div class="row">

                <div class="col-sm-1"></div>

                <div class="col-sm-10">

                    <h2 class="text-center list-heading" id="client-company-heading">Add Client For " <?php echo $client_company_name; ?>"</h2>

                      <br>

                      <?php

                            if(isset($_SESSION["serverMsg"])){

                                echo $_SESSION["serverMsg"];

                                unset($_SESSION["serverMsg"]);

                            }

                       ?>

             <h5 class="text-center">Fields marked with a <span class="glyphicon glyphicon-asterisk imp"></span> are required</h5>           

                    <div class="row">

                        <div class="col-md-offset-1 col-sm-11">

                            <form id="addContactForm" class="form-horizontal" action="<?php echo BASEURL;?>actions/bde/performaddclientcontact.php?companyId=<?php echo $companyId ?>" method="post">

                               <br> <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-first-name-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">First Name:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <input name="clientFirstName" id="clientFirstName" type="text" placeholder="Enter First Name" class="form-control" onfocusout="validateClientFirstName()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-last-name-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Last Name:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <input name="clientLastName" id="clientLastName" type="text" placeholder="Enter Last Name" class="form-control" onfocusout="validateClientLastName()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-email-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">E-Mail:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <input name="clientEmail" id="clientEmail" type="text" placeholder="Enter Primary Email Id" class="form-control" onfocusout="validateClientEmails1()">

                                                <p></p>

                                            </div>                                             

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-email-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">E-Mail 2:</label>

                                            <div class="col-sm-9">

                                                <input name="clientEmail2" id="clientEmail2" type="text" placeholder="Enter Secondary Email Id" class="form-control" onfocusout="validateClientEmails2()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-email-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">E-Mail 3:</span></label>

                                            <div class="col-sm-9" id="emailbtn">

                                                <input name="clientEmail3" id="clientEmail3" type="text" placeholder="Enter third Email Id" class="form-control" onfocusout="validateClientEmails3()">

                                                <p></p>

                                            </div>                                             

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-category-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Category:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <input name="clientCategory" id="clientCategory" type="text" placeholder="Enter Category" class="form-control" onfocusout="validateClientCategoty()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-designation-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Designation:<span class="glyphicon glyphicon-asterisk imp"></span></label>
                                            <div class="col-sm-9">

                                                <input name="clientDesignation" id="clientDesignation" type="text" placeholder="Enter Designation" class="form-control" onfocusout="validateClientDesignation()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-mobile-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Mobile:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <input name="clientMobile" id="clientMobile" type="text" placeholder="Enter Mobile" class="form-control" onfocusout="validateClientMobile()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-country-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Country:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <select name="clientCountry" id="clientCountry" class="form-control" onfocusout="validateClientCountry()">

                                                    <option value="">Select Country</option>

                                                </select>

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-state-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">State:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <select name="clientState" id="clientState" class="form-control" onfocusout="validateClientState()">

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

                                            <label class="control-label col-sm-3">City:<span class="glyphicon glyphicon-asterisk imp"></span></label>

                                            <div class="col-sm-9">

                                                <select name="clientCity" id="clientCity" class="form-control" onfocusout="validateClientCity()">

                                                    <option value="">Select City</option>

                                                </select>

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-linkedin-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">LinkedIn:</label>

                                            <div class="col-sm-9">

                                                <input name="clientLinkedInId" id="clientLinkedInid" type="text" placeholder="Enter LinkedIn" class="form-control" onfocusout="validateClientLinkedIn()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-facebook-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Facebook:</label>

                                            <div class="col-sm-9">

                                                <input name="clientFacebookId" id="clientFacebookid" type="text" placeholder="Enter Facebook" class="form-control" onfocusout="validateClientFacebookId()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div id="contact-twitter-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Twitter:</label>

                                            <div class="col-sm-9">

                                                <input name="clientTwitterId" id="clientTwitterid" type="text" placeholder="Enter Twitter" class="form-control" onfocusout="validateClientTwitterId()">

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6">

                                        <div id="contact-address-div" class="form-group form-group-mod">

                                            <label class="control-label col-sm-3">Address:<span class="glyphicon glyphicon-asterisk imp"></label>

                                            <div class="col-sm-9">

                                                <textarea name="clientAddress" id="clientAddress" placeholder="Enter Address" class="form-control" style="resize: none;" onfocusout="validateClientAddress()"></textarea>

                                                <p></p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-6">



                                    </div>

                                </div>

                                <input type="hidden" name="companyId" value="<?php echo $companyId; ?>">

                                <input type="hidden" name="companyName" value="<?php echo $client_company_name; ?>">

                                <div class="row text-center form-group-mod">

                                    <button id="contactSuccessBtn" type="button" class="btn btn-primary form-btn btn-identical-dimension" onclick="saveContactForm()">Save</button>

                                    <button id="contactFailBtn" type="button" class="btn btn-danger form-btn btn-identical-dimension" onclick="addContactFormReset()">Reset</button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <div class="col-sm-1"></div>

            </div>

        </div>

    </div>

<?php include 'footer.php';?>







</body>

</html>