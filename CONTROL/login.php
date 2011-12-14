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


class Controller extends CoreController{
    
    public $form;
    
    public function __construct($core) {
        // Call parent's constructor. 
        parent::__construct($core);
        if(! ($this->form = $this->loadForm('Login')))
            $this->funcs->kill("Cannot load form");
    }
    
    public function index(){
        // Generate a login form.
        // You can use following commented code to MANUALLY send the form to VIEW class.
        
//        $this->data("loginForm",  $this->form->sendToView(true));
        // Or, call the following function (with no argument) to automatically 
        // pass form's generated %html & validation errors to your View classes:
        $this->form->sendToView();
        $this->loadView();
    }
    
    public function submit(){
        // When form submitted, this function runs. This was set by
        // setting the "action" variable of the Form class.
        
        if($this->form->validate()){
            // Form Validated
            echo "Form Valid! <br />";
            // Print all submitted values
            foreach($this->form->getAll() as $key=>$value)
                echo "$key: $value <br />";
            echo "<br />" . anchor("login", "&laquo; Back");
            exit();
        }else{
            // You can uncomment following codes to MANUALLY pass error message.
//            $this->data("formError", $this->form->error);
            $this->index();
        }
        
    }
}

?>
