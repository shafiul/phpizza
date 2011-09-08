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

class View extends Template{
    function __construct($core) {
        // Must call parent's constructor
        parent::__construct($core);
        $this->title = "Registration";
    }
    
    function mainContent() {
        
        echo $this->core->getForm("Registration");
    }
}


?>
