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
        $this->data('title', "Title set via constructor.");
    }
    
    public function index(){
        $this->data('title',"PHPizza Running :-P");
        $this->loadView();
    }
    
    public function demo(){
        // This function is called when you access BASE_URL/index/demo in a browser

        $this->data('title',"Title set via demo function.");
        $this->loadView();
    }
}


?>
