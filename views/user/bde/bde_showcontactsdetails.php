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
    <script src="<?php echo BASEURL; ?>assets/js/bde/validation.js"></script>
    <style>
        .input-error{color:red;}
    </style>
    <script>
        var responseData = [];
        var countries=[];
        var states=[];
        var cities=[];
        var count =0;
        var offset = 0;
        var limit = 4;
        var noBde = true;
        var bdeListBuilder = "";

    $(document).ready(function() {
        count++
        preInitilizeLocationChainingEffectBeginByInitCountry();
        initStatesChainingEffect();
        initCitiesChainingEffect();
        $.ajax({
            type: "Post",
            url: "bde_showcontacts.php",
            data: {
                companyId:<?php echo $_GET["companyId"] ?>
            },
            success:function(response) {
                
                jQuery.each( response, function( index, value ) {
                responseData.push(jQuery.extend(true, {}, value));
            });  
               if(response.length == 0 && noBde == true) {
                $("#bde-list").html("<h4 class='text-center'>No Clients Are Available!</h4>");
                $("#ajaxButton").hide();
                return;
            } else if(response.length == 0 && noBde == false) {
                $("#bde-list").append("<h4 class='text-center'>No More Clients Are Available!</h4>");
                $("#ajaxButton").hide();
                return;
            }
            var bdeListBuilder = "";
            if(response.length == 0) {
                $("#bde-list").html("<h4 class='text-center'>No Client Are Available!</h4>");
                return;
            }
                for(var i=0; i<response.length; i++) { 
                        //var bdeListBuilder = "";
                        bdeListBuilder += "<tr>";
                        bdeListBuilder += "<td>"+ parseInt(count+i) +"</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_first_name + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_last_name + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_email + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_mobile + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_category + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_designation + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_address + "</td>";
                        var isCountrySet = false;
                        jQuery.each( countries, function( index, value ) {
                        if(value.country_id == response[i].country_id) {
                        bdeListBuilder += "<td>" + value.country_name + "</td>";
                        isCountrySet = true;
                        return;
                            }
                        });
                        if(!isCountrySet) {
                        bdeListBuilder += "<td>-</td>";
                        }
                        var isStateSet = false;
                        jQuery.each( states, function( index, value ) {
                        if(value.state_id == response[i].state_id) {
                        bdeListBuilder += "<td>" + value.state_name + "</td>";
                        isStateSet = true;
                        return;
                            }
                        });
                        if(!isStateSet) {
                        bdeListBuilder += "<td>-</td>";
                        }
                        var isCitySet = false;
                        jQuery.each( cities, function( index, value ) {
                        if(value.city_id == response[i].city_id) {
                        bdeListBuilder += "<td>" + value.city_name + "</td>";
                        isCitySet = true;
                        return;
                            }
                        });
                        if(!isCitySet) {
                        bdeListBuilder += "<td>-</td>";
                        }
                        bdeListBuilder += "<td>" + response[i].client_contact_linkedin + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_facebook + "</td>";
                        bdeListBuilder += "<td>" + response[i].client_contact_twitter + "</td>";
                        bdeListBuilder += "<td><button class='btn btn-primary ' id='edit' title ='Edit Client' onclick='showEditClient(" + response[i].client_contact_id + ")'><span class='glyphicon glyphicon-edit'></span></button></td>";
                        bdeListBuilder += "</tr>";
                       
                    } 
                    $("#bde-list-table").append(bdeListBuilder);
                    offset += limit;
                    count = count+limit-1;
                }
            });
        });

          //fetching country , state , city
    function preInitilizeLocationChainingEffectBeginByInitCountry() {
        /**Loading all countries */
        $.ajax({
            type: "post",
            url: "locationDetails.php",
            data: {
                locationType:"country-all"
            },
            success: function(response) {
                countries = response.data;
                //initStatesChainingEffect();
            }
        });
    }

    function initStatesChainingEffect() {
        $.ajax({
            type: "post",
            url: "locationDetails.php",
            data: {
                locationType:"state-all"
            },
            success: function(response) {
                states = response.data;
                //initCitiesChainingEffect();
            }
        });
    }

    function initCitiesChainingEffect() {
        $.ajax({
            type: "post",
            url: "locationDetails.php",
            data: {
                locationType:"city-all"
            },
            success: function(response) {
                cities = response.data;
            }
        });
    }  

       
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };        

