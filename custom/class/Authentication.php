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
 * \brief Custom class for easing Authentication!
 * 
 * Session is used by this class. We search for a key-value array in $_SESSION[$sessionVarName] - if found, then,
 * the value at key 'type' should contain some integer, and the value at key 'id' should contain the username.
 * 
 * This class will contain some basic functionality for user log in, log out, permission validation. \n
 * For example: After log-in, you call:
 * \code
 * $this->setSessData('my_auth', array(
 *  'type' => ADMIN, 'id' => $userId
 * ));
 * \endcode
 * In this class, you should then set $sessionVarName to 'my_auth' for example.
 */

class Authentication{
    public $core;
    public $urls;
    public $data = false;
    public $isLoggedIn = false;
    public $redirectURL;
    
    private $sessionVarName = ""; ///< Name of the variable. We will search data in $_SESSION[$sessionVarName] to validate authentication!
    
    public function __construct($core) {
        $this->core = $core;
        // Set patterns & other configurations
        $this->redirectURL = "";    //  redirect to referer
        $this->urls = array("admin/"); ///< These URL paths will be searched in globalValidation() i.e. these URLs will be search every time on every page request!
        // Call function to start validation
        $this->globalValidation();
    }
    
    /**
     * This function is run on top of every page requests. The URLs in $this->urls are searched against current page URL. \n
     * If matched, then the function will take necessary steps. You may write anything in the body of the function to make your validation work properly.
     */
    
    private function globalValidation(){
        // Remove comment to work:
//        $this->hasAccess();
        // restrict access totally in following pages:
        
//        if($this->data['type'] < ADMIN){
//            foreach ($this->urls as $url){
//                $page = $this->core->getPage();
//                if(strpos($page, $url) === 0){
//                    $this->core->funcs->messageExit("Sorry, but you are not authenticated to view these resources!");
//                }
//            }
//        }
        
    }
    
    
    /**
     * In the body of this function, write appropirate codes to determine whether the current logged-in user 
     * has access to current page.
     * 
     * @param int $requiredMemberType - an integer determining the category/permission level
     * @return bool true if authenticated, false otherwise. 
     * 
     *
     */
    
//    public function hasAccess($requiredMemberType=GENERAL_USER){
//        $this->data = $this->core->funcs->getSessData($this->sessionVarName);
//        if($this->data){
//            $this->isLoggedIn = true;
//            return ($this->data['type'] < $requiredMemberType)?(false):(true);
//        }else{
//            $this->isLoggedIn = false;
//        }
//        return $this->isLoggedIn;
//    }
    
    public function redirectIfNotAuthenticated($requiredMemberType){
        if($this->data['type'] < $requiredMemberType)
            $this->core->funcs->messageExit("Sorry, but you are not authenticated to view these resources!");
    }
}

?>
