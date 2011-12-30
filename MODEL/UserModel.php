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
 * Your class must extend CoreModel
 * @author Shafiul Azam
 */


class UserModel extends CoreModel{
    
    /**
     * Constructor must call parent's constructor
     */
    
    public function __construct($core) {
        // Must call parent's constructor
        parent::__construct($core);
        // Should set name of the table!
        $this->db->table = "user";
    }
    
    function dummy(){
        // I do nothing
    }
    
    
    
    /**
     * Demo function to perform a registration
     * @return  
     */
    
    public function reg($data,$password,$identifier){
        if($this->ifExist($identifier)){
            return false;
        }else{
            return $this->insertWithPassword($data, 'password', $password);
        }
    }
    
}

?>
