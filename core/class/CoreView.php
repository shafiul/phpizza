<?php

/*
 * Description of pageSkeleton
 *
 * Shafiul Azam
 * ishafiul@gmail.com
 * Project Manager
 */

/**
 * \brief Basic (core version) class for your VIEWs
 * 
 * @author Shafiul Azam
 * 
 * You can (in fact, you SHOULD) extend functionality to this class in the CustomView class.
 * 
 * Convention while providin file names: (JavaScript & Css files)
 * - path should be rooted on base directory for javascript/css files
 * - Do not provide extentions
 * 
 */
class CoreView{

    public $title = null;   ///<    Title element of %HTML Document for "this page"
    public $icon = null;       ///<    Icon element of %HTML Document for "this page"
    public $desc = "site description";   ///<    content attribute of meta with "description" name attribute for "this page"
    public $keys = "keywords";     ///<    content attribute of meta with "keyword" name attribute for "this page"
    public $cssArray = null;    ///<    Array for storing custom CSS files to be applied to "this page"
    public $jsArray = null; ///<    Array for storing JavaScript file names to be applied to "this page"
    public $template = ""; ///<    Template to apply to "this page"  
    public $staticLoadAllowed = false;  ///<    If set false (which is default) the VIEW can not be loaded statically (without any controller)
    
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
     * Call this function inside your code (controller or view) to create an %HTML div element - which user 
     * can hide or show by clicking a title.
     * 
     * @param string $title heading of the div, also a link to click to toggle visibility   
     * @param string $content   %HTML content of the div
     * @param bool $initiallyVisible if false, the %HTML content is initially hidden. $title is always visible
     * @param string $divId ID attribute for the div
     * @param string $titleType %HTML to wrap the $title
     * @return string   Generated %HTML string for the toggable div (with $title as heading) 
     */
   
    public function toggleDiv($title, $content, $initiallyVisible = false, $divId = "", $titleType = "h4") {
        $display = ($initiallyVisible) ? ("block") : ("none");
        $divId = ($divId) ? ($divId) : ("tdiv-" . rand());
        
        $html = "<$titleType title = 'Click to expand' onclick = \"$('.toggledDivs').hide(); $('#$divId').toggle();\" style = 'cursor:pointer; color:#817339;'>$title</$titleType>";
        $html .= "<div style = 'display:$display;' class = 'toggledDivs' id = '$divId'>";
        $html .= "$content</div><br />";
        return $html;
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
        if ($this->includeDefaultCss && isset ($this->defaultCssArray)) {
            foreach ($this->defaultCssArray as $css_i) {
                $siteTheme = $this->template;
                $html .= '<LINK href="' . BASE_URL . "/" . TEMPLATE_DIR . "/" . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
        // Print others
        if (isset ($this->cssArray)) {
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
        if ($this->includeDefaultJs && isset ($this->defaultJsArray)) {
            foreach ($this->defaultJsArray as $js_i) {
                $html .= "<script src = '" . BASE_URL . "/" . JS_DIR . "/$js_i.js'></script>";
            }
        }
        // Print others
        if (isset ($this->jsArray)) {
            foreach ($this->jsArray as $js_i) {
                $html .= "<script src = '" . BASE_URL . "/" . JS_DIR . "/$js_i.js'></script>";
            }
        }
        return $html;
    }
    
    //@}

}
?>