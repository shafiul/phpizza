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

class View extends CustomView{
    function __construct() {
        $this->title  = "Demo Login form";
    }
    
    function printMainPageContent() {
        global $core;
        // Check if errors exist
        $errors = $core->getData("formError");
        if(!empty($errors)){
            echo "$errors <br /><br />";
        }
        echo $core->getData("loginForm");
    }
}


?>
