<?php

/**
 * Description of pageSkeleton
 *
 * Shafiul Azam
 * ishafiul@gmail.com
 * Project Manager
 */

//    db_connect();

class CoreView extends HTML {

    public $title = null;
    public $icon = null;
    public $desc = "site description";
    public $keys = "keywords";
    public $cssArray = null;
    public $jsArray = null;
    public $theme = "";
    public $includeDefaultCss = true;
    public $includeDefaultJs = true;
    
    // Private vars
    private $defaultCssArray = array("style");
    private $defaultJsArray = array("jquery/jquery_latest");
    
    public function __construct() {
    }
    
    // Public & Private Methods
    
   
    public function toggleDiv($title, $content, $initiallyVisible = false, $divId = "", $titleType = "h4") {
        $display = ($initiallyVisible) ? ("block") : ("none");
        $divId = ($divId) ? ($divId) : ("tdiv-" . rand());
        
        $html = "<$titleType title = 'Click to expand' onclick = \"$('.toggledDivs').hide(); $('#$divId').toggle();\" style = 'cursor:pointer; color:#817339;'>$title</$titleType>";
        $html .= "<div style = 'display:$display;' class = 'toggledDivs' id = '$divId'>";
        $html .= "$content</div><br />";
        return $html;
    }

    

    public function printCss() {
        echo "<!-- CSS -->";
        // Print Default
        if ($this->includeDefaultCss && isset ($this->defaultCssArray)) {
            foreach ($this->defaultCssArray as $css_i) {
                $siteTheme = $this->theme;
                echo '<LINK href="' . BASE_URL . "/" . TEMPLATE_DIR . "/" . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
        // Print others
        if (isset ($this->cssArray)) {
            foreach ($this->cssArray as $css_i) {
                echo '<LINK href="' . BASE_URL . "/" . TEMPLATE_DIR . "/" . $siteTheme . "/css/$css_i.css" . '" rel="stylesheet" type="text/css">';
            }
        }
    }

    public function printJs() {
        echo "<!-- Js -->";
        // Print Default
        if ($this->includeDefaultJs && isset ($this->defaultJsArray)) {
            foreach ($this->defaultJsArray as $js_i) {
                echo "<script src = '" . BASE_URL . "/" . JS_DIR . "/$js_i.js'></script>";
            }
        }
        // Print others
        if (isset ($this->jsArray)) {
            foreach ($this->jsArray as $js_i) {
                echo "<script src = '" . BASE_URL . "/" . JS_DIR . "/$js_i.js'></script>";
            }
        }
    }

}
?>