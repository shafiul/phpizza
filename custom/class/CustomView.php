<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CustomView extends CoreView{
    
    public function __construct() {
        // Must pass data to parent's constructor
        parent::__construct();
    }
    
    // Functions to implement in your views
    
    // Page's main entry
    abstract public function printMainPageContent();
}

?>
