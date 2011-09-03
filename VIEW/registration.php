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
    function __construct() {
        // Must call parent's constructor
        parent::__construct();
        $this->title = "Registration";
    }
    
    function mainContent() {
        global $core;
        echo $core->getForm("Registration");
    }
}


?>
