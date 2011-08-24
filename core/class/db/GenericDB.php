<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


abstract class GenericDB{
    
    public $table;  // Name of the table
    public $data;   //  Key-value pair of Data
    public $identifier; // Key-value pair of identifier: in where clause
    public $encryptionFunction = "SHA";
    public $errorNo;
    public $errorMsg;
    public $query;
    public $rest;   //  Additional query
    public $joiner; // joiner (AND/OR) in where clause
    public $returnPointer;  // Return pointer/single data from selectArray
    
    public $connectionID;
    
    public function __construct() {
        // Load Configuration
        require_once dirname(__FILE__) . "/../../../config/database.php";
        // Others
        $this->joiner = "AND";
        $this->returnPointer = true;
    }
    
    
    // Functions to implement
    
    abstract public function connect();
    abstract public function insertArray($password_key="", $password_value="");
    abstract public function updateArray();
    abstract public function selectArray($selectArr);
    abstract public function delete();
    
    abstract public function setError();
    
    // Implemented utility functions
    
    public function debug(){
        if(DB_DEBUG_MODE_ON){
            $this->setError();
            echo "<PRE>";
            echo "Query: " . $this->query;
            echo "<br />Error: " . $this->errorNo . " " . $this->errorMsg;
            echo "</PRE> <br />";
        }
    }
}

?>
