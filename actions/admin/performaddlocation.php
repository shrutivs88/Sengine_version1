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
$country = $_POST["countryName"];
$state = "";
$city = "";

if($locationType == "country") {
    if(validateCountry($country)) {
        if($locationService->checkCountry($country)) {
            $locationService->saveCountry($country);
            $_SESSION['serverMsg'] = "Country Added Successfully!";
        } else {
            $_SESSION['serverMsg'] = "Country Already Exists In Database!";
        }
    }
    header("Location:../../views/user/admin/addlocation.php");
}

if($locationType == "state") {
    $state = $_POST["stateName"];
    if(validateState($country, $state)) {
        if($locationService->checkState($country, $state)) {
            $locationService->saveState($country, $state);
            $_SESSION['serverMsg'] = "State Added Successfully!";
        } else {
            $_SESSION['serverMsg'] = "State Already Exists In Database!";
        }
    }
    header("Location:../../views/user/admin/addlocation.php");
}

if($locationType == "city") {
    $state = $_POST["stateName"];
    $city = $_POST["cityName"];
    if(validateCity($country, $state, $city)) {
        if($locationService->checkCity($country, $state, $city)) {
            $locationService->saveCity($country, $state, $city);
            $_SESSION['serverMsg'] = "City Added Successfully!";
        } else {
            $_SESSION['serverMsg'] = "City Already Exists In Database!";
        }
    }
    header("Location:../../views/user/admin/addlocation.php");
}

/**
 * Country Validation
 */
function validateCountry($country) {
    if($country == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    }
    return true;
}

/**
 * State Validation
 */
function validateState($country, $state) {
    if($country == "" || $state == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    }
    return true;
} 

/**
 * City Validation
 */
function validateCity($country, $state, $city) {
    if($country == "" || $state == "" || $city == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    }
    return true;
}

?>