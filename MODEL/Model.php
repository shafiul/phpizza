<?php

/** * ***** ****** ****** ****** ****** ******
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
 * A Generic Model class!
 */

class Model extends CoreModel{
    
    public function __construct($core) {
        parent::__construct($core);
        $this->db->table = "";
    }
}

?>
