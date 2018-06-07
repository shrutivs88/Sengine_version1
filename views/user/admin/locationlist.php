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
                    <h2 class="text-center">Configurations / Locations Configuration / Locations List</h2>
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
                            <button id="show-country-btn" class="btn btn-default action-btn" onclick="showAllCountries()">Show Countries</button>
                            <button id="show-state-btn" class="btn btn-default action-btn" onclick="showAllStates()">Show States</button>
                            <button id="show-city-btn" class="btn btn-default action-btn" onclick="showAllCities()">Show Cities</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="list-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>

        function gotoLocationsConfigPage() {
            window.location.href = "locationconfiguration.php";
        }

        function showAllCountries() {
            $("#show-country-btn").attr('class', 'btn btn-success  action-btn');
            $("#show-state-btn").attr('class', 'btn btn-default  action-btn');
            $("#show-city-btn").attr('class', 'btn btn-default  action-btn');
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                data: {
                    locationType: "country-all"
                },
                success: function(response) {
                    if(response.data.length == 0) {
                        $("#list-container").html("<h3>No Countries Are Added</h3>");
                    }
                    var countryListBuilder = "<ul class='list-group'>";
                    for(var i=0; i<response.data.length; i++) {
                        countryListBuilder += "<li class='list-group-item'>" + response.data[i].name + "</li>"
                    }
                    countryListBuilder += "</ul>";
                    $("#list-container").html(countryListBuilder);
                }
            });
        }

        function showAllStates() {
            $("#show-country-btn").attr('class', 'btn btn-default  action-btn');
            $("#show-state-btn").attr('class', 'btn btn-success  action-btn');
            $("#show-city-btn").attr('class', 'btn btn-default  action-btn');
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                data: {
                    locationType: "state-all"
                },
                success: function(response) {
                    if(response.data.length == 0) {
                        $("#list-container").html("<h3>No States Are Added</h3>");
                    }
                    var stateListBuilder = "<ul class='list-group'>";
                    for(var i=0; i<response.data.length; i++) {
                        stateListBuilder += "<li class='list-group-item'>" + response.data[i].name + "</li>"
                    }
                    stateListBuilder += "</ul>";
                    $("#list-container").html(stateListBuilder);
                }
            });
        }

        function showAllCities() {
            $("#show-country-btn").attr('class', 'btn btn-default  action-btn');
            $("#show-state-btn").attr('class', 'btn btn-default  action-btn');
            $("#show-city-btn").attr('class', 'btn btn-success  action-btn');
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                data: {
                    locationType: "city-all"
                },
                success: function(response) {
                    if(response.data.length == 0) {
                        $("#list-container").html("<h3>No Cities Are Added</h3>");
                    }
                    var cityListBuilder = "<ul class='list-group'>";
                    for(var i=0; i<response.data.length; i++) {
                        cityListBuilder += "<li class='list-group-item'>" + response.data[i].name + "</li>"
                    }
                    cityListBuilder += "</ul>";
                    $("#list-container").html(cityListBuilder);
                }
            });
        }
    </script>
</body>
</html>
                    