<?php

/**
 * Description of guiForms
 * This class simply draws HTML forms for different pages
 * coded in oop way in the sense that Forms may be re-used
 * @author Shafiul Azam
 * ishafiul@gmail.com
 * Project Manager
 */

// Constants

define("FORM_RESULT", 0);
define("FORM_ERROR_STRING", 1);
define("FORM_HTML",2);

// Constants for internal use

define("PIZZA_FORM_DISPLAYNAME",0);
define("PIZZA_FORM_VALIDATORS",1);
define("PIZZA_FORM_HTML",2);
define("PIZZA_FORM_HTML_FUNCNAME",3);
define("PIZZA_FORM_HTML_FUNC_ARGS",4);

/**
 * \brief Create, submit & validate web-forms
 * 
 * This class provides opportunities for:
 * - Creating web forms easily, withtout writing any %HTML: within your %Controller
 * - Send object of a form to %View class
 * - Process submission of a form, & perform validation
 * - If validation fails, automatically generate Error messages & re-present form to user, keeping user provided data intact.
 */

abstract class CoreForm{
    

    public $action = '';    ///<    for form attribute "action"
    public $method = 'post';    ///<    for form attribute "method"
    public $target = '';        ///<    for Form attribute "target"
    public $onSubmit = '';  ///<    for Form attribute "onsubmit"
    private $elements = array(); ///<    Key-value array for storing form elements
    public $submitButtonText = '';  ///<    Text displayed at form submit button
    public $tableBorder = '0';  ///<    for Table attribute "border"
    public $tableCellSpacing = '';  ///<    for Table attribute "cellspacing"
    public $tableCellPadding = '';  ///<    for table attribute "cellpadding"
    public $arbritaryHTML = ''; ///<    This %HTML string is placed after form elements
    public $fileUpload = false; ///<    Set true if you're uploading file(s) by this form
    public $id = "";    ///<    for Form attribute "id"
    public $submitButtonId = "";    ///<    for Form's submit button's attribute "id"
    public $class = ""; ///<    for Form attribute "class"
    public $displaySubmissionErrors = true; ///< Set to true if you want to display error messages when form validation fails
    public $currentElementName = "";    ///< "name" attribute of currently processing form element - available while validating form
    public $validators = null;      ///< Key-value array, key is "name" attribute or an alement, value is List of validators.
    public $noErrorFormatting = false;
    public $errorStringSeperator = '<br />';
    public $arrVal = null;   ///< getting value from a key-value array safely 
    public $allowGetRequests = false;
    
    private $validate = false;  ///<    Automatically set to true when you're validating a submitted form
    private $submittedData = array();   ///< Used to store user-submitted data by this form
    private $error = "";    ///< Contains error-strings if form validation fails.
    private $formHtml = ""; ///< Contains the %HTML string generated for this form
    private $core = null;   ///<    A reference to the global $core
    private $formName = ""; ///<    Name of the class which extended me ( CoreClass )
    private $isSubmissionValid = null;  ///< Indicator whether form submission validated
    // Public & private Methods
    
    /**
     * Generally, you extend CoreForm class when you're creating a form class (See example child class: Registration form in VIEW/forms directory)
     * In your Form class's constructor, you should call this function. (see the example classed mentioned)
     * @param object $ob should be always "$this" - reference to the child class.
     * @param Core $core a reference to the global $core 
     */
    
    public function __construct($ob,$core) {
        $this->core = $core;
        $this->formName = get_class($ob);
        // Also, send my reference to the validator
        $this->core->validate->form = $this;
        // Attrributes
        $this->submitButtonText = 'Submit';
    }
    
    /**
     * Creates & returns %HTML for this form. 
     * - You do not need to use this function at all if you use sendToView() function. Example: CONTROL/registration.php & VIEW/registration.php
     * - If you want to manually send the generated %HTML of the form to your view class, you may call this function within your controller. See example: CONTROL/login.php & VIEW/login.php
     * 
     * @return none
     */
    
    private function generateHTML() {
        // Creates the HTML form and returns the HTML
        // Output HTML 
        $fileUploadCode = ($this->fileUpload)?("enctype='multipart/form-data'"):("");
        $this->formHtml = '<form class="html-form ' . $this->class . '" ' . $fileUploadCode . ' method = "' . $this->method . '" action = "' . $this->action . '" target = "' . $this->target . '" onsubmit = "' . $this->onSubmit . '" id = "' . $this->id . '">';
        $this->formHtml .= '<table class="html-form-table" cellspacing = "' . $this->tableCellSpacing . '" cellpadding =  "' . $this->tableCellPadding . '"  border = "' . $this->tableBorder . '"><tbody>';
        // Loop through the components and print one component per row
//        echo count($this->elements);
        foreach($this->elements as $elemName=>$content){
            // Get user-submitted, validated data
//            echo '<br />For element: ' . $elemName . '<br />';
            $argArr = $this->elements[$elemName][PIZZA_FORM_HTML_FUNC_ARGS];
            $argArr[2] = $this->submittedData[$elemName];
            $elemHTML = call_user_func_array(array("HTML",$content[PIZZA_FORM_HTML_FUNCNAME]), $argArr);
            $this->formHtml .= Html::tr(array($content[PIZZA_FORM_DISPLAYNAME],$elemHTML)) . "\n";
        }
        $this->formHtml .= '</tbody></table><br />' . $this->arbritaryHTML . '<br />';
        $this->formHtml .= '<input id="'. $this->submitButtonId .'" class=html-form-submit type = "submit" value = "' . $this->submitButtonText . '" />';
        $this->formHtml .= '</form>';
    }
    
