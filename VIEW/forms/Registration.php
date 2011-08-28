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
        $this->element("username", "Username", "required");
        $this->elementHTML("username", $this->input("username"));
        
        $this->element("passwd","Password", "required");
        $this->elementHTML("passwd", $this->input("passwd", "password"));
        
        $this->element("passwd2","Retype password", "equals,passwd");
        $this->elementHTML("passwd2", $this->input("passwd2", "password"));
        
        $this->element("email", "Email", "email");
        $this->elementHTML("email", $this->input("email"));
        
        $this->element("sex","Sex");
        $options = array(
            "Male" => "male",
            "Female" => "female"
        );
        $this->elementHTML("sex", $this->select("sex", $options));
        
    }
}

?>
