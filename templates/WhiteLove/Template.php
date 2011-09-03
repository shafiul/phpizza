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

abstract class Template extends CoreView{
    
    /**
     * Set default CSS & JavaScript files for all pages
     */
    
    public function __construct() {
        $this->defaultCssArray = array("style");
        $this->defaultJsArray = array("jquery/jquery_latest");
        // a dummy headline
        $this->headline = "A dummy headline";
    }
    
    // Functions to implement in your views
    
    /**
     * @name Recommended Functions for the Template class
     * 
     * It is highly recommended that a Template class should have following abstract functions. 
     * These functions are too much common and can be used in almost all websites. 
     * So, use following function names & call them appropriately in your template's index.php page.
     */
    
    //@{
    
    /**
     * Called inside template file to print the headings body of the %HTML document 
     * Can leave as a abstract function, or you can implement the body of the function here, if suitable.
     */
    
    public function header(){
        echo '
            <h1><a href="' . url('index') .'">Ki Obosthaaa!</a></h1>
                <h2>Welcome to Pizza MVC framework!</h2>
            ';
    }


    /**
     * Called inside template file to print the "main" body of the %HTML document
     */
    
    abstract public function mainContent(); // Page's main entry
    
    //@}
}

?>