    /**
     * \brief Important function to call within your Controller classes.
     * 
     * Call this function within your Controller classes to automatically send the generated %HTML of the form to your View class.
     * 
     * Next, within your view class, you can call CoreView::form($id) to get the generated html, where $id is the class name of the form
     * @param $returnOnly bool
     *  - is false by default
     *  - if true, returns the generated %HTML, also does not pass validation errors as \a status \a messages
     */
    
    public function sendToView($returnOnly = false){
        if($this->error && !$returnOnly)
            $this->core->funcs->setStatusMsg($this->error);
        
        // Set display names
        if(!$this->validate){
            foreach ($this->validators as $elemName=>$temp){
                $this->elements[$elemName][PIZZA_FORM_DISPLAYNAME] = $temp[0];
//                echo "|" . $temp[0] . "|<br />";
            }
        }
            
        $this->createElements();
        $this->generateHTML();
        if($returnOnly)
            return $this->formHtml;
        $this->core->formData[$this->formName] = $this->formHtml;
    }
    
    /**
     * \brief Important Function  - After a user has submitted the form, call it within your controller to start form validation
     * 
     * Call this function within your controller to start validation of the form. Validation functions already defined using element() functions 
     * are applied one after another on each element of the form.
     * 
     * WARNING: return type got changed. update doc
     * @return array | You will need to check only the 0th element of the array, if you are using sendToView()
     * - 0th element of the array: boolean, true if all validation functions successful, false if one or more validation functions failed. 
     * - 1st element of the array: string, error message if validation failed
     * - 2nd element of the array: string, re-generated %html of the form, with user submitted values :-)
     */ 
    
    public function validate(){
        // When form submitted, used this to validate the form.
        $this->validate = true;
        $this->error = array();
        // Run validation
        foreach ($this->validators as $elemName=>$temp){
            $this->elements[$elemName][PIZZA_FORM_DISPLAYNAME] = $temp[0];
            if(isset ($temp[1]) && !empty ($temp[1])){
                $this->submittedData[$elemName] = $this->doValidation($elemName,$temp[1]);
            }else{
                $this->submittedData[$elemName] = isset ($_POST[$elemName])?($_POST[$elemName]):("");
            }
        }
        $this->error = implode($this->errorStringSeperator, $this->error);
        $this->isSubmissionValid = (empty($this->error))?(true):(false);
        return $this->isSubmissionValid;
    }
    
    // Element related
    
    /**
     * \brief Important function  - use it to get user-submitted value for element of the form!
     * 
     * Call this function within your constructor to get VALIDATED user-submitted value for a single element.
     * @param string $name the "name" attribute of the element
     * @return string | validated user submitted value 
     */
    
    public function get($name){
        return (isset($this->submittedData[$name]))?($this->submittedData[$name]):(null);
    }
    
    public function arrVal($index){
        if(isset($this->arrVal[$index]))
            return $this->arrVal[$index];
        else
            return "";
    }
    
    /**
     * 
     * @return string | Error string, if the form submission failed.
     */
    
    public function getError(){
        return $this->error;
    }


    /**
     * Use this function to set the elements created for your form.
     * @param array $elem is a mixed array. Each element of the form will contribute an element of this $elem array. 
     * For each element, we need an array (key-value) of following format:
     *  - key is: string, "name" attribute of the form element.
     *  - value is: array (mixed) of following type:
     *      - 0th element: string | Label (user-friendly display name) of the element
     *      - 1st element: string | names of validation functions seperated by "|" - see documentations for details. 
     *          - seperate each function name by a "|" character (without the quotes)
     *          - you can pass parameters to a function. To pass parameter: type the parameters after the function name, seperated by commas ","
     *          - if you are going to pass a paramter which itself contains comma "," character(s), escape each comma by a slash "\"
     *              -   For example: "required|limit,3,5|email" means:
     *              -   First, CoreValidator::required() will be called on the subject
     *              -   Next, CoreValidator::limit() will be called with parameters "3" (1st parameter) & "5" (2nd parameter)
     *              -   Finally, CoreValidator::email() will be called on the subject
     *      - 2nd element: name of the function that will be called to generate %HTML for this element.
     *      - 3rd element: an array whose elements will be passed to the function just mentioned (2nd element) as parameters. 
     * 
     * 
     * Validation functions are located in CoreValidator (in core/class directory) & Validator (in custom/class directory) classes. 
     * You can define your own validation functions in Validator class.
     * 
     * You can get complete examples in Login & Registration class (see source code: Login::createElements() Registration::createElements() ). Also, see tutorials.
     */
    
