<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');

class ClientService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function checkCompanyWebsite($companyWebsite) {
        $stmt = $this->connection->prepare("select * from client_companies where client_company_website = ?");
        $stmt->bind_param("s", $companyWebsite);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true; 
        }
    }

    public function checkCompanyWebsiteAllowSelf($companyWebsite, $originalCompanyWebsite) {
        if($companyWebsite === $originalCompanyWebsite) {
            return true;
        }
        $stmt = $this->connection->prepare("select * from client_companies where client_company_website = ?");
        $stmt->bind_param("s", $companyWebsite);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveCompany($company) {
        $companyName = $company->getName();
        $companyWebsite = $company->getWebsite();
        $companyAddress = $company->getAddress();
        $companyPhone = $company->getPhone();
        $companyEmail = $company->getEmail();
        $companyLinkedIn = $company->getLinkedIn();
        $assocManager = $company->getAssocManager();
        $assocUser = $company->getAssocUser();
        $this->connection->query("lock tables client_companies write");
        $stmt = $this->connection->prepare("insert into client_companies (client_company_name, client_company_website, client_company_address, client_company_phone, client_company_email, client_company_linkedin, assoc_manager_id, assoc_user_id) values (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissii", $companyName, $companyWebsite, $companyAddress, $companyPhone, $companyEmail, $companyLinkedIn, $assocManager, $assocUser);
        $stmt->execute();
        $stmt->close();
        $query = $this->connection->query("select max(client_company_id) from client_companies");
        $this->connection->query("unlock tables");
        $max_client_company_id = $query->fetch_assoc()['max(client_company_id)'];
        return $max_client_company_id;
    }

    public function updateCompany($company) {
        $companyId = $company->getId();
        $companyName = $company->getName();
        $companyWebsite = $company->getWebsite();
        $companyAddress = $company->getAddress();
        $companyPhone = $company->getPhone();
        $companyEmail = $company->getEmail();
        $companyLinkedIn = $company->getLinkedIn();
        $stmt = $this->connection->prepare("update client_companies set client_company_name = ?, client_company_website = ?, client_company_address = ?, client_company_phone = ?, client_company_email = ?, client_company_linkedin = ? where client_company_id = ?");
        $stmt->bind_param("sssissi", $companyName, $companyWebsite, $companyAddress, $companyPhone, $companyEmail, $companyLinkedIn, $companyId);
        $stmt->execute();
        $stmt->close();
    }
    
    public function updateContact($contact) {
        $id = $contact->getId();
        $firstName = $contact->getFirstName();
        $lastName = $contact->getLastName();
        $email = $contact->getEmail();
        $category = $contact->getCategory();
        $designation = $contact->getDesignation();
        $mobile = $contact->getMobile();
        $city = $contact->getCity();
        $state = $contact->getState();
        $country = $contact->getCountry();
        $address = $contact->getAddress();
        $linkedIn = $contact->getLinkedIn();
        $facebook = $contact->getFacebook();
        $twitter = $contact->getTwitter();
        $stmt = $this->connection->prepare("update client_contacts set client_contact_first_name = ?, client_contact_last_name = ?, client_contact_email = ?, client_contact_category = ?, client_contact_designation = ?, client_contact_mobile = ?, city_id = ?, state_id = ?, country_id = ?, client_contact_address = ?, client_contact_linkedin = ?, client_contact_facebook = ?, client_contact_twitter = ? where client_contact_id = ?");
        $stmt->bind_param("sssssiiiissssi", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function checkContactEmail($contactEmail) {
        $stmt = $this->connection->prepare("select client_contact_email from client_contacts where client_contact_email = ?");
        $stmt->bind_param("s", $contactEmail);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkContactEmailAllowSelf($email, $originalEmail) {
        if($email === $originalEmail) {
            return true;
        }
        $stmt = $this->connection->prepare("select client_contact_email from client_contacts where client_contact_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveContact($contact) {
        $firstName = $contact->getFirstName();
        $lastName = $contact->getLastName();
        $email = $contact->getEmail();
        $category = $contact->getCategory();
        $designation = $contact->getDesignation();
        $mobile = $contact->getMobile();
        $city = $contact->getCity();
        $state = $contact->getState();
        $country = $contact->getCountry();
        $address = $contact->getAddress();
        $linkedIn = $contact->getLinkedIn();
        $facebook = $contact->getFacebook();
        $twitter = $contact->getTwitter();
        $status = "New";
        $added = date("Y-m-d H:i:s");
        $companyId = $contact->getCompany();
        $assocManager = $contact->getAssocManager();
        $assocUser = $contact->getAssocUser();
        $emailTimeout = 24;
        $stmt = $this->connection->prepare("insert into client_contacts (client_contact_first_name, client_contact_last_name, client_contact_email, client_contact_category, client_contact_designation, client_contact_mobile, city_id, state_id, country_id, client_contact_address, client_contact_linkedin, client_contact_facebook, client_contact_twitter, client_contact_status, client_contact_added, client_company_id, assoc_manager_id, assoc_user_id, email_timeout) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssiiiissssssiiis", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $status, $added, $companyId, $assocManager, $assocUser, $emailTimeout);
        $stmt->execute();
        $stmt->close();
    }

    public function getCompaniesByOffset($offset) {
        $limit = COMPANY_LIST_LIMIT;
        $stmt = $this->connection->prepare("select * from client_companies order by client_company_id desc limit ?,?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfCompanies = array();
        while($row = $res->fetch_assoc()) {
            $company = new Company();
            $company->setId($row['client_company_id']);
            $company->setName($row['client_company_name']);
            $company->setWebsite($row['client_company_website']);
            $company->setAddress($row['client_company_address']);
            $company->setPhone($row['client_company_phone']);
            $company->setEmail($row['client_company_email']);
            $company->setLinkedIn($row['client_company_linkedin']);
            $company->setAssocManager($row['assoc_manager_id']);
            $company->setAssocUser($row['assoc_user_id']);
            array_push($listOfCompanies, $company);
        }
        $stmt->close();
        return $listOfCompanies;
    }

    public function getCompanyById($companyId) {
        $stmt = $this->connection->prepare("select * from client_companies where client_company_id = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $res = $stmt->get_result();
        $company = new Company();
        if($row = $res->fetch_assoc()) {
            $company->setId($row['client_company_id']);
            $company->setName($row['client_company_name']);
            $company->setWebsite($row['client_company_website']);
            $company->setAddress($row['client_company_address']);
            $company->setPhone($row['client_company_phone']);
            $company->setEmail($row['client_company_email']);
            $company->setLinkedIn($row['client_company_linkedin']);
            $company->setAssocManager($row['assoc_manager_id']);
            $company->setAssocUser($row['assoc_user_id']);
        }
        $stmt->close();
        return $company;
    }

    public function getContactsByOffset($offset) {
        $limit = CONTACT_LIST_LIMIT;
        $stmt = $this->connection->prepare("select * from client_contacts order by client_contact_id desc limit ?,?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfContacts = array();
        while($row = $res->fetch_assoc()) {
            $contact = new Contact();
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            /**set here */
           
            if($row['client_contact_status'] == "Proposal Sent"){
                if(function_exists('date_default_timezone_set')) {
                    date_default_timezone_set("Asia/Kolkata");
                    $php_timestamp_date = date("Y-m-d H:i:s");
                }
                $client_email_id = array();
                $client_email_id = explode(',',$row['client_contact_email']);
                $mail_activity = "select * from mail_activities where mail_activity_to='$client_email_id[0]'";  
                $mail_activity_res = mysqli_query($this->connection, $mail_activity);
                $mail_activity_row = mysqli_fetch_object($mail_activity_res);
                $emailtime = $mail_activity_row->mail_activity_sent_time;
                $clientemail = $mail_activity_row->mail_activity_to;
                $start_date = new DateTime($emailtime);
                $since_start = $start_date->diff(new DateTime($php_timestamp_date));
                $minutes = $since_start->days * 24;
                $minutes += $since_start->h;
                $minutes *=60 ;
                $minutes += $since_start->i; 
                $row["email_timeout"] = $row["email_timeout"] * 60;
                if($minutes >= $row["email_timeout"]) {
                    $status="Send Proposal";
                    $res_client="update client_contacts set client_contact_status='$status' where client_contact_email = '$row[client_contact_email]'";
                    mysqli_query($this->connection,$res_client); 
                    $row["client_contact_status"] = $status;
                }
            }

            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            $contact->setAssocManager($row['assoc_manager_id']);
            $contact->setAssocUser($row['assoc_user_id']);
            $contact->setEmailTimeout($row['email_timeout']);
            
            array_push($listOfContacts, $contact);
        }
        $stmt->close();
        return $listOfContacts;
    }

    public function getContactsByCompanyId($companyId) {
        $stmt = $this->connection->prepare("select * from client_contacts where client_company_id = ? order by client_contact_id desc");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfContacts = array();
        while($row = $res->fetch_assoc()) {
            $contact = new Contact();
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            $contact->setAssocManager($row['assoc_manager_id']);
            $contact->setAssocUser($row['assoc_user_id']);
            $contact->setEmailTimeout($row['email_timeout']);
            array_push($listOfContacts, $contact);
        }
        $stmt->close();
        return $listOfContacts;
    }

    public function getContactById($contactId) {
        $stmt = $this->connection->prepare("select * from client_contacts where client_contact_id = ?");
        $stmt->bind_param("i", $contactId);
        $stmt->execute();
        $res = $stmt->get_result();
        $contact = new Contact();
        if($row = $res->fetch_assoc()) {
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            $contact->setAssocManager($row['assoc_manager_id']);
            $contact->setAssocUser($row['assoc_user_id']);
            $contact->setEmailTimeout($row['email_timeout']);
        }
        $stmt->close();
        return $contact;
    }

    public function deleteContactById($contactId) {
        $stmt = $this->connection->prepare("delete from client_contacts where client_contact_id = ?");
        $stmt->bind_param("i", $contactId);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    public function deleteCompanyByIdCascadeDeleteContacts($companyId) {
        $stmt = $this->connection->prepare("delete from client_contacts where client_company_id  = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        $stmt = $this->connection->prepare("delete from client_companies where client_company_id = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $affected_rows += $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    public function getCountOfCompanies() {
        $query = $this->connection->query("select count(client_company_id) from client_companies");
        $count_client_companies = $query->fetch_assoc()['count(client_company_id)'];
        return $count_client_companies;
    }
    
    public function getCountOfContacts() {
        $query = $this->connection->query("select count(client_contact_id) from client_contacts");
        $count_client_contacts = $query->fetch_assoc()['count(client_contact_id)'];
        return $count_client_contacts;
    }

    public function updateEmailTimeout($contactId, $emailTimeout) {
        $stmt = $this->connection->prepare("update client_contacts set email_timeout = ? where client_contact_id = ?");
        $stmt->bind_param("di", $emailTimeout, $contactId);
        $stmt->execute();
        $stmt->close();
    }

//BDM CLIENT SERVICES

    public function getContactsByOffsetforbde($bdeempid,$offset) {
            $limit = CONTACT_LIST_LIMIT;
            $stmt = $this->connection->prepare("select * from client_contacts where assoc_user_id = ? limit ? ,?");
            $stmt->bind_param("iii", $bdeempid,$offset, $limit);
            $stmt->execute();
            $res = $stmt->get_result();
           
            $listOfContactsforbde = array();
                while($row = $res->fetch_assoc()) {
                    $contact = new Contact();
                    $contact->setId($row['client_contact_id']);
                    $contact->setFirstName($row['client_contact_first_name']);
                    $contact->setLastName($row['client_contact_last_name']);
                    //$contact->setEmail($row['client_contact_email']);
                    $contact->setCategory($row['client_contact_category']);
                    $contact->setDesignation($row['client_contact_designation']);
                    $contact->setMobile($row['client_contact_mobile']);
                    //FETCHING COUNTRY NAME
                    $countryid = $row['country_id'];
                    $stmt_country = $this->connection->prepare("select country_name from countries where country_id=?");
                    $stmt_country->bind_param("i", $countryid);
                    $stmt_country->execute();
                    $res_country = $stmt_country->get_result();
                    $row_country = $res_country->fetch_assoc();
                    $contact->setCountry($row_country['country_name']);
                    //FETCHING STATE NAME
                    $stateid = $row['state_id'];
                    $stmt_state = $this->connection->prepare("select state_name from states where state_id=?");
                    $stmt_state->bind_param("i", $stateid);
                    $stmt_state->execute();
                    $res_state = $stmt_state->get_result();
                    $row_state = $res_state->fetch_assoc();
                    $contact->setState($row_state['state_name']);
                    //FETCHING CITY NAME
                    $cityid = $row['city_id'];
                    $stmt_city = $this->connection->prepare("select city_name from cities where city_id=?");
                    $stmt_city->bind_param("i", $cityid);
                    $stmt_city->execute();
                    $res_city = $stmt_city->get_result();
                    $row_city = $res_city->fetch_assoc();
                    $contact->setCity($row_city['city_name']);
                    //$contact->setCity($row['city_id']);
                    if(function_exists('date_default_timezone_set')) 
                    {
                        date_default_timezone_set("Asia/Kolkata");
                        $php_timestamp_date = date("Y-m-d H:i:s");   
                    }
                    $contact->setAddress($row['client_contact_address']);
                    $contact->setLinkedIn($row['client_contact_linkedin']);
                    $contact->setFacebook($row['client_contact_facebook']);
                    $contact->setTwitter($row['client_contact_twitter']);
                    $client_email = array();
                    $client_email_id = explode(',',$row['client_contact_email']);
                    $client_email = implode('<br>',$client_email_id);
                    
                //Fetching
                if($row['client_contact_status'] == "Proposal Sent")
                    {   
                        $stmt_status = $this->connection->prepare("select mail_activity_sent_time,mail_activity_to from mail_activities where mail_activity_to = ?");
                        $stmt_status->bind_param("s", $client_email_id[0]);
                        $stmt_status->execute();
                        $res_status = $stmt_status->get_result();
                        $row_status = $res_status->fetch_assoc();
                        $emailtime = $row_status['mail_activity_sent_time'];
                        $mailToEmailId = $row_status['mail_activity_to'];
            
                        $start_date = new DateTime($emailtime);
                        $since_start = $start_date->diff(new DateTime($php_timestamp_date));
                        $minutes = $since_start->days * 24;
                        $minutes += $since_start->h;
                        $minutes *=60 ;
                        $minutes += $since_start->i; 
                
                        $row["email_timeout"] = $row["email_timeout"] * 60;
                        if($minutes >= $row["email_timeout"]) 
                            {
                            $status="Send Proposal";
                            $stmt_clientUpdate = $this->connection->prepare("update client_contacts set client_contact_status='$status' where client_contact_email=?");
                            $stmt_clientUpdate->bind_param("s", $row['client_contact_email']);
                            $stmt_clientUpdate->execute();
                            $res_clientUpdate = $stmt_clientUpdate->get_result();
                            $row_clientUpdate = $res_clientUpdate->fetch_assoc();
                            $row["client_contact_status"] = $status;
                            }
                    }
                    $contact->setStatus($row['client_contact_status']);
                    $row["client_contact_email"] = $client_email;
                    $contact->setEmail($row['client_contact_email']);
                    $contact->setEmailTimeout($row['email_timeout']);
                    $contact->setAdded($row['client_contact_added']);
                    $contact->setCompany($row['client_company_id']);
                    $contact->setAssocManager($row['assoc_manager_id']);
                    $contact->setAssocUser($row['assoc_user_id']);
                    array_push($listOfContactsforbde, $contact);
                }
        $stmt->close();
        return $listOfContactsforbde;
    }

    public function getContactsByOffsetforbdm($userid,$offset) {
        $limit = CONTACT_LIST_LIMIT;
        $stmt_bdm =  $this->connection->prepare("select user_emp_id from users where user_id = ?");
        $stmt_bdm->bind_param("i", $userid);
        $stmt_bdm->execute();
        $res_bdm = $stmt_bdm->get_result();
        $row_bdm = $res_bdm->fetch_assoc();
        $bdm_emp_id = $row_bdm['user_emp_id']; 
        $stmt = $this->connection->prepare("select * from client_contacts where assoc_manager_id = ? limit ? ,?");
        $stmt->bind_param("iii", $bdm_emp_id,$offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
       $listofcontactsforbdm = array();
            while($row = $res->fetch_assoc()) {
                $contact = new Contact();
                $contact->setId($row['client_contact_id']);
                $contact->setFirstName($row['client_contact_first_name']);
                $contact->setLastName($row['client_contact_last_name']);
                $contact->setCategory($row['client_contact_category']);
                $contact->setDesignation($row['client_contact_designation']);
                $contact->setMobile($row['client_contact_mobile']);
                //FETCHING COUNTRY NAME
                $countryid = $row['country_id'];
                $stmt_country = $this->connection->prepare("select country_name from countries where country_id=?");
                $stmt_country->bind_param("i", $countryid);
                $stmt_country->execute();
                $res_country = $stmt_country->get_result();
                $row_country = $res_country->fetch_assoc();
                $contact->setCountry($row_country['country_name']);
                //FETCHING STATE NAME
                $stateid = $row['state_id'];
                $stmt_state = $this->connection->prepare("select state_name from states where state_id=?");
                $stmt_state->bind_param("i", $stateid);
                $stmt_state->execute();
                $res_state = $stmt_state->get_result();
                $row_state = $res_state->fetch_assoc();
                $contact->setState($row_state['state_name']);
                //FETCHING CITY NAME
                $cityid = $row['city_id'];
                $stmt_city = $this->connection->prepare("select city_name from cities where city_id=?");
                $stmt_city->bind_param("i", $cityid);
                $stmt_city->execute();
                $res_city = $stmt_city->get_result();
                $row_city = $res_city->fetch_assoc();
                $contact->setCity($row_city['city_name']);
                //$contact->setCity($row['city_id']);
                if(function_exists('date_default_timezone_set')) 
                {
                    date_default_timezone_set("Asia/Kolkata");
                    $php_timestamp_date = date("Y-m-d H:i:s");   
                }
                $contact->setAddress($row['client_contact_address']);
                $contact->setLinkedIn($row['client_contact_linkedin']);
                $contact->setFacebook($row['client_contact_facebook']);
                $contact->setTwitter($row['client_contact_twitter']);
                $client_email = array();
                $client_email_id = explode(',',$row['client_contact_email']);
                $client_email = implode('<br>',$client_email_id);
                
            //Fetching
            if($row['client_contact_status'] == "Proposal Sent")
                {   
                    $stmt_status = $this->connection->prepare("select mail_activity_sent_time,mail_activity_to from mail_activities where mail_activity_to = ?");
                    $stmt_status->bind_param("s", $client_email_id[0]);
                    $stmt_status->execute();
                    $res_status = $stmt_status->get_result();
                    $row_status = $res_status->fetch_assoc();
                    $emailtime = $row_status['mail_activity_sent_time'];
                    $mailToEmailId = $row_status['mail_activity_to'];
        
                    $start_date = new DateTime($emailtime);
                    $since_start = $start_date->diff(new DateTime($php_timestamp_date));
                    $minutes = $since_start->days * 24;
                    $minutes += $since_start->h;
                    $minutes *=60 ;
                    $minutes += $since_start->i; 
            
                    $row["email_timeout"] = $row["email_timeout"] * 60;
                    if($minutes >= $row["email_timeout"]) 
                        {
                        $status="Send Proposal";
                        $stmt_clientUpdate = $this->connection->prepare("update client_contacts set client_contact_status='$status' where client_contact_email=?");
                        $stmt_clientUpdate->bind_param("s", $row['client_contact_email']);
                        $stmt_clientUpdate->execute();
                        $res_clientUpdate = $stmt_clientUpdate->get_result();
                        $row_clientUpdate = $res_clientUpdate->fetch_assoc();
                        $row["client_contact_status"] = $status;
                        }
                }
                $contact->setStatus($row['client_contact_status']);
                $row["client_contact_email"] = $client_email;
                $contact->setEmail($row['client_contact_email']);
                $contact->setEmailTimeout($row['email_timeout']);
                $contact->setAdded($row['client_contact_added']);
                $contact->setCompany($row['client_company_id']);
                $contact->setAssocManager($row['assoc_manager_id']);
                $contact->setAssocUser($row['assoc_user_id']);
                array_push($listofcontactsforbdm,$contact);
            }
   $stmt->close();
    return $listofcontactsforbdm;
}

public function getContactsByOffsetforcompany($userid,$companyId,$offset) {
    $limit = CONTACT_LIST_LIMIT;
    $stmt_bdm =  $this->connection->prepare("select user_emp_id from users where user_id = ?");
    $stmt_bdm->bind_param("i", $userid);
    $stmt_bdm->execute();
    $res_bdm = $stmt_bdm->get_result();
    $row_bdm = $res_bdm->fetch_assoc();
    $bdm_emp_id = $row_bdm['user_emp_id']; 
    $stmt = $this->connection->prepare("select * from client_contacts where assoc_manager_id = ? and client_company_id = ? limit ? ,?");
    $stmt->bind_param("iiii", $bdm_emp_id,$companyId,$offset, $limit);
    $stmt->execute();
    $res = $stmt->get_result();
    $listofcontactsforcompany = array();
 
        while($row = $res->fetch_assoc()) {
            $contact = new Contact();
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            //$contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            //FETCHING COUNTRY NAME
            $countryid = $row['country_id'];
            $stmt_country = $this->connection->prepare("select country_name from countries where country_id=?");
            $stmt_country->bind_param("i", $countryid);
            $stmt_country->execute();
            $res_country = $stmt_country->get_result();
            $row_country = $res_country->fetch_assoc();
            $contact->setCountry($row_country['country_name']);
            //FETCHING STATE NAME
            $stateid = $row['state_id'];
            $stmt_state = $this->connection->prepare("select state_name from states where state_id=?");
            $stmt_state->bind_param("i", $stateid);
            $stmt_state->execute();
            $res_state = $stmt_state->get_result();
            $row_state = $res_state->fetch_assoc();
            $contact->setState($row_state['state_name']);
            //FETCHING CITY NAME
            $cityid = $row['city_id'];
            $stmt_city = $this->connection->prepare("select city_name from cities where city_id=?");
            $stmt_city->bind_param("i", $cityid);
            $stmt_city->execute();
            $res_city = $stmt_city->get_result();
            $row_city = $res_city->fetch_assoc();
            $contact->setCity($row_city['city_name']);
            //$contact->setCity($row['city_id']);
            if(function_exists('date_default_timezone_set')) 
            {
                date_default_timezone_set("Asia/Kolkata");
                $php_timestamp_date = date("Y-m-d H:i:s");   
            }
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $client_email = array();
            $client_email_id = explode(',',$row['client_contact_email']);
            $client_email = implode('<br>',$client_email_id);
            
        //Fetching
        if($row['client_contact_status'] == "Proposal Sent")
            {   
                $stmt_status = $this->connection->prepare("select mail_activity_sent_time,mail_activity_to from mail_activities where mail_activity_to = ?");
                $stmt_status->bind_param("s", $client_email_id[0]);
                $stmt_status->execute();
                $res_status = $stmt_status->get_result();
                $row_status = $res_status->fetch_assoc();
                $emailtime = $row_status['mail_activity_sent_time'];
                $mailToEmailId = $row_status['mail_activity_to'];
    
                $start_date = new DateTime($emailtime);
                $since_start = $start_date->diff(new DateTime($php_timestamp_date));
                $minutes = $since_start->days * 24;
                $minutes += $since_start->h;
                $minutes *=60 ;
                $minutes += $since_start->i; 
        
                $row["email_timeout"] = $row["email_timeout"] * 60;
                if($minutes >= $row["email_timeout"]) 
                    {
                    $status="Send Proposal";
                    $stmt_clientUpdate = $this->connection->prepare("update client_contacts set client_contact_status='$status' where client_contact_email=?");
                    $stmt_clientUpdate->bind_param("s", $row['client_contact_email']);
                    $stmt_clientUpdate->execute();
                    $res_clientUpdate = $stmt_clientUpdate->get_result();
                    $row_clientUpdate = $res_clientUpdate->fetch_assoc();
                    $row["client_contact_status"] = $status;
                    }
            }
            $contact->setStatus($row['client_contact_status']);
            $row["client_contact_email"] = $client_email;
            $contact->setEmail($row['client_contact_email']);
            $contact->setEmailTimeout($row['email_timeout']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            $contact->setAssocManager($row['assoc_manager_id']);
            $contact->setAssocUser($row['assoc_user_id']);
            array_push($listofcontactsforcompany,$contact);
        }
$stmt->close();
return $listofcontactsforcompany;
}
//BDE CLIENT SERVICE
public function addClientContact($contact){
    $firstName = $contact->getFirstName();
    $lastName = $contact->getLastName();
    $email = $contact->getEmail();
    $category = $contact->getCategory();
    $designation = $contact->getDesignation();
    $mobile = $contact->getMobile();
    $city = $contact->getCity();
    $state = $contact->getState();
    $country = $contact->getCountry();
    $address = $contact->getAddress();
    $linkedIn = $contact->getLinkedIn();
    $facebook = $contact->getFacebook();
    $twitter = $contact->getTwitter();
    $status = "New";
    if(function_exists('date_default_timezone_set')) 
    {
    date_default_timezone_set("Asia/Kolkata");
    $php_timestamp_date = date("Y-m-d H:i:s");
  
    }
    $added = $php_timestamp_date;
    $companyId = $contact->getCompany();
    $userId = $_SESSION['userId'];
    $stmt_manager = $this->connection->prepare("select user_manager_id,user_emp_id from users where user_id = ?");
    $stmt_manager->bind_param("i", $userId);
    $stmt_manager->execute();
    $res_manager = $stmt_manager->get_result();
    $row_manager = $res_manager->fetch_object();
    $assocManager = $row_manager->user_manager_id;
    $assocUser = $row_manager->user_emp_id;
    $emailTimeout = 24;
    $stmt = $this->connection->prepare("insert into client_contacts (client_contact_first_name, client_contact_last_name, client_contact_email, client_contact_category, client_contact_designation, client_contact_mobile, city_id, state_id, country_id, client_contact_address, client_contact_linkedin, client_contact_facebook, client_contact_twitter, client_contact_status, client_contact_added, client_company_id, assoc_manager_id, assoc_user_id, email_timeout) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssiiiissssssiiis", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $status, $added, $companyId, $assocManager, $assocUser, $emailTimeout);
    $stmt->execute();
    $stmt->close();
}

public function addclientwithcompany($company,$contact){
        $companyName = $company->getName();
        $companyWebsite = $company->getWebsite();
        $companyAddress = $company->getAddress();
        $companyPhone = $company->getPhone();
        $companyEmail = $company->getEmail();
        $companyLinkedIn = $company->getLinkedIn();
        $userId = $_SESSION['userId'];
        $stmt_manager = $this->connection->prepare("select user_manager_id,user_emp_id from users where user_id = ?");
        $stmt_manager->bind_param("i", $userId);
        $stmt_manager->execute();
        $res_manager = $stmt_manager->get_result();
        $row_manager = $res_manager->fetch_object();
        $assocManager = $row_manager->user_manager_id;
        $assocUser = $row_manager->user_emp_id;
        $this->connection->query("lock tables client_companies write");
        $stmt_website = $this->connection->prepare("select distinct client_company_website from client_companies");
        $stmt_website->execute();
        $res_website = $stmt_website->get_result();
        
        $stmt = $this->connection->prepare("insert into client_companies (client_company_name, client_company_website, client_company_address, client_company_phone, client_company_email, client_company_linkedin, assoc_manager_id, assoc_user_id) values (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissii", $companyName, $companyWebsite, $companyAddress, $companyPhone, $companyEmail, $companyLinkedIn, $assocManager, $assocUser);
        $stmt->execute();
        $query = $this->connection->query("select max(client_company_id) from client_companies");
        $this->connection->query("unlock tables");
        $max_client_company_id = $query->fetch_assoc()['max(client_company_id)'];
        //inserting client
        $firstName = $contact->getFirstName();
        $lastName = $contact->getLastName();
        $email = $contact->getEmail();
        $category = $contact->getCategory();
        $designation = $contact->getDesignation();
        $mobile = $contact->getMobile();
        $city = $contact->getCity();
        $state = $contact->getState();
        $country = $contact->getCountry();
        $address = $contact->getAddress();
        $linkedIn = $contact->getLinkedIn();
        $facebook = $contact->getFacebook();
        $twitter = $contact->getTwitter();
        $status = "New";
        if(function_exists('date_default_timezone_set')) 
        {
        date_default_timezone_set("Asia/Kolkata");
        $php_timestamp_date = date("Y-m-d H:i:s");                       
        }
        $added = $php_timestamp_date;
        $stmt_company = $this->connection->prepare("select client_company_id from client_companies where client_company_website= ?");
        $stmt_company->bind_param("s", $companyWebsite);
        $stmt_company->execute();
        $res_company = $stmt_company->get_result();
        $row_company = $res_company->fetch_object();

        $companyId = $contact->getCompany();
        $userId = $_SESSION['userId'];
        $emailTimeout = 24;
        $stmt = $this->connection->prepare("insert into client_contacts (client_contact_first_name, client_contact_last_name, client_contact_email, client_contact_category, client_contact_designation, client_contact_mobile, city_id, state_id, country_id, client_contact_address, client_contact_linkedin, client_contact_facebook, client_contact_twitter, client_contact_status, client_contact_added, client_company_id, assoc_manager_id, assoc_user_id, email_timeout) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssiiiissssssiiis", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $status, $added, $max_client_company_id, $assocManager, $assocUser, $emailTimeout);
        $stmt->execute();
        $stmt->close();  
    }


public function fetchclientdata($userId,$offset){
        $limit = CONTACT_LIST_LIMIT;
        $stmt_client = $this->connection->prepare("select user_emp_id from users where user_id = ?");
        $stmt_client->bind_param("i", $userId);
        $stmt_client->execute();
        $res_client = $stmt_client->get_result();
        $row_client = $res_client->fetch_object();
        $userEmpId  = $row_client->user_emp_id;
        $stmt = $this->connection->prepare("select * from client_contacts where assoc_user_id =? limit ? ,?");
        $stmt->bind_param("iii",$userEmpId,$offset,$limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listofcontacts= array();
        while($row = $res->fetch_assoc()) {
            $contact = new Contact();
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            $contact->setAssocManager($row['assoc_manager_id']);
            $contact->setAssocUser($row['assoc_user_id']);
            $contact->setEmailTimeout($row['email_timeout']);
            array_push($listofcontacts,$contact);
        }
        $stmt->close();
        return $listofcontacts;
    }  

    public function updateContactsByContactId($clientId,$contact){

            $id = $contact->getId();
            $firstName = $contact->getFirstName();
            $lastName = $contact->getLastName();
            $email = $contact->getEmail();
            $category = $contact->getCategory();
            $designation = $contact->getDesignation();
            $mobile = $contact->getMobile();
            $city = $contact->getCity();
            $state = $contact->getState();
            $country = $contact->getCountry();
            $address = $contact->getAddress();
            $linkedIn = $contact->getLinkedIn();
            $facebook = $contact->getFacebook();
            $twitter = $contact->getTwitter();
            $stmt = $this->connection->prepare("update client_contacts set client_contact_first_name = ?, client_contact_last_name = ?, client_contact_email = ?, client_contact_category = ?, client_contact_designation = ?, client_contact_mobile = ?, city_id = ?, state_id = ?, country_id = ?, client_contact_address = ?, client_contact_linkedin = ?, client_contact_facebook = ?, client_contact_twitter = ? where client_contact_id = ?");
            $stmt->bind_param("sssssiiiissssi", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $id);
            $stmt->execute();
            if($stmt == true){
                return true;
            }else{
                return false;
            }
            $stmt->close();

    }


    public function setContactDetailsFromCsv($companyId,$csv_contacts){
        
    }


}
?>

