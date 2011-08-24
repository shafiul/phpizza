<?php

class MySQL extends GenericDB{
    
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
    
    public function insertArray($password_key = "", $password_value = "") {
        $table = $this->table;
        $fields = $values = array();

        foreach ($this->data as $key => $val) {
            $fields[] = "`$key`";
            $values[] = "'" . mysql_real_escape_string($val) . "'";
        }

        $fields = implode(",", $fields);
        $values = implode(",", $values);
        // Check for password types
        if ($password_key && $password_value) {
            $fields = $fields . ", $password_key";
            $values = $values . ", " . $this->encryptionFunction . "('$password_value')"; // stored using secured hash algorithm
        }
        $this->query = "INSERT INTO `$table` ($fields) VALUES ($values)";
        $this->debug();
        if (mysql_query($this->query)) {
            return mysql_insert_id();
        } else {
            return false;
        }
    }
    
}
?>
