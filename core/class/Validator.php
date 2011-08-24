<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

class Validator{
    
    
    public $errorArray;
    
    // Vars for internal use
    private $core;  // A reference to core object
    private $redirectURL = "";
    
    // Constructor
    public function __construct($core) {
        $this->core = $core;
        $this->errorArray = array();
    }
    
    
    public function userInput($data, $length="", $required = true, $defaultValue = "") {
//            Returns validated input, or store in error array.
        if ($required) {
            if (empty($_REQUEST["$data"])) {
//                    die("empty");
                $redirectUrl = (isset($_SERVER['HTTP_REFERER'])) ? ($_SERVER['HTTP_REFERER']) : ('');
                $this->redirectURL = $redirectUrl;
//                $this->core->funcs->messageExit("Required field <b>$data</b> is empty. Please try again!", 3, $redirectUrl);
                $this->errorArray[] = "Required field <b>$data</b> is empty. Please try again!";
                return false;
            } else if (!empty($length) && strlen($_REQUEST["$data"]) > $length) {
//                    die("inside");
                $this->redirectURL = $_SERVER['HTTP_REFERER'];
//                $this->core->funcs->messageExit("Required field <b>$data</b> is too large to fit in (max <b>$length</b> characters.). Please try again!", 3, $_SERVER['HTTP_REFERER']);
                $this->errorArray[] = "Required field <b>$data</b> is too large to fit in (max <b>$length</b> characters.)";
                return false;
            }
        }
        $return = (empty($_REQUEST["$data"])) ? ($defaultValue) : (htmlspecialchars($_REQUEST["$data"]));
        return $return;
    }
    
    public function exitIfInvalid($exit=true){
        // if exit = false, just returns the error string if there are errors. Returns FALSE if valid!
        $errorString = "";
        $errorString = implode("",$this->errorArray);
        if(!empty($errorString)){
            if($exit)
                $this->core->funcs->messageExit("$errorString", 3, $this->redirectURL);
            return $errorString;
        }else{
            return false;   //  Returns false if valid!
        }
    }


    public function emailAddress($email) {
        return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$|i', $email);
    }
    
    public function replaceNonAlphaNumerics($stringToBeReplaced, $replaceWith = "-") {
        return preg_replace("@[^A-Za-z0-9]@", $replaceWith, $stringToBeReplaced);
    }
    
}

?>
