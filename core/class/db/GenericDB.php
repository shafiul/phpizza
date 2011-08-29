<?php

/**
 * \define Abstract Database class. All Database driver classes must implement it.
 * 
 * @author Shafiul Azam
 */


abstract class GenericDB{
    
    public $table = "";  ///< Name of the table (schema) on which db operation will take place
    public $data = null;   ///<  Key-value pair of Data to insert/update
    public $identifier = null; ///< Key-value pair of identifier to be used after WHERE clause (i.e. $identifier["username"] => "giga" is for WHILE `username` = 'giga')
    public $encryptionFunction = "SHA"; ///< Name of the encryption function to apply on $valueToEncrypt in insertArray()
    public $errorNo;    ///<    Error number, if error occurs
    public $errorMsg;   ///<    Descriptive error message, if occurs
    public $query = ""; ///<    generated query
    public $rest = "";   ///<  Additional query to append after $query
    public $joiner = "AND"; ///<    joiner (AND/OR) for WHERE clause
    public $returnPointer = true;  ///<     Return pointer/single data from selectArray
    public $select = null;  ///<    Array, entries denote which columns will be selected in selectArray()
    public $connectionID = null;    ///<    Connection identifier after successful database connection
    
    
    // Functions to implement
    
    /**
     * First function before all other functions can be called, to establish the database connection.
     */
    abstract public function connect();
    /**
     * Inserts $this->data to schema $this->table. You can encrypt some column's value by using the optional parameters
     * @param "string" $columnToEncrypt name of the column whose value will be encrypted
     * @param "string" $valueToEncrypt this value will be encrypted using $this->encryptionFunction function and stored in $columnToEncrypt column
     */
    abstract public function insertArray($columnToEncrypt="", $valueToEncrypt="");
    /**
     * Updates $this->data to database schema $this->table, WHERE $this->identifier are joined by $this->joiner followed by $this->rest
     */
    abstract public function updateArray();
    /**
     * SELECTS $this->select from schema $this->table WHERE $this->identifier are joined by $this->joiner followed by $this->rest
     */
    abstract public function selectArray();
    /**
     * DELETE row(s) from schema $this->table WHERE $this->identifier are joined by $this->joiner followed by $this->rest
     */
    abstract public function delete();
    
    // utility
    
    /**
     * Clears class variables/sets to default values. You should call this function after all 
     *  database query functions.
     */
    abstract public function clear();   //  Clean up member variables

    // Status Related
    
    /**
     * Number of returned rows after selectArray()
     */
    abstract public function numReturnedRows();
    /**
     * Number of affected rows after insertArray(), updateArray() or delete()
     */
    abstract public function numAffectedRows();
    // Knowing about Error
    
    /**
     * Internal function, to set errors (if any occured)
     */
    abstract public function setError();
    
    // Implemented utility functions
    
    /**
     * Function for debuggin. First finds if any occured by setError() then prints the error 
     * if DB_DEBUG_MODE_ON constant is set true.
     */
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
