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

/**
 * \brief Create, submit & validate web-forms
 * 
 * This class provides opportunities for:
 * - Creating web forms easily, withtout writing any %HTML: within your %Controller
 * - Send object of a form to %View class
 * - Process submission of a form, & perform validation
 * - If validation fails, automatically generate Error messages & re-present form to user, keeping user provided data intact.
 */

abstract class CoreForm extends HTML {
    

    public $action = '';    ///<    for form attribute "action"
    public $method = 'post';    ///<    for form attribute "method"
    public $target = '';        ///<    for Form attribute "target"
    public $onSubmit = '';  ///<    for Form attribute "onsubmit"
    public $elements = array(); ///<    Key-value array for storing form elements
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


    private $validate = false;  ///<    Automatically set to true when you're validating a submitted form
    private $submittedData = array();   ///< Used to store user-submitted data by this form
    private $error = "";    ///< Contains error-strings if form validation fails.
    private $formHtml = ""; ///< Contains the %HTML string generated for this form
    private $core = null;   ///<    A reference to the global $core
    private $formName = ""; ///<    Name of the class which extended me ( CoreClass )
    private $isSubmissionValid = null;  ///< Indicator whether form submission validated
    private $hiddenElementsData = "";
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
    }
    
    /**
     * Creates & returns %HTML for this form. 
     * - You do not need to use this function at all if you use sendToView() function. Example: CONTROL/registration.php & VIEW/registration.php
     * - If you want to manually send the generated %HTML of the form to your view class, you may call this function within your controller. See example: CONTROL/login.php & VIEW/login.php
     * @return string generated html for this form 
     */
    
    public function create() {
        // Creates the HTML form and returns the HTML
        // Create elements
        $this->createElements();
        // Output HTML 
        $fileUploadCode = ($this->fileUpload)?("enctype='multipart/form-data'"):("");
        $this->formHtml = '<form class="html-form ' . $this->class . '" ' . $fileUploadCode . ' method = "' . $this->method . '" action = "' . $this->action . '" target = "' . $this->target . '" onsubmit = "' . $this->onSubmit . '" id = "' . $this->id . '">';
        $this->formHtml .= '<table class="html-form-table" cellspacing = "' . $this->tableCellSpacing . '" cellpadding =  "' . $this->tableCellPadding . '"  border = "' . $this->tableBorder . '"><tbody>';
        // Loop through the components and print one component per row
//        echo count($this->elements);
        foreach($this->elements as $label=>$content){
            $this->formHtml .= $this->tr(array($content[0],$content[2])) . "\n";
        }
        $this->formHtml .= '</tbody></table><br />' . $this->arbritaryHTML . '<br />';
        $this->formHtml .= '<input id="'. $this->submitButtonId .'" class=html-form-submit type = "submit" value = "' . $this->submitButtonText . '" />';
        $this->formHtml .= '</form>';
        
        if($this->validate){
            $this->validate = false;
            if(empty($this->error)){
                // No errors! Form validated
                $this->isSubmissionValid = true;
                return array(true);
            }
            $this->isSubmissionValid = false;
            return array(false, $this->error ,  $this->formHtml);
        }
        
        return $this->formHtml;
    }
    
    /**
     * \brief Important function to call within your controller
     * 
     * Call this function within your controller to automatically send the generated html of the form to your view class.
     * 
     * Next, within your view class, you can call Core::getForm($id) to gain the generated html, where $id is the class name of the form
     */
    
    public function sendToView(){
        $this->core->formData[$this->formName] = $this->create();
    }
    
    /**
     * \brief Important Function  - After a user has submitted the form, call it within your controller to start form validation
     * 
     * Call this function within your controller to start validation of the form. Validation functions already defined using element() functions 
     * are applied one after another on each element of the form.
     * @return array | You will need to check only the 0th element of the array, if you are using sendToView()
     * - 0th element of the array: boolean, true if all validation functions successful, false if one or more validation functions failed. 
     * - 1st element of the array: string, error message if validation failed
     * - 2nd element of the array: string, re-generated %html of the form, with user submitted values :-)
     */ 
    
    public function validate(){
        // When form submitted, used this to validate the form.
        $this->validate = true;
        return $this->create();
    }
    
    /**
     * After calling validate() within your controller, you can call this function to learn if form validation succeeded.
     * @return bool true if form submission validated (all validators returned true), false otherwise
     * 
     */
    public function isSubmissionValid(){
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
            $this->elements[$name][PIZZA_FORM_DISPLAYNAME] = $eArr[0];
            $this->elements[$name][PIZZA_FORM_VALIDATORS] = $eArr[1];
            if(isset ($eArr[3]))
                array_unshift($eArr[3], $name); //  push $name at the beginning of the array
            else
                $eArr[3] = array($name);    //  create a new array with only element $name in it
            // Run Validators
            if($this->validate){
                // WARNING: "value" must be present in the 2nd element of the HTML generator functions!!!
                $eArr[3][1] = $this->doValidation($name);
            }
            $this->elements[$name][PIZZA_FORM_HTML] = call_user_func_array(array("HTML",$eArr[2]),  $eArr[3]);
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
     * If you are using sendToView() call this function within your constructor to automatically
     * send error message & generated html (with user-provided values) of the form to the view.
     */
    
    public function resubmit(){
        if($this->error)
            $this->core->funcs->setDisplayMsg($this->error);
        $this->core->formData[$this->formName] = $this->formHtml;
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
    
    private function doValidation($name){
        $this->currentElementName = $name;
        $element = $this->elements[$name];
        // Check if we really need validation
        if(empty($element[PIZZA_FORM_VALIDATORS])){
            // No validation needed
            $this->submittedData[$name] = $_POST[$name];    //  subject is now validated!
            return $_POST[$name];
        }
        $funcsToCall = explode("|", $element[1]);
        // Get the post value to begin examination!
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
        $this->error .= (empty ($error))?(""):("&quot;" . $element[0] . "&quot; $error<br />");
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
    //@}
}


?>