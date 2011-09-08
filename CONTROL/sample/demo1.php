<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Just passing some variables to access from VIEW

class Controller extends CoreController{
    
    function __construct($core) {
        // Call parent's constructor. 
        parent::__construct($core);
        $this->core->setData("mainContent","<h1>This content was set from constructor function!</h1>");
    }
    
    function index(){
        
        $this->core->setData("mainContent","<h1>This content was set from index function!</h1>");
        $this->core->loadView();
    }
}

?>
