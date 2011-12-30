<?php

/**
 * \brief A fundamental model class. You extend this class in your MODELS
 * 
 * @author Shafiul Azam
 */

class CoreModel {
    public $core;
    public $db;        ///<    object for database
    
    /**
     * You should call this function as the first line within your MODEL class's constructor.
     * 
     * Loads your favorite database driver.
     * 
     * Load database driver. They are not automatically loaded to prevent un-necessary loading 
     * since you do not perform database functionality everywhere
     */
    
    public function __construct($core) {
        $this->core = $core;
        $this->db = $core->getDb();
    }
    
    /**
     * @name Useful functions for Models
     */
    
    //{
    
    /**
     * Handy function to insert some data in database along with a "password" field. 
     * Password field will be stored encrypted in your database.
     * @param mixed $data - key-value pair of "database column name" as key & "data to insert" as value.
     * @param string $passwordColumn - name of database column where password will be stored
     * @param string $passwordValue - data to insert in password column.
     * @return type 
     */
    
    public function insertWithPassword($data,$passwordColumn,$passwordValue){
        $this->db->data = $data;
        return $this->db->insertArray($passwordColumn, $passwordValue);
    }
    
    /**
     * Handy function to insert some data in database
     * @param mixed $data - key-value pair of "database column name" as key & "data to insert" as value.
     * @return type 
     */
    
    public function insert($data){
        $this->db->data = $data;
        return $this->db->insertArray();
    }
    
    
    /**
     * Handy function to update data in Database.
     * @param mixed $data - key-value array.
     * @param mixed $identifier - key-value array. This array sets the "WHERE" parameters of query.
     * @return type 
     */
    
    public function update($data,$identifier){
        $this->db->data = $data;
        $this->db->identifier = $identifier;
        return $this->db->updateArray();
    }
    
    
    /**
     * Handy function to check if data set as $identifierArr already exists in Database.
     * @param mixed $identifierArr - key-value array.
     * @param array $selectArr - Value to be used in "SELECT" part in query.
     * @return type 
     */
    
    public function ifExist($identifierArr,$selectArr=null){
        if(!isset ($selectArr))
            $selectArr = array_keys($identifierArr);
        $this->db->select = $selectArr;
        $this->db->identifier = $identifierArr;
        $this->db->returnPointer = false;
        return $this->db->selectArray();
    }
    
    
    /**
     * Does not insert if data already exists in database
     */
    
    public function insertOnce($data,$identifier){
        if($this->ifExist($identifier,$identifier))
            return -1;
        else{
//            $this->db->clear();
            return $this->insert($data);
        }
    }
    
    /**
     * If $data already exists in Database, update it, or inset as new Data
     * @param type $data
     * @param type $identifier
     * @return type 
     */
    
    public function insertOrUpdate($data, $identifier){
        if($this->ifExist($identifierArr)){
            // Update
            return $this->update($data, $identifier);
        }else{
            // Create New
            return $this->insert($data);
        }
    }

    /**
     * Returns a pointer to array. You should use mysql_fetch_array() 
     * @param type $identifierArr
     * @param type $selectArr
     * @return type 
     */

    public function getAll($identifierArr = null, $selectArr = null){
//        $this->db->clear();
        $this->db->identifier = $identifierArr;
        $this->db->select = $selectArr;
        return $this->db->selectArray();
    }
    
    /**
     * Only the first row. Returns key-value pair array of data.
     * @param type $identifierArr
     * @param type $selectArr
     * @return type 
     */
    
    public function get($identifierArr = null, $selectArr = null){
//        $this->db->clear();
        $this->db->returnPointer = false;
        $this->db->identifier = $identifierArr;
        $this->db->select = $selectArr;
        return $this->db->selectArray();
    }


    public function delete($identifierArr){
        $this->db->identifier = $identifierArr;
        return $this->db->delete();
    }



    //}
}

?>