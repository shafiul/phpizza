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
 * 
 * $core->validate is heavily used in validating web forms (child of class CoreForm )
 * 
 * Most of the functions (except userInput() ) of this class are used form validation. 
 * 
 * You can add your own functions in the custom validator class Validator in custom/class folder.
 * 
 * You can perform a series of validation (calling several functions of this class, one after another) on the same string 
 * & append error messages to member variable $errorArray (automatically)- if any of these fucntions fail. The string on which these validation operations will take 
 * place is first stored in member variable $subject. Then you call one/more functions (automatically called if you specify
 *  this function names in the object of CoreForm seperated by "|" - see 3rd parameter of CoreForm::element() function.)
 */

class CoreValidator{
    
    public $subject;    ///<    The string on which validation functions will operate.
    public $errorArray; ///<    Array to store error strings. One element per function
    public $form;       ///<    A reference to the form it is currently processing (if any)        
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
     * @param int $length maximum length the subject might be. Infinity if parameter empty
     * @param bool $required if true, validation fails if subject is empty
     * @param string $defaultValue a default value to return if the subject is empty, only applicable when $required is false
     * @return mixed 
     * - bool | false if validation fails.
     * - validated string, passed through php's htmlspecialchars
     */
    
    public function input($data, $length="", $required = true, $defaultValue = "") {
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
            if($exit){
                $this->core->funcs->messageExit("$errorString", 3, $this->redirectURL);
//                $this->core->funcs->setDisplayMsg($errorString,3);
//                return;
            }
            return $errorString;
        }else{
            return false;   //  Returns false if valid!
        }
    }
    
    
    
    
    
    /**
     * @name Validation Functions
     * 
     * These functions are the heart of this class. You can add your own validation functions
     * in Validator class
     */

    //@{
    
    
    
    /**
     * Checks if $this->subject is one of the values specified by $possibleValues
     * @param string $possibleValues all the possible values here, seperated by a colon ":" character (without the quotes)
     *  -   example: "enum,male:female" means $this->subject should be either "male" or "female"
     *  -   If you have some value which itself has colon (:) in it, escape all colons with a preceeding slash (\)
     * @return boolean | false if validation fails 
     */
    
    public function enum($possibleValues){
        // Handle escaped
        $possibleValues = str_replace("\:", "-_-_-", $possibleValues);
        // Get arrays for possible values
        $possibleValuesArr = explode(":", $possibleValues);
        // Handle escaped
        $values = array();
        foreach($possibleValuesArr as $i)
            $values[] = str_replace ("-_-_-", ":", $i);
        if(!in_array($this->subject, $values)){
            $this->errorArray[] = "is not a valid value";
            return false;
        }
        return true;
    }
    
    
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
     * @return bool false : if $subject is empty
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
    
    /**
     * Checks if member variable $subject is equal to 1st parameter $compareWith 
     * @param string $compareWith subject is compared with this parameter
     * @param string $errorMessage the error message to display if comparison fails
     * @return bool | false if validation fails 
     */
    
    public function equalsToStr($compareWith, $errorMessage=""){
        if($this->subject != $compareWith){
            if(empty($errorMessage))
                $errorMessage = "comparison failed";
            $this->errorArray[] = $errorMessage;
            return false;
        }
        return true;
    }
    
    /**
     * Checks if member variable $subject is equal to the user provided value for form element with $elementName name attribute  
     * @param string $elementName name attribute of form element. With the user povided value for this element, $this->subject will be compared.
     * @return bool | false if validation fails 
     */
    
    public function equalsToElement($elementName){
        // get the desired element's user submitted value.
        $compareWith = $this->form->get($elementName);
        if($this->subject != $compareWith){
            $compareWithDisplayName = $this->form->getDisplayName($elementName);
            $this->errorArray[] = "does not match with form element &quot;$compareWithDisplayName&quot;";
            return false;
        }
        return true;
    }
    
    /**
     * Checks if member variable $subject is withing upper & lower character limit
     * @param int $minimumChars minimum length $this->subject should be of
     * @param int $maximumChars maximum length $this->subject can be of
     * @return boolean false if validation fails, true otherwise
     */
    
    public function limit($minimumChars = "", $maximumChars = ""){
        $errorOccured = false;
        if(!empty($minimumChars)){
            if(strlen($this->subject) < $minimumChars){
                $this->errorArray[] = "should be at least $minimumChars character(s)";
                $errorOccured = true;
            }
        }
        if(!empty ($maximumChars)){
            if(strlen($this->subject) > $maximumChars){
                $this->errorArray[] = "can be at most $maximumChars character(s)";
                $errorOccured = true;
            }
            
        }
        return $errorOccured;
    }
    
    public function int(){
        $pattern = '@[\D]@';
        if(preg_match($pattern, $this->subject) !== 0){
            $this->errorArray[] = "is not an integer.";
            return false;
        }
        return true;
    }
    
    public function alphanumeric(){
        $pattern = '@[^\w-]@i';
        if(preg_match($pattern, $this->subject) !== 0){
            $this->errorArray[] = "is not an alphanumeric, only letters, digits, underscore & hyphen are allowed.";
            return false;
        }
        return true;
    }


    /**
     * Always return true.
     * @return type 
     */
    
    public function dummy(){
        return true;
    }
    
    //@}
    
    
    
}

?>