    public function setElements($elem){
        foreach ($elem as $name=>$eArr){
            $arraySuffix = (strpos($name, "[]"))?("[]"):("");
            $name = str_replace("[]", "", $name);
            $this->elements[$name][PIZZA_FORM_HTML_FUNCNAME] = $eArr[0];
            // arguments of HTML generating funcs
            if(isset ($eArr[1])){
                array_unshift($eArr[1], $name . $arraySuffix); //  push $name at the beginning of the array
            }else{
                $eArr[1] = array($name . $arraySuffix,null);    //  create a new array with only element $name in it
            }
            $this->elements[$name][PIZZA_FORM_HTML_FUNC_ARGS] = $eArr[1];
            // Store developer provided value. This is available from $eArr[1][2]
            if(empty ($this->submittedData[$name])){
                $this->submittedData[$name] = (empty($eArr[1][2]))?(""):($eArr[1][2]);
            }
        }
    }
    


    /**
     * Call this function within your constructor to get VALIDATED user-submitted value for all form elements.
     * @return array | key-value array where key is the "name" attribute of the element. 
     */
    
    public function getAll(){
        return $this->submittedData;
    }
    
    /**
     * Returns the Human-readable name (Display Name) of an element. This display name 
     * was set by the 2nd parameter of element() function
     * @param string $name "name" attribute of the element
     * @return string Display-name of the element. 
     */
    
    public function getDisplayName($name){
        return $this->elements[$name][PIZZA_FORM_DISPLAYNAME];
    }
    

    /**
     * @name Functions for Internal Use
     * These functions are called automatically within the framework.
     * You should NEVER call these functions in your code!
     */
    
    
    //@{
    
    /**
     * Used Internally to start validation of a form element What it does is:
     *  - Based on the 3rd parameter "$validators" in element() function, seperates all functions to call 
     * on the user provided input for this element. functions () are seperated by the character "|"
     * @param string $name name of the element to start validation
     * @return string | validated user input for this element 
     */
    
    private function doValidation($name,$validators){
        // Strip off array symbols from the name
//        $name = str_replace("[]", "", $name);
        $this->currentElementName = $name;
        $funcsToCall = explode("|", $validators);
        // Get the post value to begin examination!
        if($this->allowGetRequests)
            $this->core->validate->subject = (isset($_REQUEST[$name]))?($_REQUEST[$name]):("");
        else
            $this->core->validate->subject = (isset($_POST[$name]))?($_POST[$name]):("");
        foreach($funcsToCall as $func){
            // get parameters for the function
            // handle escaped values
            $func = str_replace("\,", ":_:@:", $func);
            $params = explode(",", $func);
            $func = $params[0];
            if(!method_exists($this->core->validate, $func)){
                echo "Error: Validation function $func is not defined for element " . $this->getDisplayName($name);
                exit();
            }
            unset ($params[0]);
            $paramsFinalized = array();
            // Handle escaped values 
            foreach ($params as $i){
                $paramsFinalized[] = str_replace(":_:@:", ",", $i);
            }
            call_user_func_array(array($this->core->validate,$func),$paramsFinalized);
        }
        // Check for errors
        $error = $this->core->validate->exitIfInvalid(false, ", ");
        if(!empty($error)){
            if($this->noErrorFormatting)
                $this->error[] = $this->elements[$name][PIZZA_FORM_DISPLAYNAME] . ' - ' . $error;
            else
                $this->error[] = '&quot;' . $this->elements[$name][PIZZA_FORM_DISPLAYNAME] . '&quot; ' . $error;

        }
        $this->submittedData[$name] = $this->core->validate->subject;    //  subject is now validated!
        return $this->core->validate->subject;
    }
    
    
    //@}
    

    /**
     * @name Abstract functions: implement these functions in Child class.
     */
    
    //@{
    
    /**
     * Within this function: build an array for your form-elements. Then set the elements 
     * using setElements() function.
     * 
     * For example, see Registration class
     */
    
    abstract public function createElements();  //  To be implemented
    public function createValidators(){
        // To be implemented in forms
    }
    //@}
    
    
    /**
     * Functions for creating %HTML Forms
     */
    
    //@{
    
    
    
    
    //@}
}


?>