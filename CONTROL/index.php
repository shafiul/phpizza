<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   Dummy controller for Index view
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

// Let's set title for demonstration purpose

class Controller{
    
    public function __construct() {
        // General purpose 
        global $core;   // Get instance
        $title = "Title set via constructor.";
        $core->setData('title',$title);
    }
    
    public function index(){
        // This function is called by default, if CONTROLLER_FUNCTION_CALLING is enabled 
        global $core;   // Get instance
        $title = "Title set via index function.";
        $core->setData('title',$title);
    }
    
    public function demo(){
        // This function is called when you access index/demo.html in a browser
        // , if CONTROLLER_FUNCTION_CALLING is enabled 
        global $core;   // Get instance
        $title = "Title set via demo function.";
        $core->setData('title',$title);
    }
}


?>
