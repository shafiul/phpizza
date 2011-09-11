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

class Login extends CoreForm {
    
    function __construct($core) {
        // MUST call parent's constructor
        parent::__construct($this, $core);
        // Set form properties here.
        $this->action = url("login/submit");
        $this->submitButtonText = "Log In!";
        $this->tableCellSpacing = "10px";
    }
    
    function createElements(){
        // This function should be present
        // 
        // Generate form elements
        $elements = array();
        
        $elements['email'] = array("Email","email","input");
        $elements['passwd'] = array("Password","required|htmlspecialchars","input",array(
            "password"
        ));
        $elements['comment'] = array('Comment (optional)', 'htmlspecialchars',"textarea");
        
        $this->setElements($elements);
    }
    
    
    
}

?>
