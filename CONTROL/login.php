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


class Controller{
    
    public $form;
    
    public function __construct() {
        global $core;
        if(!$core->loadForm('Login'))
            $core->funcs->messageExit("Cannot load form");
        // Create a form object
        $this->form = new Login();
    }
    
    public function index(){
        // Generate a login form.
        global $core;
        $core->setData("loginForm",  $this->form->create());
    }
    
    public function submit(){
        // When form submitted, this function runs. This was set by
        // setting the "action" variable of the Form class.
        global $core;
        $result = $this->form->validate($core);
        if($result[0]){
            // Form Validated
            echo "Form Valid! <br />";
            // Print all submitted values
            foreach($this->form->submittedData as $key=>$value)
                echo "$key: $value <br />";
            echo "<br /><a href='index.html'>Back</a>";
            exit();
        }else{
            $core->setData("formError", $result[1]);
            $core->setData("loginForm",  $result[2]);
        }
        
    }
}

?>
