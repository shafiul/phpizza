<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager, 
 *              :   PROGmaatic Developer Network
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

/**
 * \define a demonstration-purpose model
 * 
 * Your class must extend CustomModel
 * @author Shafiul Azam
 */


class RegistrationModel extends CustomModel{
    
    /**
     * Constructor must call parent's constructor
     */
    
    public function __construct() {
        // Must call parent's constructor
        parent::__construct();
        // Initialize database object
        $this->db = new MySQL();
        // apply some common settings
        $this->db->table = "user";
    }
    
    /**
     * Demo function which inserts some values to database 
     */
    
    public function insert($arrToInsert, $passValue){
        $this->db->data = $arrToInsert;
        return $this->db->insertArray("password", $passValue);
    }
    
    public function getDB(){
        // Get a reference of the $db object. Can be harmful???
        return $this->db;
    }
    
}

?>
