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

abstract class CoreForm extends HTML {
    

    public $action = '';
    public $method = 'post';
    public $target = '';
    public $onSubmit = '';
    public $elements = array();
    public $submitButtonText = '';
    public $tableBorder = '0';
    public $tableCellSpacing = '';
    public $tableCellPadding = '';
    public $arbritaryHTML = '';
    public $fileUpload = false;
    public $id = "";
    public $submitButtonId = "";
    public $class = "";
    public $isShowButton = true;
    public $displaySubmissionErrors = true;
    
    private $validate = false;
    private $submittedData = array();
    private $error = "";
    private $formHtml = "";
    private $core = null;
    private $formName = "";

    // Public & private Methods
    
    public function __construct($ob,$core) {
        $this->core = $core;
        $this->formName = strtolower(get_class($ob));
    }
    
    abstract public function createElements();  //  To be implemented


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
    
    public function sendToView(){
//        echo "sent to view";
        $this->core->formData[$this->formName] = $this->create();
    }
    
    public function validate(){
        // When form submitted, used this to validate the form.
        $this->validate = true;
        return $this->create();
    }
    
    public function doValidation($name){
        $element = $this->elements[$name];
        $funcsToCall = explode("|", $element[1]);
        // Get the post value to begin examination!
        $this->core->validate->subject = $_POST[$name];
        foreach($funcsToCall as $func){
            call_user_func(array($this->core->validate, $func));
        }
        // Check for errors
        $error = $this->core->validate->exitIfInvalid(false, ", ");
        $this->error .= (empty ($error))?(""):($element[0] . " $error<br />");
        $this->submittedData[$name] = $this->core->validate->subject;    //  subject is now validated!
        return $this->core->validate->subject;
    }
    
    
    // Element related
    
    public function element($name,$displayName,$validators = ""){
        $this->elements[$name] = array($displayName, $validators);
//        echo "here " . count($this->elements);
    }
    
    public function elementHTML($name,$html){
        $this->elements[$name][2] = $html;
//        echo "here " . count($this->elements);
    }
    
    public function get($name){
        return (isset($this->submittedData[$name]))?($this->submittedData[$name]):(null);
    }
    
    public function getAll(){
        return $this->submittedData;
    }
    
    public function resubmit(){
        // Resubmit the form
        $this->core->funcs->setDisplayMsg($this->error);
        $this->core->formData[$this->formName] = $this->formHtml;
    }


    // Override parent HTML class's functions
    
    public function input($name,$type="text", $id="", $value="", $attrArr = null) {
        if($this->validate){
            $value = $this->doValidation($name);
        }
        return parent::input($name, $type, $id, $value, $attrArr);
    }
    
    public function textarea($name,$value = "",$attrArr=null, $id= ""){
        if($this->validate){
            $value = $this->doValidation($name);
        }
        return parent::textarea($name, $value, $attrArr, $id);
    }
    
    public function select($name, $options, $selectedValue = "", $attrArr= null, $id=null) {
        if($this->validate){
            $selectedValue = $this->doValidation($name);
        }
        return parent::select($name, $options, $selectedValue, $attrArr, $id);
    }
}

?>