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

/**
 * \brief Validates user-submitted inputs.
 * 
 * @author Shafiul Azam
 * 
 * @uses General purpose validation class. $core has an object of this class named $validate
 * $core->validate is heavily used in validating web forms (child of class CoreForm )
 * Most of the functions (except userInput() ) of this class are used form validation. 
 * You can add your own functions in the custom validator class Validator in custom/class folder.
 * 
 * You can perform a series of validation (calling several functions of this class) on the same string
 * & append error messages, if any of these fucntions fail. The string on which these operations will take
 * place is first stored in variable $subject. Then you call one/more functions (automatically called if you specify
 *  this function names in the object of CoreForm seperated by "|" - see 3rd parameter of CoreForm::element() function.)
 */

class CoreValidator{
    
    public $subject;    ///<    The string on which validation functions will operate.
    public $errorArray; ///<    Array to store error strings. One element per function
    
    // Vars for internal use
    private $core = null;  ///< Reference to the $core object   
    private $redirectURL = "";  ///<    Redirection url if validation fails - may be chosen
   
    // Constructors
    
    /**
     * You should (recommended) pass the $core as parameter
     * @param Core object $core pass $core here 
     */
    
    
    public function __construct($core=null) {
        $this->core = $core;
        $this->errorArray = array();
    }
    
    /**
     * This function is not called in web form validations. Rather, use this in your code
     * to perform some common-purpose (mentioned in parameters) validation in use provided value via get/post method
     * 
     * This function appends error message to $errorArray
     * @param string $data | string to validate (subject)
     * @param int $length maximum length the subject might be. Infinity if empty parameter
     * @param bool $required if true, validation fails if subject is empty
     * @param string $defaultValue a default value to return if the subject is empty, only applicable when $required is false
     * @return mixed 
     * - bool | false if validation fails.
     * - validated string, passed through php's htmlspecialchars
     */
    
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
    
    /**
     * When you're done calling validation functions, call this function as the last step
     * @param string $joiner the string to insert between various function's error messages
     * @return mixed
     *  - string | error message if any of the validation functions returned false
     *  - bool | false if all functions succeeded. CHECK THIS!
     */
    
    public function validate($joiner = "<br />"){
        return $this->exitIfInvalid(false,$joiner);
    }
    
    /**
     * This function works similarly as validate() -
     * @param bool $exit | set to true if you want to redirect to $redirectURL if validation fails
     * @param string $joiner the string to insert between various function's error messages
     * @return mixed
     *  - if any of the validation fails 
     *      -   string | error string if parameter $exit is set to false
     *      -   none | redirects to $redirectURL if $exit set to true
     *  - if none of the validation fails
     *      -   bool false : CHECK THIS!  
     */
    
    public function exitIfInvalid($exit=true, $joiner = "<br />"){
        // if exit = false, just returns the error string if there are errors. Returns FALSE if valid!
        $errorString = "";
        $errorString = implode($joiner,$this->errorArray);
        $this->errorArray = array();    //  Reset the error Array.
        if(!empty($errorString)){
            if($exit)
                $this->core->funcs->messageExit("$errorString", 3, $this->redirectURL);
            return $errorString;
        }else{
            return false;   //  Returns false if valid!
        }
    }
    
    /*
     * @name Validation Functions
     * 
     * These functions are the heart of this class. You can add your own validation functions
     * in Validator class
     */

    //@{
    
    /**
     * Validates whether $subject is a valid Email address
     * @return bool false if invalid, true else.
     */
    
    public function email() {
        if( !preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$|i', $this->subject) ){
            $this->errorArray[] = "is not a valid email";
            return false;
        }
        return true;
                
    }
    
    /**
     * Replaces non alpha-numeric charecters from $subject. 
     *  - Does not generate any error message. 
     * @param string $replaceWith the character with which non alphanumeric chars will be replaced
     * @return None
     */
    
    public function replaceNonAlphaNumerics($replaceWith = "-") {
        $this->subject =  preg_replace("@[^A-Za-z0-9]@", $replaceWith, $this->subject);
    }
    
    /**
     * @return bool false : (Not valid) if $subject is empty
     */
    
    public function required(){
        if(empty($this->subject)){
            $this->errorArray[] = "can not be empty";
            return false;
        }
        return true;
    }
    
    /**
     * Applies PHP's built in htmlspecialchars function
     */
    
    public function htmlspecialchars(){
        // No error is generated, just filters the text
        $this->subject = htmlspecialchars($this->subject);
    }
    
    //@}
    
    
    
}

?>
