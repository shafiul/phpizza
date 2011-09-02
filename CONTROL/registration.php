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
        $result = $this->form->validate();
        if($result[FORM_RESULT]){
            // form valid. Do some database work!
            // Load the model 
            $core->loadModel('RegistrationModel');
            
            $model = new RegistrationModel();   //  Create object of the default model. Since this is the default model (filename: registration), it was automatically loaded :)
            $userSubmittedData = $this->form->getAll(); // Get user submissions
            // Construct the data array to insert in database
            $data = array();
            
            $data["username"] = $userSubmittedData["username"];
            
            // Check whether the username already exists
            $db = $model->getDB();  //  Get a reference to db object
            $db->select = array("id");
            $db->identifier = array("username" => $userSubmittedData["username"]);
            $db->returnPointer = false; // Single entry
            $result = $db->selectArray();
            if($result){
                // Set an error message
                $core->funcs->setDisplayMsg("This username already exists (id: " . $result['id'] . " ) please choose a different username", MSGBOX_WARNING);
                $this->form->resubmit();
                return; // exit
            }
            
            $db->clear();   //  Clean up the data
            
            $data["email"] = $userSubmittedData["email"];
            $data["sex"] = $userSubmittedData["sex"];
            
            // Insert some other data
            $data["date"] = time(); //  Current time in UNIX timestamp
            
            // Okay. save it!
            $newUserId = $model->insert($data, $userSubmittedData["passwd"]);
            echo "Database submission status: new user ID is: $newUserId";
            exit();
        }else{
            // form invalid
            $this->form->resubmit();
        }
    }
}

?>
