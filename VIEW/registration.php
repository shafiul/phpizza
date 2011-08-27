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
        $this->title = "Registration";
    }
    
    function printMainPageContent() {
        global $core;
        echo $core->getForm("Registration");
    }
}


?>
