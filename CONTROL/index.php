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

class Controller extends CoreController{
    
    public function __construct($core) {
        // Call parent's constructor. 
        parent::__construct($core);
        $title = "Title set via constructor.";
        $this->core->setData('title',$title);
    }
    
    public function index(){
        // This function is called by default, if CONTROLLER_FUNCTION_CALLING is enabled 
           // Get instance
        $title = "Title set via index function.";
        $this->core->setData('title',$title);
        $this->core->loadView();
    }
    
    public function demo(){
        // This function is called when you access index/demo.html in a browser
        // , if CONTROLLER_FUNCTION_CALLING is enabled 
           // Get instance
        $title = "Title set via demo function.";
        $this->core->setData('title',$title);
        $this->core->loadView();
    }
}


?>
