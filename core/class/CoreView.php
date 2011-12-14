<?php


/**
 * \brief All view classes should extend this CoreView class!
 * 
 * @author Shafiul Azam
 * 
 * You can (in fact, you should :P) extend functionality to this class in the CustomView class.
 * 
 * Convention while providin file names: (JavaScript & Css files)
 * - path should be rooted on base directory for javascript/css files
 * - Do not provide extentions
 * 
 */
class CoreView {

    public $title = null;   ///<    Title element of %HTML Document for "this page"
    public $icon = null;       ///<    Icon element of %HTML Document for "this page"
    public $desc = "site description";   ///<    content attribute of meta with "description" name attribute for "this page"
    public $keys = "keywords";     ///<    content attribute of meta with "keyword" name attribute for "this page"
    public $cssArray = null;    ///<    Array for storing custom CSS files to be applied to "this page"
    public $jsArray = null; ///<    Array for storing JavaScript file names to be applied to "this page"
    public $template = ""; ///<    Template to apply to "this page"  
    public $__staticLoadAllowed = false;  ///<    If set false (which is default) the VIEW can not be loaded statically (without any controller)
    public $defaultCssArray = null;  ///<    Array for storing CSS files to be applied to all pages by default
    public $defaultJsArray = null;    ///<    Array for storing JavaScript files to be applied to all pages by default
    public $includeDefaultCss = true;   ///<    Should apply default CSS files to "this page"?
    public $includeDefaultJs = true;    ///<    Should apply default JavaScript files to "this page"?
    // Reference to Core
    public $core;   ///< A reference to $core

    // Public & Private Methods

    public function __construct($core) {
        $this->core = $core;
    }

    /**
     * Functions to call from View classes
     */
    //@{

    /**
     * Used to treat the view as a Static page - i.e. No controller is needed to view this 
     * page. You must call this function to make the view static
     */
    public function setStatic() {
        $this->__staticLoadAllowed = true;
    }

    /**
     * Call this function within your View classes to get generated %HTML string of a form. \n
     * - You must load the form (using CoreController::loadForm() ) & call CoreForm::sendToView() within your Controller class . See CoreForm documentation 
     * @param string $formClassName - name of the form - this form must exist in VIEW/forms directory.
     * @return string %HTML data of the form, or an error string if the form was not set within controller.
     */
    public function form($formClassName) {
        return (isset($this->core->formData[$formClassName])) ? ($this->core->formData[$formClassName]) : ("Error: $formClassName form not found!");
    }
    

    //@}
    
    /**
     * Similar to Funcs::getStatusMsg()
     */
    
    public function msg(){
        return $this->core->funcs->getStatusMsg();
    }


    /**
     * @name Templating Functions
     * 
     * You should ONLY call these functions in your template file. Never call these in your controller/view
     */
    //@{

    /**
     * Generate %HTML to include necessary CSS files for your pages
     * 
     * For example, see templates/WhiteLove/index.php
     * 
     *  - Templating Function, call in your template file.
     * 
     *  @return string | generated %HTML 
     */
    public function printCss() {
        $html = "<!-- CSS -->";
        // Print Default
        if ($this->includeDefaultCss && isset($this->defaultCssArray)) {
            foreach ($this->defaultCssArray as $css_i) {
                $siteTheme = $this->template;
                $html .= '<LINK href="' . BASE_URL . "/" . TEMPLATE_DIR . "/" . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
        // Print others
        if (isset($this->cssArray)) {
            foreach ($this->cssArray as $css_i) {
                $html .= '<LINK href="' . BASE_URL . "/" . TEMPLATE_DIR . "/" . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
        return $html;
    }

    /**
     * Generate %HTML to include necessary JavaScript files for your pages
     * 
     * For example, see templates/WhiteLove/index.php
     * 
     *  - Templating Function, call in your template file.
     * 
     *  @return string | generated %HTML 
     */
    public function printJs() {
        $html = "<!-- Js -->";
        // Print Default
        if ($this->includeDefaultJs && isset($this->defaultJsArray)) {
            foreach ($this->defaultJsArray as $js_i) {
                $html .= "<script src = '" . BASE_URL . "/" . JS_DIR . "/$js_i.js'></script>";
            }
        }
        // Print others
        if (isset($this->jsArray)) {
            foreach ($this->jsArray as $js_i) {
                $html .= "<script src = '" . BASE_URL . "/" . JS_DIR . "/$js_i.js'></script>";
            }
        }
        return $html;
    }

    //@}
}

?>