//TO EDIT CLIENT DETAILS FROM COMPANY LIST

    function showEditClient(clientId) {
        $("#myModal").modal();
        data = "";
        $.each(responseData, function( key, value ) {
           if(value.client_contact_id == clientId) {
               data = value;
               setModalFields(data);
                return;
             }
        });
    }

    function setModalFields(data) {
        $("#clientId").val(data.client_contact_id);
        $("#clientFirstName").val(data.client_contact_first_name);
        $("#clientLastName").val(data.client_contact_last_name);
        $("#clientEmail").val(data.client_contact_email);
        $("#clientMobile").val(data.client_contact_mobile);
        $("#clientCategory").val(data.client_contact_category);
        $("#clientDesignation").val(data.client_contact_designation);
        $("#clientAddress").val(data.client_contact_address);
        $("#clientLinkedInId").val(data.client_contact_linkedin);
        $("#clientFacebookId").val(data.client_contact_facebook);
        $("#clientTwitterId").val(data.client_contact_twitter);
        $("#clientCompanyId").val(data.client_company_id);
        $("#clientDateTime").val(data.client_contact_added);
        loadCountriesJsonAndSetCountry(data);
        
    }

    function loadCountriesJsonAndSetCountry(data) {
        $.ajax({
            type: "post",
            url: "locationDetails.php",
            data: {
                locationType:"country-all"
            },
            success: function(response) {
                var optionsCountry = "<option value=''>Select Country</option>";
                        for(var i=0; i<response.data.length; i++) {
                            optionsCountry += "<option value='" + response.data[i].country_id + "'>";
                            optionsCountry += response.data[i].country_name;
                            optionsCountry += "</option>";
                        }
                        $("#clientCountry").html(optionsCountry);
                        $("#clientCountry").val(data.country_id);
                        if(data.country_id== 0) {
                            $("#clientCountry").val("");
                        }
                        loadStatesJsonAndSetState(data);
            }
        });
    }

    function loadStatesJsonAndSetState(data) {
        $.ajax({
            type: "post",
            url: "locationDetails.php",
            data: {
                country_id: data.country_id,
                locationType: "state-all-by-country-id"
            },
            success: function(response) {
                var optionsStates = "<option value=''>Select State</option>";
                        for(var j=0; j<response.length; j++) {
                            optionsStates += "<option value='" + response[j].state_id + "'>";
                            optionsStates += response[j].state_name;
                            optionsStates += "</option>";
                        }
                        $("#clientState").html(optionsStates);
                        $("#clientState").val(data.state_id);
                        if(data.state_id== 0) {
                            $("#clientState").val("");
                        }
                        loadCitiesJsonAndSetCity(data);
            }
        });
    }

    function loadCitiesJsonAndSetCity(data) {
        $.ajax({
            type: "post",
            url: "locationDetails.php",
            data: {
                state_id: data.state_id,
                locationType: "city-all-by-state-id"
            },
            success: function(response) {
                var optionsCities = "<option value=''>Select City</option>";
                        for(var i=0; i<response.length; i++) {
                            optionsCities += "<option value='" + response[i].city_id + "'>";
                            optionsCities += response[i].city_name;
                            optionsCities += "</option>";
                        }
                        $("#clientCity").html(optionsCities);
                        $("#clientCity").val(data.city_id);
                        if(data.city_id == 0) {
                            $("#clientCity").val("");
                        }
            }
        });
    }


    /**
    Backend call to save data */
    function updateClient(clientId) {
        //check
        if(validateUpdateClient()) {
            $("#myModal").modal('toggle');
            $.ajax({
                type: "post",
                url: "bde_editclientcontact.php",
                data: {
                    clientId: $("#clientId").val(),
                    clientFirstName: $("#clientFirstName").val(),
                    clientLastName: $("#clientLastName").val(),
                    clientEmail: $("#clientEmail").val(),
                    clientMobile: $("#clientMobile").val(),
                    clientCategory: $("#clientCategory").val(),
                    clientDesignation: $("#clientDesignation").val(),
                    clientAddress: $("#clientAddress").val(),
                    clientCountry: $("#clientCountry").val(),
                    clientState: $("#clientState").val(),
                    clientCity: $("#clientCity").val(),
                    clientLinkedInId: $("#clientLinkedInId").val(),
                    clientFacebookId: $("#clientFacebookId").val(),
                    clientTwitterId: $("#clientTwitterId").val(),
                    clientCompanyId: $("#clientCompanyId").val()
                    //clientDateTime: $("#clientDateTime").val()
                
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }
        
    }
    </script>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
        
            <!-- BDE Access Only -->
            <?php if ($_SESSION['role'] == "BDE") : ?>
                <div id="bde-container">
                    <h2 class="text-center"> Contacts List of "<?php echo $client_company_name; ?>"</h2>
                         <!--here the contact list will start showing-->
                       <a href="bde_companyclientlist.php"><button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-chevron-left"></span>Go Back </button></a>
                       <br><br>
                       <?php
                            if(isset($_SESSION["server-msg"])){
                                echo $_SESSION["server-msg"];
                                unset($_SESSION["server-msg"]);
                            }
                            ?>
                         <div id="bde-list" class="col-sm-12">        
                            <div style="overflow-x:auto;">
                                <table class="table table-bordered text-center">
                                    <thead class="sta-app-horizontal-table-thead">
                                        <tr bgcolor="lightgray">
                                            <th>Sl No. </th>
                                            <th>First Name </th>
                                            <th>Last Name </th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Category</th>
                                            <th>Designation</th>
                                            <th>Address </th>
                                            <th>Country</th>
                                            <th>State </th>
                                            <th>City </th>
                                            <th>LinkedIn Id </th>
                                            <th>Facebook Id </th>
                                            <th>Twitter Id </th>
                                            <th> Edit </th>
                                        </tr>  
                                    </thead>
                                    <tbody  id="bde-list-table"></tbody>
                                </table> 
                            </div>     
                         </div>    
                </div>
            <?php endif; ?>
        </div> 
    </div>
    <?php include 'footer.php';?>
</body>
</html>
<!--MODAL TO EDIT THE CLIENT CONTACTS -->
<p  data-toggle="modal" data-target="#myModal"></p>

<div id="myModal" class="modal fade"  class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header  text-center bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Client Details</h4>
      </div>
      <div class="modal-body">
           
      <!-- modal body starts here -->
      <!-- input fields starts here -->
                        <input type="hidden" name="clientId" id="clientId">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>First Name: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input id="clientFirstName" name="clientFirstName" type="text" class="form-control" placeholder="Enter Your First Name" onfocusout="validateClientFirstName()">
                                                <i id="clientFirstNameError" class="input-error"></i>            
                                                </div>
                                            </div>
                                        </div><!-- row end -->

                                        <div class="form-group">
                                            <div class="row">
                                                    <div class="col-sm-4">
                                                        <label>Last Name: </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                    <input id="clientLastName" name="clientLastName" type="text" class="form-control" placeholder="Enter Your Last Name" onfocusout="validateClientLastName()">
                                                    <i id="clientLastNameError" class="input-error"></i>                   
                                                    </div>
                                                </div>
                                        </div><!-- row end -->

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Email id: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input id="clientEmail" name="clientEmail" type="text" class="form-control" placeholder="Enter Your email-id" onfocusout="validateMultipleEmails()" > 
                                                    <i id="clientEmailError" class="input-error"></i>  
                                                </div>
                                            </div>
                                        </div><!-- row end -->

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Mobile No.: </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input id="clientMobile" name="clientMobile" type="text" class="form-control" placeholder="Enter Your contact number" onfocusout="validateClientMobile()">
                                                <i id="clientMobileError" class="input-error"></i>  
                                            </div>
                                        </div>
                                    </div><!-- row end -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Category: </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input  id="clientCategory" name="clientCategory"   class="form-control" onfocusout ="validateClientCategoty()">
                                            <i id="clientCategoryError" class="input-error"></i>  
                                        </div>
                                    </div>
                                </div><!-- row end -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Designation: </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input  id="clientDesignation" name="clientDesignation"  class="form-control" onfocusout="validateClientDesignation()">
                                            <i id="clientDesignationError" class="input-error"></i> 
                                    
                                        </div>
                                    </div>
                                </div><!-- row end -->
                                <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Address: </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" placeholder="Enter your address here" name="clientAddress" id="clientAddress" onfocusout ="validateClientAddress()"></textarea>
                                        <i class="input-error" id="clientAddressError"></i>
                                    </div>
                                </div>
                            </div><!-- row end -->

                             <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Country: </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select id="clientCountry" name="clientCountry"  class="form-control" onfocusout="validateClientCountry()">
                                        <option value="">Select Country</option>
                                        </select>
                                        <i  class="input-error"id="clientCountryError"></i>
                                    </div>
                                </div>
                            </div><!-- row end -->
                            <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>State: </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <select id="clientState" name="clientState"  class="form-control" onfocusout="validateClientState()">
                                                <option value="">Select States</option>
                                            </select>
                                            <i  class="input-error" id="clientStateError"></i>
                                        </div>
                                    </div>
                                </div><!-- row end -->
                           
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>City: </label>
                                        </div>
                                        <div class="col-sm-8">
                                        <select id="clientCity" name="clientCity"  class="form-control" onfocusout="validateClientCity()">
                                                <option value="">Select City</option>
                                            </select>
                                            <i  class="input-error" id="clientCityError"></i>
                                        </div>
                                    </div>
                                </div><!-- row end -->
                                
                           
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>LinkedIn Id: </label>
                                </div>
                                <div class="col-sm-8">
                                    <input  id="clientLinkedInId"  name="clientLinkedInId" type="text"  class="form-control" placeholder="Please Provide Linkedin id">
                                      
                                </div>
                            </div>
                        </div><!-- row end -->            

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Facebook Id: </label>
                                </div>
                                <div class="col-sm-8">
                                    <input id="clientFacebookId" name="clientFacebookId" type="text" class="form-control" placeholder="Please Provide facebook id">
                                   
                                </div>
                            </div>
                        </div><!-- row end -->    

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Twitter Id: </label>
                                </div>
                                    <div class="col-sm-8">
                                        <input id="clientTwitterId" name="clientTwitterId" type="text"  class="form-control" placeholder="Please Provide twitter id">
                   
                                    </div>
                            </div>
                        </div><!-- row end -->

                    <div class="form-group">
                        <div class="row text-center">
                            <input type="button" value="Update"  class="btn btn-success" onclick="updateClient()">
                            
                        </div>
                    </div><!-- row end -->
      <!-- input fields ends here -->
      <!-- modal body ends here -->
          
      </div>
      
    </div>

  </div>
</div>