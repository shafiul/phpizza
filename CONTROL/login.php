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
        if(!$this->core->loadForm('Login', $this->form))
            $this->core->funcs->messageExit("Cannot load form");
    }
    
    public function index(){
        // Generate a login form.
        // You can use following commented code to manually send the form to VIEW.
        
//        $this->core->setData("loginForm",  $this->form->create());
        // Or, use built-in function!
        $this->form->sendToView();
        $this->core->loadView();
    }
    
    public function submit(){
        // When form submitted, this function runs. This was set by
        // setting the "action" variable of the Form class.
        
        $result = $this->form->validate();
        if($this->form->isSubmissionValid()){
            // Form Validated
            echo "Form Valid! <br />";
            // Print all submitted values
            foreach($this->form->getAll() as $key=>$value)
                echo "$key: $value <br />";
            echo "<br />" . anchor("login", "&laquo; Back");
            exit();
        }else{
            // You can uncomment following codes to manually resubmit the form & show error message.
//            $this->core->setData("formError", $result[1]);
//            $this->core->setData("loginForm",  $result[2]);
            // Or, you can do this automatically:
            $this->form->resubmit();
            $this->core->loadView();
        }
        
    }
}

?>
