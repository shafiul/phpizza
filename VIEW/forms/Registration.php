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
        // URL where form processing will be done!
        $this->action = url('registration/submit');
        // Do some CSS tweaking!
        $this->submitButtonText = "Register!";
        $this->tableCellSpacing = "10px";
        // Create some validators to be applied on User submitted data.
        $this->validators =array(
            'username' => array('Username', "limit,5,7"),
            'passwd' => array('Password', 'required|limit,,2'),
            'passwd2' => array('Retype password', 'equalsToElement,passwd'),
            'email' => array('Email', 'limit,3|email'),
            'sex' => array('Sex', 'enum,male:female')
        );
        
    }
    
    public function createElements() {
        
        $elements = array();
        
        $elements['username'] = form_input();
        $elements['passwd'] = form_password();
        $elements['passwd2'] = form_password();
        $elements['email'] = form_input();
        
        $options = array(
            "male" => "Male",
            "female" => "Female"
        );
        
        $elements['sex'] = form_dropdown($options, 'female');
        
        $this->setElements($elements);
    }
}
?>