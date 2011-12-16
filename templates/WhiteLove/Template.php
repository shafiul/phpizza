<?php

/**
 * \brief All VIEW classes should extend this class. All themes/templates should have their own Template class.
 * 
 * @author Shafiul Azam
 * @author Put your name here!
 * 
 * !!! Functions of this class is called in the template's index.php page !!!
 * 
 * All view classes (classes in VIEW/pages folder) should extend this class & implement the abstract functions 
 * defined in this class.
 * 
 * You should define additional functions in this class, to generate necessary %HTML for your pages.
 * 
 * You should call these functions in appropriate places in your template file. For example, see templates/WhiteLove/index.php (the default template file)
 * 
 * You should define these functions abstract & implement in your VIEW classes.
 */

abstract class Template extends CoreView{
    
    // vars
    
    public $heading;    ///< A custom (template-specific) variable. For setting the Headline of the page
    private $core;      ///< Override parent's


    /**
     * Perorms some routine tasks:
     *  - Sets default CSS & JavaScript files for all pages
     *  - Loads the custom "Blocks" class for your convenience.
     */
    
    public function __construct($core) {
        // First call parent's Constructor
        parent::__construct($core);
        
        $this->core = $core;
        
        // Set some other parameters
        $this->defaultCssArray = array("style");
        $this->defaultJsArray = array("jquery/jquery_latest");
        // a dummy headline
        $this->heading = "A dummy headline";
    }
    
    // Functions to implement in your views
    
    /**
     * @name Recommended Functions for the Template class
     * 
     * It is highly recommended that a Template class should have following functions. 
     * These functions are too much common and can be used in almost all websites. 
     * So, use following function names & call them appropriately in your template's index.php page.
     * 
     * You can define the body of this functions, or leave the body to be implemented in the VIEW classes. 
     * 
     * If the functionality is totally VIEW-specific (like setting the main %HTML contents of a page), you should define the 
     * functions as abstract. Otherwise, if you think functionality is common for all VIEWs, you may define the body of the function(s) here. 
     * Note that, developers can easily override the functions in specific VIEW class, so the technique is flexible.
     */
    
    //@{
    
    /**
     * Called inside template file to print the headings body of the %HTML document 
     * Can leave as a abstract function, or you can implement the body of the function here, if suitable.
     */
    
    public function header(){
        echo '
            <h1><a href="' . url('index') .'"><i>PHPizza</i></a></h1>
                <h2>' . $this->heading . '</h2>
            ';
    }


    /**
     * Function for the "main entry" of the page. Since this is totally page-dependant, 
     * this function should be left as Abstract, to be implemented in the view of the page. 
     * 
     * Called inside template file to print the "main" body of the %HTML document
     */
    
    abstract public function mainContent(); // Page's main entry
    
    /**
     * General purpose function for printing sidebars. In the following function, you can 
     * implement the "default" sidebars applicable to all views. However, if you need custom sidebar 
     * in any view, you can easily override this function.
     * @param string $alignment - possible values: "left","right"
     */
    
    public function sidebar($alignment) {
        switch($alignment){
            case 'left':
                // No left sidebar
                break;
            case 'right':
                // print general links
                $i = $this->core->loadBlock("GeneralLinks");
                echo $i->get();
                // print links to forms
                $i = $this->core->loadBlock("FormLinks");
                echo $i->get();
                break;
        }
    }
    
    /**
     * Footer of the template. Footers does not normally change in Views. So, you can staticly determine the page 
     * footer here. 
     */
    
    public function footer(){
        
    }
    
    //@}
}

?>
