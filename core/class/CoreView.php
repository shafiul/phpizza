<?php

/**
 * \brief All view classes should extend this CoreView class!
 * 
 * @author Shafiul Azam
 * 
 * 
 */
class CoreView {

    public $title = null;   ///<    Title element of %HTML output.
    public $icon = null;       ///<    Icon element of %HTML output.
    public $desc = 'Powered by PHPizza MVC Framework';   ///<    "Description" meta-tag of %HTML output.
    public $keys = 'phpizza';     ///<    "Keywords" meta-tag of %HTML output.
    public $cssArray = null;    ///<    Array. Array elements are css filenames - must be available under your theme's "css" directory. Do not provide ".css" after filenames.
    public $externalCssArray = null;    ///< Array to include CSS files outside your theme's "css" directory. These files will be included as-is, keeping the path intact. Do not provide ".css" after filenames.
    public $jsArray = null; ///<    Array. Array elements are JavaScript file names to be included to the %HTML output. These files should reside under "client/js" directory. Do not provide ".js" after filenames.
    public $template = ''; ///<    Name of the template. Do not modify if you're going to use the default theme specified in your config.php file.  
    public $__staticLoadAllowed = false;  ///<    If set to false (which is default) this VIEW can not be loaded statically (without loading any controller)
    public $defaultCssArray = null;  ///<    Array. Array elements are css filenames. These CSS files should be included to ALL %HTML pages of your project. These files should be put under your theme's "css" directory. Do not provide ".css" after filenames.
    public $defaultJsArray = null;    ///<    Array. Array Elements are JavaScript filenames to be included to all the %HTML pages of your project. These files should reside under "client/js" directory. Do not provide ".js" after filenames.
    public $includeDefaultCss = true;   ///<    If set true, filenames specified by $defaultCssArray are included to %HTML output of current page.
    public $includeDefaultJs = true;    ///<    If set true, filenames specified by $defaultJsArray are included to %HTML output of current page.
    // Reference to Core
    private $core;   ///< A reference to $core

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
        return (isset($this->core->formData[$formClassName])) ? ($this->core->formData[$formClassName]) : ('Error: ' . $formClassName . ' form not found!');
    }

    //@}

    /**
     * Similar to Funcs::getStatusMsg()
     */
    public function msg() {
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
        $html = '<!-- CSS -->';
        // Print Default
        if ($this->includeDefaultCss && isset($this->defaultCssArray)) {
            foreach ($this->defaultCssArray as $css_i) {
                $siteTheme = $this->template;
                $html .= '<LINK href="'  . TEMPLATE_URL . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
        // Print others
        if (isset($this->cssArray)) {
            foreach ($this->cssArray as $css_i) {
                $html .= '<LINK href="' . TEMPLATE_URL . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
        // Print external CSS files
        if (isset($this->externalCssArray)) {
            foreach ($this->externalCssArray as $css_i) {
                $html .= '<LINK href="' . $css_i . '.css' . '" rel="stylesheet" type="text/css">';
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
                $html .= "<script src = '" . JS_URL . "$js_i.js'></script>";
            }
        }
        // Print others
        if (isset($this->jsArray)) {
            foreach ($this->jsArray as $js_i) {
                $html .= "<script src = '" . JS_URL . "$js_i.js'></script>";
            }
        }
        return $html;
    }

    //@}
}

?>