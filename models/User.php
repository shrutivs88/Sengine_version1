<?php

class User {

    public $id;
    public $empId;
    public $name;
    public $email;
    public $password;
    public $role;
    public $manager;

    /**
     * Getters
     */
    public function getId() {
        return $this->id;
    }

    public function getEmpId() {
        return $this->empId;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function getManager() {
        return $this->manager;
    }

    /**
     * Setters
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function setEmpId($empId) {
        $this->empId = $empId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setRole($role) {
        $this->role = $role;
    }

    public function setManager($manager) {
        $this->manager = $manager;
    }

}

?>