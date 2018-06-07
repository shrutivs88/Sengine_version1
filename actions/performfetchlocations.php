<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/LocationService.php');

$locationService = new LocationService();
$query = $_POST['query'];
$listOfLocations = null;

if($query == "all-contries") {
    $listOfLocations = $locationService->getAllCountries();
}

if($query == "all-states-of-a-country") {
    $countryId = $_POST["countryId"];
    $listOfLocations = $locationService->getAllStatesByCountryId($countryId);
}

header('Content-Type: application/json');
echo json_encode($listOfLocations);

?>