<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   This page is under construction. Never use it!
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

/**
 * \brief Custom Class: Under construction
 * 
 * This class will contain some basic functionality for user log in, log out, permission validation 
 * for pages etc.
 */

class Auth{
    public $core;
    public $urls;
    public $data = false;
    public $isLoggedIn = false;
    public $redirectURL;
    
    private $sessionVarName = "hti_auth";
    
    public function __construct($core) {
        $this->core = $core;
        // Set patterns & other configurations
        $this->redirectURL = "";    //  redirect to referer
        $this->urls = array("admin/"); 
        // Call function to start validation
        $this->globalValidation();
    }
    
    private function globalValidation(){
        $this->hasAccess(HTI_NONREGISTERED);
        // restrict access totally in following pages:
        if($this->data['type'] < HTI_ADMIN){
            foreach ($this->urls as $url){
                $page = $this->core->getPage();
                if(strpos($page, $url) === 0){
                    $this->core->funcs->messageExit("Sorry, but you are not authenticated to view these resources!");
                }
            }
        }
        
    }
    
    public function hasAccess($requiredMemberType=HTI_STUDENT){
        $this->data = $this->core->funcs->getSessData($this->sessionVarName);
//        echo var_dump($_SESSION);
        if($this->data){
//            echo "Auth";
            $this->isLoggedIn = true;
            return ($this->data['type'] < $requiredMemberType)?(false):(true);
        }else{
//            echo "Not auth";
            $this->isLoggedIn = false;
        }
        return $this->isLoggedIn;
    }
    
    public function redirectIfNotAuthenticated($requiredMemberType){
        if($this->data['type'] < $requiredMemberType)
            $this->core->funcs->messageExit("Sorry, but you are not authenticated to view these resources!");
    }
}

?>
