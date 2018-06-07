<?php

class Contact {

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $category;
    public $designation;
    public $mobile;
    public $city;
    public $state;
    public $country;
    public $address;
    public $linkedIn;
    public $facebook;
    public $twitter;
    public $status;
    public $added;
    public $company;
    public $assocManager;
    public $assocUser;
    public $emailTimeout;

    /**
     * Getters
     */
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getLinkedIn() {
        return $this->linkedIn;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAdded() {
        return $this->added;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getAssocManager() {
        return $this->assocManager;
    }

    public function getAssocUser()  {
        return $this->assocUser;
    }

    public function getEmailTimeout() {
        return $this->emailTimeout;
    }

    /**
     * Setters
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setLinkedIn($linkedIn) {
        $this->linkedIn = $linkedIn;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setAdded($added) {
        $this->added = $added;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function setAssocManager($assocManager) {
        $this->assocManager = $assocManager;
    }

    public function setAssocUser($assocUser) {
        $this->assocUser = $assocUser;
    }

    public function setEmailTimeout($emailTimeout) {
        $this->emailTimeout = $emailTimeout;
    }
    
}