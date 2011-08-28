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
    
    private $validate = false;  ///<    Automatically set to true when you're validating a submitted form
    private $submittedData = array();   ///< Used to store user-submitted data by this form
    private $error = "";    ///< Contains error-strings if form validation fails.
    private $formHtml = ""; ///< Contains the %HTML string generated for this form
    private $core = null;   ///<    A reference to the global $core
    private $formName = ""; ///<    Name of the class which extended me ( CoreClass )

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
        // Check if validation required
        if($this->validate){
            if(empty($this->error)){
                // No errors! Form validated
                return array(true);
            }
        }
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
            $this->resubmit($this->error);  //  Display errors
            return array(false, $this->error ,  $this->formHtml);
        }
        
        return $this->formHtml;
    }
    
    /**
     * Call this function within your controller to automatically send the generated html to your view class.
     * Within your view class, you can call Core::getForm($id) to gain the html, where $id is the class name of the form
     */
    
    public function sendToView(){
        $this->core->formData[$this->formName] = $this->create();
    }
    
    /**
     * Call this function within your controller to start validation of the form.
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
    
    
    
    
    // Element related
    
    /**
     * Call this function within your child form class to set various properties for a form element. See parameters 
     * - element() & elementHTML() are always called in pair for an element of the form. element() MUST be called BEFORE the corresponding elementHTML() of the pair.
     * - see Registration or Login class for example. 
     * @param string $name the "name" attribute of the element
     * @param string $displayName the label displayed for the element. This value also used for identifying the element in error messages.
     * @param type $validators a list of validation functions seperated by "|" - see documentations for details. Validation functions are located in CoreValidator (in core/class directory) & Validator (in custom/class directory) classes
     */
    
    public function element($name,$displayName,$validators = ""){
        $this->elements[$name] = array($displayName, $validators);
    }
    
    /**
     * Call this function within your child form class to set the %HTML for a form element. 
     * - element() & elementHTML() are always called in pair for an element of the form. element() MUST be called BEFORE the corresponding elementHTML() of the pair.
     * - see Registration or Login class for example. 
     * @param string $name the "name" attribute of the element
     * @param type $html the html for this element. You can use input(), textarea(), select() etc. functions to create the %HTML 
     */
    public function elementHTML($name,$html){
        $this->elements[$name][2] = $html;
//        echo "here " . count($this->elements);
    }
    
    /**
     * Call this function within your constructor to get VALIDATED user-submitted value for a single element.
     * @param string $name the "name" attribute of the element
     * @return string | validated user submitted value 
     */
    
    public function get($name){
        return (isset($this->submittedData[$name]))?($this->submittedData[$name]):(null);
    }
    
    /**
     * Call this function within your constructor to get VALIDATED user-submitted value for all form elements.
     * @return array | key-value array where key is the "name" attribute of the element. 
     */
    
    public function getAll(){
        return $this->submittedData;
    }
    
    /**
     * If you are using sendToView() call this function within your constructor to automatically
     * send error message & generated html (with user-provided values) of the form to the view.
     */
    
    public function resubmit(){
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
     * Used Internally to start validation of a form element
     * @param string $name name of the element to start validation
     * @return string | validated user input for this element 
     */
    
    private function doValidation($name){
        $element = $this->elements[$name];
        $funcsToCall = explode("|", $element[1]);
        // Get the post value to begin examination!
        $this->core->validate->subject = $_POST[$name];
        foreach($funcsToCall as $func){
            // get parameters for the function
            $params = explode(",", $func);
            $func = $params[0];
            unset ($params[0]);
            call_user_func_array(array($this->core->validate,$func),$params);
        }
        // Check for errors
        $error = $this->core->validate->exitIfInvalid(false, ", ");
        $this->error .= (empty ($error))?(""):($element[0] . " $error<br />");
        $this->submittedData[$name] = $this->core->validate->subject;    //  subject is now validated!
        return $this->core->validate->subject;
    }
    
    
    //@}
    
    /**
     * @name Functions for creating %HTML for form-elements
     */
    
    
    //@{
    
    /**
     *
     * See HTML::input() for documenttion
     */
    public function input($name,$type="text", $id="", $value="", $attrArr = null) {
        if($this->validate){
            $value = $this->doValidation($name);
        }
        return parent::input($name, $type, $id, $value, $attrArr);
    }
    
    /**
     *
     * See HTML::textarea() for documenttion
     */
    
    public function textarea($name,$value = "",$attrArr=null, $id= ""){
        if($this->validate){
            $value = $this->doValidation($name);
        }
        return parent::textarea($name, $value, $attrArr, $id);
    }
    
    /**
     *
     * See HTML::select() for documenttion
     */
    
    public function select($name, $options, $selectedValue = "", $attrArr= null, $id=null) {
        if($this->validate){
            $selectedValue = $this->doValidation($name);
        }
        return parent::select($name, $options, $selectedValue, $attrArr, $id);
    }
    
    
    //@}
    
    /**
     * @name Abstract functions: implement these functions in Child class.
     */
    
    //@{
    
    /**
     * Within this function call a sequence of element() & elementHTML() functions in pair. 
     * For example, see Registration class
     */
    
    abstract public function createElements();  //  To be implemented
    //@}
}


?>