<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/services/LocationService.php');

$locationService = new LocationService();
$locationType = $_POST["locationType"];

if($locationType == "country") {
    $listOfCountries = $locationService->getAllCountries();
    header('Content-Type: application/json');
    echo json_encode($listOfCountries);
    exit();
}


if($locationType == "state") {
    $countryId = $_POST["countryId"];
    $listOfStates = $locationService->getAllStatesByCountryId($countryId);
    header('Content-Type: application/json');
    echo json_encode($listOfStates);
    exit();
}

if($locationType == "city") {
    $stateId = $_POST["stateId"];
    $listOfCities = $locationService->getAllCitiesByStateId($stateId);
    header('Content-Type: application/json');
    echo json_encode($listOfCities);
    exit();
}

if($locationType == "country-all") {
    $response = new stdClass();
    $listOfCountries = $locationService->getAllCountries();
    $response->locationType = "country-all";
    $response->data = $listOfCountries;
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if($locationType == "state-all") {
    $response = new stdClass();
    $listOfStates = $locationService->getAllStates();
    $response->locationType = "state-all";
    $response->data = $listOfStates;
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if($locationType == "city-all") {
    $response = new stdClass();
    $listOfCities = $locationService->getAllCities();
    $response->locationType = "city-all";
    $response->data = $listOfCities;
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

?>