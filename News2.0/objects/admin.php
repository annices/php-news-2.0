<?php

// 'Admin' object class:
class Admin {

    // Database connection and table name:
    private $conn;
    private $table_name = "a_admin";

    // Object properties:
    public $id;
    public $username;
    public $password;

    // Constructor:
    public function __construct($db){
        $this->conn = $db;
    }


    /* Method to create a an admin user. */
    function createAdmin() {

        // Create an insert query:
        $query = "INSERT INTO " . $this->table_name . "
        SET
        username = :username,
        password = :password";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Sanitize:
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));

        // Bind values from properties to database attributes:
        $stmt->bindParam(':username', $this->username);

        // Hash the password before saving to database:
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        // Execute the query and check if query was successful:
        if($stmt->execute()) {

            return true;

            // Close database connection when done:
            $this->connection = null;
        }
        return false;
    }


    /* Method to get a news record by its ID for editing/updating purpose. */
    public function getAdminId() {

        // Query to check if user record exists:
        $query = "SELECT id, username, password
        FROM " . $this->table_name . "
        WHERE username = ?
        LIMIT 0,1";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Sanitize:
        $this->username=htmlspecialchars(strip_tags($this->username));

        // Bind given username value ('1' to map from first question mark in query):
        $stmt->bindParam(1, $this->username);

        // Execute the query:
        $stmt->execute();

        // Get the total number of table rows:
        $num = $stmt->rowCount();

        // If the username matches a table row, fetch its values to assign to an admin object:
        if($num > 0) {

            // Get record details/values:
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Assign values to object properties:
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];

            return true;

            // Close database connection when done:
            $this->connection = null;
        }
        return false;

    }


    /* Method to update an admin record. */
    public function updateAdmin() {

        // If password needs to be updated:
        $password_set=!empty($this->password) ? ", password = :password" : "";

        // If no posted password, do not update the password:
        $query = "UPDATE " . $this->table_name . "
        SET
        username = :username
        {$password_set}
        WHERE id = :id";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Sanitize:
        $this->username=htmlspecialchars(strip_tags($this->username));

        // Bind the values from properties to database attributes:
        $stmt->bindParam(':username', $this->username);

        // Hash the password before saving to database:
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // Unique ID of record to be edited:
        $stmt->bindParam(':id', $this->id);

        // Execute the query:
        if($stmt->execute()) {

            return true;

            // Close database connection when done:
            $this->connection = null;
        }

        return false;
    }


    /* Method to check valid login. */
    function checkLogin() {

        // Query to check match of unique username:
        $query = "SELECT id, username, password
        FROM " . $this->table_name . "
        WHERE username = ?
        LIMIT 0,1";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare( $query );

        // Sanitize:
        $this->username=htmlspecialchars(strip_tags($this->username));

        // Bind given username value ('1' to map first question mark in query):
        $stmt->bindParam(1, $this->username);

        // Execute the query:
        $stmt->execute();

        // Get the total number of table rows:
        $num = $stmt->rowCount();

        // If username exists, assign values to object properties for easy access:
        if($num > 0) {

            // Get record details/values:
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Assign values to object properties:
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];

            return true;

            // Close database connection when done:
            $this->connection = null;
        }
        return false;
    }

} // End class.