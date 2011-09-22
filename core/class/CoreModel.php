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
    }
    
    /**
     * @name Useful functions for Models
     */
    
    //{
    
    
    public function insertWithPassword($data,$passwordColumn,$passwordValue){
        $this->db->data = $data;
        return $this->db->insertArray($passwordColumn, $passwordValue);
    }
    
    public function insert($data){
        $this->db->data = $data;
        return $this->db->insertArray();
    }
    
    public function update($data,$identifier){
        $this->db->data = $data;
        $this->db->identifier = $identifier;
        return $this->db->updateArray();
    }
    
    public function ifExist($identifierArr,$selectArr=null){
        if(!isset ($selectArr))
            $selectArr = array('id');
        $this->db->select = $selectArr;
        $this->db->identifier = $identifierArr;
        $this->db->returnPointer = false;
        return $this->db->selectArray();
    }
    
    
    /**
     * Does not insert if already exists in database
     */
    
    public function insertOnce($data,$identifier){
        if($this->ifExist($identifier,$identifier))
            return -1;
        else{
//            $this->db->clear();
            return $this->insert($data);
        }
    }
    
    public function selectAll($identifierArr = null, $selectArr = null){
//        $this->db->clear();
        $this->db->identifier = $identifierArr;
        $this->db->select = $selectArr;
        return $this->db->selectArray();
    }






    //}
}

?>
