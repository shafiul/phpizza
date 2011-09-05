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
        $this->title  = "Demo Login form";
    }
    
    function mainContent() {
        global $core;
        // Uncomment following to manually present the Form
//        $errors = $core->getData("formError");
//        if(!empty($errors)){
//            echo "<font color='red'>$errors</font> <br /><br />";
//        }
//        echo $core->getData("loginForm");
        // Or, use following function to do all these!
        echo $core->getForm("Login");
    }
}


?>
