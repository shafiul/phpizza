<?php

/**
 * \brief All VIEW classes should extend this class
 * 
 * @author Shafiul Azam
 * @author Put your name here!
 * 
 * All view classes (classes in VIEW folder) should extend this class & implement the abstract functions 
 * defined in this class.
 * 
 * You should define additional functions in this class, to generate necessary %HTML for your pages.
 * 
 * You should call these functions in appropriate places in your template file. For example, see templates/WhiteLove/index.php (the default template file)
 * 
 * You should define these functions abstract & implement in your VIEW classes.
 */

abstract class CustomView extends CoreView{
    
    /**
     * Set default CSS & JavaScript files for all pages
     */
    
    public function __construct() {
        $this->defaultCssArray = array("style");
        $this->defaultJsArray = array("jquery/jquery_latest");
    }
    
    // Functions to implement in your views
    
    /**
     * A custom function. Called inside template file to print the main body of the %HTML document
     */
    
    abstract public function printMainPageContent(); // Page's main entry
}

?>
