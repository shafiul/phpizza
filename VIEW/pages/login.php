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
        $this->title  = "Demo Login form";
    }
    
    function mainContent() {
        
        // Uncomment following to manually present the Form
//        $errors = $this->formError;
//        if(!empty($errors)){
//            echo "<font color='red'>$errors</font> <br /><br />";
//        }
//        echo $this->loginForm;
        // Or, use following function to do all these!
        echo $this->form("Login");
    }
}


?>
