<?php
// Used to get mysql database connection:
class Database{

    // Specify your database credentials:
    private $host = "localhost";
    private $db_name = "databasename";
    private $username = "databaseusername";
    private $password = "databasepassword";
    public $conn;

    // Create database connection:
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}
?>