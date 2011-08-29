<?php

/* Common MySQL usage class
  Author: Shafiul Azam
  ishafiul@gmail.com
 * Version: 1.0
 * Status: Development, buggy
 */

class MySQL extends GenericDB{
    
    public function __construct() {
        // connect!
        $this->connect();
    }
    
    public function setError() {
        $this->errorNo = mysql_errno($this->connectionID);
        $this->errorMsg = mysql_error($this->connectionID);
    }
    
    public function connect() {
        $this->connectionID = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
        if(!$this->connectionID){
            $this->errorNo = 0;
            $this->errorMsg = "Connection Failed!";
            $this->debug();
            echo "Database Error! For more information, set DEBUG on";
            exit();
        }
        if(DB_DATABASE && !mysql_select_db(DB_DATABASE, $this->connectionID)){
            $this->setError();
            $this->debug();
            echo "Database Error! For more information, set DEBUG on";
            exit();
        }
        return $this->connectionID;
    }
    
    public function insertArray($columnToEncrypt = "", $valueToEncrypt = "") {
        $table = $this->table;
        $fields = $values = array();

        foreach ($this->data as $key => $val) {
            $fields[] = "`$key`";
            $values[] = "'" . mysql_real_escape_string($val) . "'";
        }

        $fields = implode(",", $fields);
        $values = implode(",", $values);
        // Check for password types
        if ($columnToEncrypt && $valueToEncrypt) {
            $fields = $fields . ", $columnToEncrypt";
            $values = $values . ", " . $this->encryptionFunction . "('$valueToEncrypt')"; // stored using secured hash algorithm
        }
        $this->query = "INSERT INTO `$table` ($fields) VALUES ($values)";
        $result = mysql_query($this->query);
//        $this->debug();
        if ($result) {
            return mysql_insert_id();
        } else {
            return false;
        }
    }
    
    public function updateArraySingleIdentifier($identifier_column, $identifier_value) {
        $fields = $values = array();
        $this->query = "UPDATE `" . $this->table . "` SET ";
        foreach (array_keys($this->data) as $key) {
            $this->query .= "`$key` = ";
            $this->query .= "'" . mysql_real_escape_string($this->data[$key]) . "', ";
        }
        $this->query = substr($this->query, 0, strlen($this->query) - 2);
        $this->query .= " WHERE `$identifier_column` = '" . $identifier_value . "'";
        $result = mysql_query($this->query);
        $this->debug();
        return $result;
    }
    
    public function updateArray() {
        $fields = $values = array();
        $this->query = "UPDATE `" . $this->table . "` SET ";
        foreach (array_keys($this->data) as $key) {
            $this->query .= "`$key` = ";
            $this->query .= "'" . mysql_real_escape_string($this->data[$key]) . "', ";
        }
        $this->query = substr($this->query, 0, strlen($this->query) - 2);
        if($this->identifier){
            $this->query .= " WHERE ";
            $where = array();
            foreach ($this->identifier as $k => $v) {
                $where[] = "`$k` = '" . mysql_real_escape_string($v) . "'";
            }
            $this->query .= implode(" " . $this->joiner . " ", $where);
        }
        
        $this->query .= " " . $this->rest;
        $result = mysql_query($this->query);
        $this->debug();
        return $result;
    }
    
    public function selectArray() {
        $this->query = "SELECT ";
        if (!$this->select) {
            $this->query .= "*";
        } else {
            $this->query .= "`" . implode($this->select, "` , `") . "`";
        }
        $this->query .= " FROM `" . $this->table . "`";
        if ($this->identifier) {
            $this->query .= " WHERE ";
            $sqll = "";
            foreach ($this->identifier as $key => $i) {
                $sqll[] = "`$key` = '" . mysql_real_escape_string($i) . "'";
            }
            $this->query .= implode($sqll, " " . $this->joiner . " ");
        }
        if ($this->rest)
            $this->query .= " " . $this->rest;
        $result = mysql_query($this->query);
//        $this->debug();
        if ($this->returnPointer) {
            // Return link to resources
            return $result;
        } else {
            // Return only the first result
            return mysql_fetch_array($result);
        }
    }
    
    public function delete() {
        // Must provide an identifier. 
        if(!$this->identifier)
            return false;
        $this->query = "DELETE FROM `" . $this->table . "` WHERE";
        $where = array();
        foreach($this->identifier as $k=>$v){
            $where[] = "`$k` = '" . mysql_real_escape_string($v) . "'";
        }
        $this->query .= implode($this->joiner, $where) . $this->rest;

        $result = mysql_query($this->query);
        $this->debug();
        return $result;
    }
    
    
    public function numAffectedRows() {
        return mysql_affected_rows();
    }
    
    public function numReturnedRows() {
        return mysql_num_rows($result);
    }


    function time_sqlTime2unix($sqltime) {
        return strtotime($sqltime . " GMT");
    }

    function time_unix2sqlTime($unixtime) {
        return gmdate("Y-m-d H:i:s", $unixtime);
    }
    
    // Utility
    
    public function clear() {
        $this->select = null;
        $this->data = null;
        $this->identifier = null;
        $this->rest = "";
        $this->returnPointer = true;
        $this->joiner = "AND";
        $this->query = "";
    }
    
}
?>
