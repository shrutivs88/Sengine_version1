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
                    <h2 class="text-center">Configurations / Locations Configuration / Add Location</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row text-center menu-bar">
                        <div class="col-sm-12">
                            <button id="back-btn" class="btn btn-primary action-btn btn-identical-dimension" onclick="gotoLocationsConfigPage()">Back</button>
                            <button id="add-country-btn" class="btn btn-default action-btn btn-identical-dimension" onclick="showAddCountryDiv()">Add Country</button>
                            <button id="add-state-btn" class="btn btn-default action-btn btn-identical-dimension" onclick="showAddStateDiv()">Add State</button>
                            <button id="add-city-btn" class="btn btn-default action-btn btn-identical-dimension" onclick="showAddCityDiv()">Add City</button>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Add Country -->
                        <div id="add-country-div" class="col-sm-offset-2 col-sm-8">
                            <form id="addCountryForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/admin/performaddlocation.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2">Country</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="countryName" id="country-countryName" placeholder="Enter Country Name" class="form-control" onfocusout="validateCountry()">
                                        <p id="country-countryErrMsg"></p>
                                    </div>
                                </div>
                                <input type="hidden" name="locationType" value="country">
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="country-add-btn" type="button" class="btn btn-primary form-btn" onclick="addCountryFormValidation()">Add</button>
                                        <button id="country-reset-btn" type="button" class="btn btn-warning form-btn" onclick="addCountryFormReset()">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Add State -->
                        <div id="add-state-div" class="col-sm-offset-2 col-sm-8">
                            <form id="addStateForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/admin/performaddlocation.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2">Country</label>
                                    <div class="col-sm-10">
                                        <select name="countryName" id="state-countryName" class="form-control" onfocusout="validateState_country()">
                                            <option value="">Select Country</option>
                                        </select>
                                        <p id="state-countryErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2">State</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="stateName" id="state-stateName" placeholder="Enter State Name" class="form-control" onfocusout="validateState_state()">
                                        <p id="state-stateErrMsg"></p>
                                    </div>
                                </div>
                                <input type="hidden" name="locationType" value="state">
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="state-add-btn" type="button" class="btn btn-primary form-btn" onclick="addStateFormValidation()">Add</button>
                                        <button id="state-reset-btn" type="button" class="btn btn-warning form-btn" onclick="addStateFormReset()">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Add City -->
                        <div id="add-city-div" class="col-sm-offset-2 col-sm-8">
                            <form id="addCityForm" class="form-horizontal" action="<?php echo BASEURL; ?>actions/admin/performaddlocation.php" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2">Country</label>
                                    <div class="col-sm-10">
                                        <select name="countryName" id="city-countryName" class="form-control" onfocusout="validateCity_country()">
                                            <option value="">Select Country</option>
                                        </select>
                                        <p id="city-countryErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2">State</label>
                                    <div class="col-sm-10">
                                        <select name="stateName" id="city-stateName" class="form-control" onfocusout="validateCity_state()">
                                            <option value="">Select State</option>
                                        </select>
                                        <p id="city-stateErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-2">City</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="cityName" id="city-cityName" placeholder="Enter City Name" class="form-control" onfocusout="validateCity_city()">
                                        <p id="city-cityErrMsg"></p>
                                    </div>
                                </div>
                                <input type="hidden" name="locationType" value="city">
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="city-add-btn" type="button" class="btn btn-primary form-btn" onclick="addCityFormValidation()">Add</button>
                                        <button id="city-reset-btn" type="button" class="btn btn-warning form-btn" onclick="addCityFormReset()">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>

        var addDivType = "";

        $(document).ready(function() {
            $("#add-country-div").hide();
            $("#add-state-div").hide();
            $("#add-city-div").hide();
            $("#city-countryName").change(function(){
                loadStatesForCountry();
            });
        });

        function gotoLocationsConfigPage() {
            window.location.href = "locationconfiguration.php";
        }

        function showAddCountryDiv() {
            addDivType = "country";
            $("#add-country-div").show();
            $("#add-state-div").hide();
            $("#add-city-div").hide();
            $("#add-country-btn").attr('class', 'btn btn-success  action-btn btn-identical-dimension');
            $("#add-state-btn").attr('class', 'btn btn-default  action-btn btn-identical-dimension');
            $("#add-city-btn").attr('class', 'btn btn-default  action-btn btn-identical-dimension');
            addCountryFormReset();
            addStateFormReset();
            addCityFormReset();
        }

        function showAddStateDiv() {
            addDivType = "state";
            $("#add-country-div").hide();
            $("#add-state-div").show();
            $("#add-city-div").hide();
            $("#add-country-btn").attr('class', 'btn btn-default  action-btn btn-identical-dimension');
            $("#add-state-btn").attr('class', 'btn btn-success  action-btn btn-identical-dimension');
            $("#add-city-btn").attr('class', 'btn btn-default  action-btn btn-identical-dimension');
            addCountryFormReset();
            addStateFormReset();
            addCityFormReset();
            loadCountries();
        }

        function showAddCityDiv() {
            addDivType = "city";
            $("#add-country-div").hide();
            $("#add-state-div").hide();
            $("#add-city-div").show();
            $("#add-country-btn").attr('class', 'btn btn-default  action-btn btn-identical-dimension');
            $("#add-state-btn").attr('class', 'btn btn-default  action-btn btn-identical-dimension');
            $("#add-city-btn").attr('class', 'btn btn-success  action-btn btn-identical-dimension');
            addCountryFormReset();
            addStateFormReset();
            addCityFormReset();
            loadCountries();
        }

        /**
        Add Country Operations */

        var country_country = "";
        var country_countryErrFlag = true;
        var country_countryErrMsg = "";

        function validateCountry() {
            country_country = $("#country-countryName").val();
            country_countryErrFlag = false;
            country_countryErrMsg = "";
            $("#country-countryName").css({"border-color":"green"});
            if(country_country == "" || country_country == null || country_country == undefined) {
                country_countryErrFlag = true;
                country_countryErrMsg = "Country Name Is Required !";
                $("#country-countryName").css({"border-color":"red"});
            }
            $("#country-countryErrMsg").text(country_countryErrMsg);
        }

        $("#addCountryForm").keypress(function(e) {
            if(e.which == 13) {
                addCountryFormValidation();
            }
        });

        function addCountryFormValidation() {
            $("#server-message").text("");
            validateCountry();
            if(country_countryErrFlag == false) {
                $("#country-countryName").prop('readonly', true);
                $("#country-reset-btn").prop('disabled', true);
                $("#country-add-btn").prop('disabled', true);
                $("#addCountryForm").submit();
            }
        }

        function addCountryFormReset() {
            country_countryErrFlag = true;
            country_countryErrMsg = "";
            $("#country-countryErrMsg").text("");
            $("#country-countryName").val("");
            $("#country-countryName").css({"border-color":"#ccc"});
            $("#server-message").text("");
        }

        /**
        Add State Operations */

        var state_country = "";
        var state_countryErrFlag = true;
        var state_countryErrMsg = "";
        var state_state ="";
        var state_stateErrFlag = true;
        var state_stateErrMsg = "";

        function validateState_country() {
            state_country = $("#state-countryName").val();
            state_countryErrFlag = false;
            state_countryErrMsg = "";
            $("#state-countryName").css({"border-color":"green"});
            if(state_country == "" || state_country == null || state_country == undefined) {
                state_countryErrFlag = true;
                state_countryErrMsg = "Country Is Required !";
                $("#state-countryName").css({"border-color":"red"});
            }
            $("#state-countryErrMsg").text(state_countryErrMsg);
        }

        function validateState_state() {
            state_state = $("#state-stateName").val();
            state_stateErrFlag = false;
            state_stateErrMsg = "";
            $("#state-stateName").css({"border-color":"green"});
            if(state_state == "" || state_state == null || state_state == undefined) {
                state_stateErrFlag = true;
                state_stateErrMsg = "State Name Is Required !";
                $("#state-stateName").css({"border-color":"red"});
            }
            $("#state-stateErrMsg").text(state_stateErrMsg);
        }

        $("#addStateForm").keypress(function(e) {
            if(e.which == 13) {
                addStateFormValidation();
            }
        });

        function addStateFormValidation() {
            $("#server-message").text("");
            validateState_country();
            validateState_state();
            if(state_countryErrFlag == false && state_stateErrFlag == false) {
                $("#state-countryName").prop('readonly', true);
                $("#state-stateName").prop('readonly', true);
                $("#state-reset-btn").prop('disabled', true);
                $("#state-add-btn").prop('disabled', true);
                $("#addStateForm").submit();
            }
        }

        function addStateFormReset() {
            state_countryErrFlag = true;
            state_stateErrFlag = true;
            state_countryErrMsg = "";
            state_stateErrMsg = "";
            $("#state-countryErrMsg").text("");
            $("#state-stateErrMsg").text("");
            $("#state-countryName").val("");
            $("#state-stateName").val("");
            $("#state-countryName").css({"border-color":"#ccc"});
            $("#state-stateName").css({"border-color":"#ccc"});
            $("#server-message").text("");
        }

        /**
        Add City Operations */

        var city_country = "";
        var city_countryErrFlag = true;
        var city_countryErrMsg = "";
        var city_state = "";
        var city_stateErrFlag = true;
        var city_stateErrMsg = "";
        var city_city = "";
        var city_cityErrFlag = true;
        var city_cityErrMsg = "";

        function validateCity_country() {
            city_country = $("#city-countryName").val();
            city_countryErrFlag = false;
            city_countryErrMsg = "";
            $("#city-countryName").css({"border-color":"green"});
            if(city_country == "" || city_country == null || city_country == undefined) {
                city_countryErrFlag = true;
                city_countryErrMsg = "Country Is Required !";
                $("#city-countryName").css({"border-color":"red"});
            }
            $("#city-countryErrMsg").text(city_countryErrMsg);
        }

        function validateCity_state() {
            city_state = $("#city-stateName").val();
            city_stateErrFlag = false;
            city_stateErrMsg = "";
            $("#city-stateName").css({"border-color":"green"});
            if(city_state == "" || city_state == null || city_state == undefined) {
                city_stateErrFlag = true;
                city_stateErrMsg = "State Is Required !";
                $("#city-stateName").css({"border-color":"red"});
            }
            $("#city-stateErrMsg").text(city_stateErrMsg);
        }

        function validateCity_city() {
            city_city = $("#city-cityName").val();
            city_cityErrFlag = false;
            city_cityErrMsg = "";
            $("#city-cityName").css({"border-color":"green"});
            if(city_city == "" || city_city == null || city_city == undefined) {
                city_cityErrFlag = true;
                city_cityErrMsg = "City Name Is Required !";
                $("#city-cityName").css({"border-color":"red"});
            }
            $("#city-cityErrMsg").text(city_cityErrMsg);
        }

        $("#addCityForm").keypress(function(e) {
            if(e.which == 13) {
                addStateFormValidation();
            }
        });

        function addCityFormValidation() {
            $("#server-message").text("");
            validateCity_country();
            validateCity_state();
            validateCity_city();
            if(city_countryErrFlag == false && city_stateErrFlag == false && city_cityErrFlag == false) {
                $("#city-countryName").prop('readonly', true);
                $("#city-stateName").prop('readonly', true);
                $("#city-stateName").prop('readonly', true);
                $("#city-reset-btn").prop('disabled', true);
                $("#city-add-btn").prop('disabled', true);
                $("#addCityForm").submit();
            }
        }

        function addCityFormReset() {
            city_countryErrFlag = true;
            city_stateErrFlag = true;
            city_cityErrFlag = true;
            city_countryErrMsg = "";
            city_stateErrMsg = "";
            city_cityErrMsg = "";
            $("#city-countryErrMsg").text("");
            $("#city-stateErrMsg").text("");
            $("#city-cityErrMsg").text("");
            $("#city-countryName").val("");
            $("#city-stateName").val("");
            $("#city-cityName").val("");
            $("#city-countryName").css({"border-color":"#ccc"});
            $("#city-stateName").css({"border-color":"#ccc"});
            $("#city-cityName").css({"border-color":"#ccc"});
            $("#server-message").text("");
        }

        /**
        Load Countries AJAX */

        function loadCountries() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/performfetchlocations.php",
                data: {
                    query: "all-contries"
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
                    if(addDivType === "state") {
                        $("#state-countryName").html(optionsBuilder);
                    } else if(addDivType === "city") {
                        $("#city-countryName").html(optionsBuilder);
                    }
                }
            });
        }

        /**
        Load State AJAX */
        function loadStatesForCountry() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/performfetchlocations.php",
                data: {
                    query: "all-states-of-a-country",
                    countryId: $("#city-countryName").val()
                },
                success: function(response) {
                    var optionsBuilder = "<option value=''>Select State</option>";
                    if(response.length == 0) {
                        $("#city-stateName").html(optionsBuilder);
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        optionsBuilder += "<option value='" + response[i].id + "'>";
                        optionsBuilder += response[i].name;
                        optionsBuilder += "</option>";
                    }
                    $("#city-stateName").html(optionsBuilder);
                }
            });
        }

    </script>
</body>
</html>