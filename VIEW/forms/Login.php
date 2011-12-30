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
        
        // Set some validators
        
        $this->validators = array(
            'email' => array('Email', 'email'),
            'passwd' => array('Password', 'required|htmlspecialchars'),
            'comment' => array('Comment (optional)', 'htmlspecialchars')
        );
        
    }
    
    function createElements(){
        // This function should be present
        // 
        // Generate form elements
        $elements = array();
        
        $elements['email'] = form_input();
        $elements['passwd'] = form_password();
        $elements['comment'] = form_textarea('Dummy Text', array('rows' => 5));
        
        $this->setElements($elements);
    }
    
    
    
}

?>
