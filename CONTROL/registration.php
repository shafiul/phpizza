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
    
    private $form;
    
    function __construct() {
        global $core;
        $core->loadForm("Registration");
        $this->form = new Registration($core);
    }
    
    function index(){
        $this->form->sendToView();
    }
    
    function submit(){
        global $core;
        $result = $this->form->validate($core);
        if($result[FORM_RESULT]){
            // form valid
        }else{
            // form invalid
            $this->form->resubmit();
        }
    }
}

?>
