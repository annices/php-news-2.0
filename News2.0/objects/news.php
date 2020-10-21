<?php

// 'News' object class:
class News {

    // Database connection and table name:
    private $conn;
    private $table_name = "a_news";

    // Object properties:
    public $id;
    public $subject;
    public $created;
    public $entry;

    // Constructor:
    public function __construct($db){
        $this->conn = $db;
    }


    /* Method to create a news record. */
    function createNews() {

        // Create query to fetch entries from database:
        $query = "INSERT INTO " . $this->table_name . "
        SET
        subject = :subject,
        created = :created,
        entry = :entry";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Sanitize:
        $this->subject=htmlspecialchars(strip_tags($this->subject));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->entry=$this->entry;

        // Bind values from properties to database attributes:
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':created', $this->created);
        $stmt->bindParam(':entry', $this->entry);

        // Execute the query and check if query was successful:
        if($stmt->execute()){

            return true;

            // Close database connection when done:
            $this->connection = null;
        }
        return false;
    }


    /* Method to get a news record by its ID for editing/updating purpose. */
    public function getNewsById() {

        // Query to check if record ID exists:
        $query = "SELECT id, subject, created, entry
        FROM " . $this->table_name . "
        WHERE id = ?
        LIMIT 0,1";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare( $query );

        // Sanitize:
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Bind given username value ('1' to map from first question mark in query):
        $stmt->bindParam(1, $this->id);

        // Execute the query:
        $stmt->execute();

        // Get the total number of table rows:
        $num = $stmt->rowCount();

        // If there's a row match, assign values to object properties for easy access:
        if($num > 0) {

            // Get record details/values:
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Create DateTime object to use for formatting date as wanted:
            $date = date_create($row['created']);

            // Assign values to object properties:
            $this->id = $row['id'];
            $this->subject = $row['subject'];
            $this->created = date_format($date, 'Y-m-d H:i');
            $this->entry = $row['entry'];           

            return true;

            // Close database connection when done:
            $this->connection = null;
        }
        return false;

    }


    /* Method to update a news record. */
    public function updateNews() {

        // Donnot update the entry if not posted, otherwise do:
        $query = "UPDATE " . $this->table_name . "
        SET
        subject = :subject,
        created = :created,
        entry = :entry
        WHERE id = :id";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Sanitize:
        $this->subject=htmlspecialchars(strip_tags($this->subject));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->entry=$this->entry;

        // Bind values from properties to database attributes:
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':created', $this->created);
        $stmt->bindParam(':entry', $this->entry);

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


    /* Method to get all news records from database. */
    public function getNews($offset, $rowsperpage, $limit) {

        if(!isset($limit)) {
            // Query to fetch the records from database:
            $query = "SELECT id, subject, created, entry
            FROM " . $this->table_name . " ORDER BY created DESC LIMIT $offset, $rowsperpage";
        }
        else {
            // Query to fetch the records from database:
            $query = "SELECT id, subject, created, entry
            FROM " . $this->table_name . " ORDER BY created DESC LIMIT $limit";
        }

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Execute the query:
        $stmt->execute();

        // Fetch all records/rows and put in array:
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the array with all the records:
        return $row;

        // Close database connection when done:
        $this->connection = null;

    }


    /* Method to delete a news record. */
    function deleteNews() {

        // Create delete statement:
        $query = "DELETE FROM " . $this->table_name . "
        WHERE id = :id";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Unique ID of record to be edited:
        $stmt->bindParam(':id', $this->id);

        // Execute the query and check if query was successful:
        if($stmt->execute()){

            return true;

            // Close database connection when done:
            $this->connection = null;
        }
        return false;
    }


    /* Method to validate a date format. */
    public function validateDate($date, $format = 'Y-m-d H:i') {

        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }


} // End class.