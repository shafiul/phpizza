<?php

/**
 * Description of guiForms
 * This class simply draws HTML forms for different pages
 * coded in oop way in the sense that Forms may be re-used
 * @author Shafiul Azam
 * ishafiul@gmail.com
 * Project Manager
 */
/*
 * This file is currently edited by Imran Hasan
 */
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

    private $validate = false;
    public $submittedData = array();
    private $str;
    private $error = "";
    private $v; //  validator
    

    // Public & private Methods
    
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
        $str = '<form class="html-form ' . $this->class . '" ' . $fileUploadCode . ' method = "' . $this->method . '" action = "' . $this->action . '" target = "' . $this->target . '" onsubmit = "' . $this->onSubmit . '" id = "' . $this->id . '">';
        $str .= '<table class="html-form-table" cellspacing = "' . $this->tableCellSpacing . '" cellpadding =  "' . $this->tableCellPadding . '"  border = "' . $this->tableBorder . '"><tbody>';
        // Loop through the components and print one component per row
//        echo count($this->elements);
        foreach($this->elements as $label=>$content){
            $str .= $this->tr(array($content[0],$content[2])) . "\n";
        }
        $str .= '</tbody></table><br />' . $this->arbritaryHTML . '<br />';
        $str .= '<input id="'. $this->submitButtonId .'" class=html-form-submit type = "submit" value = "' . $this->submitButtonText . '" />';
        $str .= '</form>';
        if($this->validate)
            return array(false, $this->error ,$str);
        return $str;
    }
    
    public function validate($core){
        // When form submitted, used this to validate the form.
        $this->validate = true;
        $this->v = $core->validate;
        return $this->create();
    }
    
    public function doValidation($name){
        $element = $this->elements[$name];
        $funcsToCall = explode("|", $element[1]);
        // Get the post value to begin examination!
        $this->v->subject = $_POST[$name];
        foreach($funcsToCall as $func){
            call_user_func(array($this->v, $func));
        }
        // Check for errors
        $error = $this->v->exitIfInvalid(false, ", ");
        $this->error .= (empty ($error))?(""):($element[0] . " $error<br />");
        $this->submittedData[$name] = $this->v->subject;    //  subject is now validated!
        return $this->v->subject;
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