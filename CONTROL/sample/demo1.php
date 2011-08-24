<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Just passing some variables to access from VIEW

class Controller{
    
    function __construct() {
        global $core;
        $core->setData("mainContent","<h1>This content was set from constructor function!</h1>");
    }
    
    function index(){
        global $core;
        $core->setData("mainContent","<h1>This content was set from index function!</h1>");
    }
}

?>
