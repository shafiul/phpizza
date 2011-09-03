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
        $this->form = new Login($core);
    }
    
    public function index(){
        // Generate a login form.
        // You can use following commented code to manually send the form to VIEW.
        global $core;
//        $core->setData("loginForm",  $this->form->create());
        // Or, use built-in function!
        $this->form->sendToView();
        $core->loadView();
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
            foreach($this->form->getAll() as $key=>$value)
                echo "$key: $value <br />";
            echo "<br />" . anchor("login", "&laquo; Back");
            exit();
        }else{
            // You can uncomment following codes to manually resubmit the form & show error message.
//            $core->setData("formError", $result[1]);
//            $core->setData("loginForm",  $result[2]);
            // Or, you can do this automatically:
            $this->form->resubmit();
            $core->loadView();
        }
        
    }
}

?>
