<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
if(!isset($_SESSION["email"])) {
    header("Location:login.php");
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
    <style>
        .input-error {
            color: red;
        }      
    </style>
    <script src="<?php echo BASEURL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/bde/validation.js"></script>
    <script>
    var responseData = [];
    var limit = 10;
    var offset = 0;
    var isUpdateOffsetPristine = true;
    var countries = [];
    var states = [];
    var cities = [];
    var countryidset = "";
    var stateidset = "";
    var cityidset = "";


    $(document).ready(function() {
        preInitilizeLocationChainingEffectBeginByInitCountry();

        $("#ajaxButton").click(function() {
            loadByLimit();
        });

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
                loadByLimit();
            }
        });
    }
    /**
    On change activates
    */
    function loadStatesByCountryIdJson(countryId){
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL ?>actions/bde/locationDetails.php",
            data: {
                country_id: countryId,
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
            }
        });
    }

    /**
    On change activates
    */
   function loadCitiesByStateIdJson(stateId) {
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL ?>actions/bde/locationDetails.php",
            data: {
                state_id:stateId,
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
/*var data = "";
    $.each(responseData, function( key, value ) {
           if(value.id == clientId) {
               data = value;
               setModalFields(data);
                return;
             }
           
        }); 

    function showEditClient(clientId) {
        $("#myModal").modal();
       // console.log(responseData);
        var data = [];
        for(var i=0; i<responseData.length;i++){
            if(responseData[i].id== clientId){
              //  alert(responseData[i].id);
        $("#clientId").val(responseData[i].id);
        $("#clientFirstName").val(responseData[i].firstName);
        $("#clientLastName").val(responseData[i].lastName);
        $("#clientEmail").val(responseData[i].email);
        $("#clientMobile").val(responseData[i].mobile);
        $("#clientCategory").val(responseData[i].category);
        $("#clientDesignation").val(responseData[i].designation);
        $("#clientAddress").val(responseData[i].address);
        $("#clientLinkedInId").val(responseData[i].linkedIn);
        $("#clientFacebookId").val(responseData[i].facebook);
        $("#clientTwitterId").val(responseData[i].twitter);
        $("#clientCompanyId").val(responseData[i].company);
        $("#clientDateTime").val(responseData[i].added);
        alert(countryidset);
        countryidset = responseData[i].country;
        stateidset = responseData[i].state;
        cityidset = responseData[i].city;

        
        loadCountriesJsonAndSetCountry(data);

            }
        }
            
    }*/


    function showEditClient(clientId) {
        $("#myModal").modal();
        data = "";
        $.each(responseData, function( key, value ) {
            console.log(responseData);
           if(value.id == clientId) {
               data = value;
               setModalFields(data);
                return;
             }
        });
    }

    function setModalFields(data) {
        $("#clientId").val(data.id);
        $("#clientFirstName").val(data.firstName);
        $("#clientLastName").val(data.lastName);
        $("#clientEmail").val(data.email);
        $("#clientMobile").val(data.mobile);
        $("#clientCategory").val(data.category);
        $("#clientDesignation").val(data.designation);
        $("#clientAddress").val(data.address);
        $("#clientLinkedInId").val(data.linkedIn);
        $("#clientFacebookId").val(data.facebook);
        $("#clientTwitterId").val(data.twitter);
        $("#clientCompanyId").val(data.company);
        $("#clientDateTime").val(data.added);
        loadCountriesJsonAndSetCountry(data);
        
    }


    function loadCountriesJsonAndSetCountry(data) {
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL; ?>actions/bde/locationDetails.php",
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
                        $("#clientCountry").val(data.country);
                        if(data.country== 0) {
                            $("#clientCountry").val("");
                        }
                        loadStatesJsonAndSetState(data);
            }
        });
    }

    function loadStatesJsonAndSetState(data) {
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL; ?>actions/bde/locationDetails.php",
            data: {
                country_id: data.country,
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
                        $("#clientState").val(data.state);
                        if(data.state== 0) {
                            $("#clientState").val("");
                        }
                        loadCitiesJsonAndSetCity(data);
            }
        });
    }

    function loadCitiesJsonAndSetCity(data) {
        $.ajax({
            type: "post",
            url: "<?php echo BASEURL; ?>actions/bde/locationDetails.php",
            data: {
                state_id: data.state,
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
                        $("#clientCity").val(data.city);
                        if(data.city == 0) {
                            $("#clientCity").val("");
                        }
            }
        });
    }
    /**".php",
    Backend call to save data */
    function updateClient(clientId) {
        //check
        if(validateUpdateClient()) {
            $("#myModal").modal('toggle');
            $.ajax({
                type: "post",
                url: '<?php echo BASEURL ?>actions/bde/performupdateclientcontact.php',
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

   /* function deleteClient(clientId) {
        $.ajax({
            type: "post",
            url: "deleteclientcontact.php",
            data: {
                clientId: clientId
            },
            success: function(response) {
                window.location.reload();
            }
        });
    }*/
    function showClientCompany(companyId) {
        //window.location.href="showCompany.php?companyId="+companyId;
        $("#myModalCompany").modal('toggle');
        $.ajax({
                type: "post",
                url:"<?php echo BASEURL; ?>actions/bde/performfetchclientcompany.php",
                data: {
                    companyId:companyId
                    
                },
                success: function(companyresult){
                    //console.log(companyresult);
                    //return;
                    $("#companyName").html(companyresult.name);
                    $("#companyWebsite").html(companyresult.website);
                    $("#companyEmail").html(companyresult.email);
                    $("#companyPhone").html(companyresult.phone);
                    $("#companyLinkedIn").html(companyresult.linkedin);
                    $("#companyAddress").html(companyresult.address);
                
                }
        });
    }

    var offset = 0;
    var limit = 4;
    var isUpdateOffsetPristine = true;
    var count =0;

function loadByLimit(){
    count++;
    $("#ajaxButton").prop("disabled", "true");
    $.ajax({
        type: "POST",
        url: "<?php echo BASEURL;?>actions/bde/performclientdatabasepage.php",
        data: {
            offsetVal: offset

        },
        success:function(response) {
           // console.log(response);
           // return;
            jQuery.each( response, function( index, value ) {
                responseData.push(jQuery.extend(true, {}, value));
            });
            if(response.length == 0 && isUpdateOffsetPristine == true) {
                $("#bde-list").html("<h4 class='text-center'>No Clients Are Available!</h4>");
                $("#ajaxButton").hide();
                return;
            } else if(response.length == 0 && isUpdateOffsetPristine == false) {
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
                var bdeListBuilder = "";
                bdeListBuilder += "<tr>";

                //bdeListBuilder += "<td>" + data[i].clientId + "</td>";
               // bdeListBuilder += "<td>"+ parseInt(i+1) +"</td>";
                bdeListBuilder += "<td>"+ parseInt(count+i) +"</td>";
                bdeListBuilder += "<td>" + response[i].firstName + "</td>";
                bdeListBuilder += "<td>" + response[i].lastName + "</td>";
                bdeListBuilder += "<td>" + response[i].email + "</td>";
                bdeListBuilder += "<td>" + response[i].mobile + "</td>";
                bdeListBuilder += "<td>" + response[i].category + "</td>";
                bdeListBuilder += "<td>" + response[i].designation + "</td>";
                bdeListBuilder += "<td>" + response[i].address + "</td>";
                var isCountrySet = false;
                jQuery.each( countries, function( index, value ) {
                    if(value.country_id == response[i].country) {
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
                    if(value.state_id == response[i].state) {
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
                    if(value.city_id == response[i].city) {
                        bdeListBuilder += "<td>" + value.city_name + "</td>";
                        isCitySet = true;
                        return;
                    }
                });
                if(!isCitySet) {
                    bdeListBuilder += "<td>-</td>";
                }
                bdeListBuilder += "<td>" + response[i].linkedIn  + "</td>";
                bdeListBuilder += "<td>" + response[i].facebook + "</td>";
                bdeListBuilder += "<td>" + response[i].twitter + "</td>";
                bdeListBuilder += "<td>" + response[i].status + "</td>";
                bdeListBuilder += "<td>" + response[i].added + "</td>";
              //  bdeListBuilder += "<td><button class='btn btn-primary action-btn' title ='Edit Client' onclick='showEditClient(" + response[i].id + ")'><span class='glyphicon glyphicon-edit'></span></button></td>";
              //  bdeListBuilder +="<td><button class='btn btn-green action-btn' title ='Show Company'  onclick='showClientCompany(" + response[i].company + ")'><span class='glyphicon glyphicon-eye-open'></span></button></td>";
              bdeListBuilder += "<td style='display:flex;border:0px;'><button class='btn action-btn' title ='Edit Client' onclick='showEditClient(" + response[i].id + ")'><span class='glyphicon glyphicon-edit'></span></button><button class='btn action-btn' title ='Show Company' onclick='showClientCompany(" + response[i].company + ")'><span class='glyphicon glyphicon-eye-open'></span></button></td>'";
                bdeListBuilder += "</tr>";
                $("#bde-list-table").append(bdeListBuilder);
            }
            offset += limit;
            isUpdateOffsetPristine = false;  
            count = count+limit-1;

            $("#ajaxButton").prop("disabled", ""); 
        }
    });        
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
                    <h2 class="text-center">Client List</h2>
                    <div class="row">
                        <p id="clients" class="text-center" style="color:red;"></p>
                        <?php
                            if(isset($_SESSION["server-msg"])){
                                echo $_SESSION["server-msg"];
                                unset($_SESSION["server-msg"]);
                            }
                            ?>
                        <div id="bde-list" class="col-md-12 text-center">
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
                                            <th>Status </th>
                                            <th>Date & Time </th>
                                            <th>Actions</th>
                                           <!-- <th>Edit</th>
                                            <th>Show Company</th>-->
                                        </tr>  
                                    </thead>
                                    <tbody  id="bde-list-table"></tbody>
                                </table> 
                            </div>                  
                        </div>
                    </div>
                    <div class="text-center" style="margin-top: 10px;">
                        <input type="button" class="btn btn-default" value="Click Here" id="ajaxButton"/>
                    </div>
                    <div id="result"></div>
                </div>
            <?php endif; ?>
        </div>     
    </div> 
    <?php include 'footer.php';?>
</body>
</html>
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
<!--MODAL of COMPANY DETAILS -->
<p  data-toggle="modal" data-target="#myModalCompany"></p>
<div id="myModalCompany" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header  text-center  bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Client Company Details</h4>
      </div>
      <div class="modal-body">
      <!-- modal body starts here -->
     <table class="table table-bordered"  >
                        <tr>
                        <th>Company Name : </th>
<td  id="companyName" name="companyName"></td>
                        </tr>   
                        <tr>            
                        <th>Company Website: </th>
<td id="companyWebsite" name="companyWebsite" ></td>
                          </tr>    
                          <tr>
                        <th>Company Email id: </th>
<td  id="companyEmail" name="companyEmail" ></td>
                             </tr>    
                             <tr>
                        <th>Company Phone: </th>
<td id="companyPhone" name="companyPhone" ></td>
                                   </tr>  
                                   <tr>
                        <th>Company LinkedIN Id: </th>
<td id="companyLinkedIn" name="companyLinkedIn"></td>
                                     </tr> 
                                     <tr>
                        <th>Company Address: </th>
<td  id="companyAddress" name="companyAddress"></td>
                          </tr>            
      <!-- modal body ends here -->
          
          </table>
      </div>
      
    </div>

  </div>
</div>



