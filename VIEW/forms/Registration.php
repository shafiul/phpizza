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

class Registration extends CoreForm {
    public function __construct($core) {
        // MUST call parent's constructor
        parent::__construct($this, $core);
        $this->action = url('registration/submit');
        $this->submitButtonText = "Register!";
        $this->tableCellSpacing = "10px";
    }
    
    public function createElements() {
        
        $elements = array();
        
        $elements['username'] = array("Username","limit,5,7","input");
        
        $elements['passwd'] = array("Password", "required|limit,,2", "input", array("password"));
        
        $elements['passwd2'] = array("Retype password", "equalsToElement,passwd", "input", array("password"));
        
        $elements['email'] = array("Email", "limit,3|email", "input");
        
        $options = array(
            "Male" => "male",
            "Female" => "female"
        );
        
        $elements['sex'] = array("Sex","enum,male:female", "select", array($options, "female"));
        
        $this->setElements($elements);
    }
}
?>