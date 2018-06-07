<?php



class DatabaseManager {



    private  $connection;

    private  $db_name;

	private  $db_user;

	private  $db_pass;

    private  $db_host;



    function __construct() {

        $this->connection = false;

        $this->db_name = 'pnrpoint_sengine_version1';

        $this->db_user = 'root';

        $this->db_pass = '';

        $this->db_host = 'localhost';

    }

    

    public function getConnection() {

        if (!$this->connection) {

            $this->connection = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        }

        return $this->connection;

    }

}



?>