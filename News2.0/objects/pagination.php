<?php

// 'Pagination' object class:
class Pagination {

    // Database connection and table name:
    private $conn;
    private $table_name = "a_news";

    // Object properties:
    public $rowsperpage = 20;
    public $range = 10;


    // Constructor:
    public function __construct($db){
        $this->conn = $db;
    }


    /* Method to get the total news entries from database. */
    public function getTotalRows() {

        // Get all entries:
        $query = "SELECT * FROM " . $this->table_name. "";

        // Prepare the query for database execution:
        $stmt = $this->conn->prepare($query);

        // Execute the query:
        $stmt->execute();

        // Get the total number/rows of news entries:
        $totalrows = $stmt->rowCount();

        return $totalrows;

    }


    /* Method to return total pages to base the pagination on. */
    public function getTotalPages($numrows, $rowsperpage) {

        $totalpages = ceil($numrows / $rowsperpage);

        return $totalpages;
    }


    /* Method to check that you cannot navigate beyond accepted page ranges. */
    public function checkPageRange($currentpage, $totalpages, $rowsperpage) {

        // If we are trying to navigate past last page:
        if ($currentpage > $totalpages)
            // Set current page to total pages/last page:
            $currentpage = $totalpages;

        // If we are trying to navigate before first page:
        if ($currentpage < 1)
            // Set current page to first page:
            $currentpage = 1;

        // The offset of the list, based on current page:
        $offset = ($currentpage - 1) * $rowsperpage;

        return $offset;

    }


    /* Getter for object property 'rowsperpage'. */
    public function getRowsPerPage() {

        return $this->rowsperpage;
    }

    /* Setter for object property 'rowsperpage'. */
    public function setRowsPerPage($rowsperpage) {

        $this->rowsperpage = $rowsperpage;

        return $this->rowsperpage;
    }

    /* Getter for object property 'range' - number links to show. */
    public function getRangeNumber() {

        return $this->range;
    }

    /* Setter for object property 'range'. */
    public function setRangeNumber($range) {

        $this->range = $range;

        return $this->range;
    }

} // End class.