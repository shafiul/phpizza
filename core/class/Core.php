<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */
// Classes
require_once dirname(__FILE__) . "/HTML.php";
require_once dirname(__FILE__) . "/Funcs.php";
require_once dirname(__FILE__) . "/CoreForm.php";
require_once dirname(__FILE__) . "/CoreValidator.php";
require_once dirname(__FILE__) . "/CoreView.php";
// Helper Functions
require_once dirname(__FILE__) . "/../funcs/general.php";

// Required Custom Classes
require_once dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/CustomView.php";
require_once dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/Validator.php";

/** \brief The Most important class! 
 * 
 * This class contains everything you need. An object of this class, $core (global variable) is created
 * for you. Within controllers, views & templates, you can get access to this class by this code:
 * global $core;
 * In fact, this $core variable is the only thing you need. See it's member variables
 */

class Core{
    public $funcs;  ///<    An object of class: Funcs
    public $html;   ///<    An object of class: HTML
    public $validate;   ///<    An object of class:  Validator 
    public $view;   ///<    An object of class: CustomView
    public $controller; ///<    An object of class: Controller
    public $page;   ///<    cotains "The Page" - see documentation for more details
    public $functionToCall; ///<  contains the name of the function of constructor to call.
    public $formData;   ///<    Key-value Array for containing HTML strings for web forms
    // Others
    public $theme;  ///<    Name of the template
    private $data;  ///<    Key-value array for containing variables, which are passed from Controller to View.
    
    // Load sttus
    public $controllerLoaded = false;   ///<    Boolean, true if controller class loaded.
    public $viewLoaded = false;         ///<    Boolean, true if view class loaded.        
    public $modelLoaded = false;        ///<    Boolean, true if "Default" model class loaded. See documentation
    
    // vars for internal use. Don't use/depend on any of these in your code
     
    // constructor
    
    /**
     * Constractor.
     * - Initializes member variables
     * - Sets default template (in config/general.php )
     * @param None
     * @return None
     */
    
    public function __construct() {
        $this->html = new HTML();
        $this->funcs = new Funcs($this);
        $this->validate = new Validator($this);
        $this->formData = array();
        // Theme
        $this->theme = SITE_THEME;  //  Can lode from DB too.
    }
    
    /* Loaders */
    
    /**
     * Use this function to Load a Model class. You can load any number of model classes.
     * Call this function within your constructor. If not called, the default Model gets loaded automatically.
     * @param string $model name of the Model class. This class must reside under MODEL directory.
     * @return bool true in success, false in failure.
     */
    
    public function loadModel($model){
        $filename = dirname(__FILE__) . "/../../" . MODEL_DIR . "/$model.php";
        if(file_exists($filename)){
            $this->modelLoaded = true;
            require_once $filename;
            return true;
        }else{
            $this->debug ("File $filename Not found!");
            return false;
        }
    }
    
    /**
     * Use this function to Load a View class. You can load ONLY ONE view class for a "page".
     * Call this function within your constructor. If not called, the default view gets loaded.
     * @param string $view name of the View class. This class must extend CustomView & reside under VIEW directory.
     * @return bool true in success, false in failure.
     */
    
    public function loadView($view){
        if(!$this->viewLoaded){
            $filename = dirname(__FILE__) . "/../../" . VIEW_DIR . "/$view.php";
            if(file_exists($filename)){
                $this->viewLoaded = true;
                require_once $filename;
                return true;
            }else{
                $this->debug ("File $filename Not found!");
                return false;
            }
        }
    }
    
    /**
     * This function loads a Controller class. 
     * - You should NEVER call this function! As this function is automatically called by the framework.
     * 
     * @param string $controller name of the controller class
     * @return bool
     */
    
    public function loadController($controller){
        if(!$this->controllerLoaded){
            $filename = dirname(__FILE__) . "/../../" . CONTROL_DIR . "/$controller.php";
            if(file_exists($filename)){
                $this->controllerLoaded = true;
                require_once $filename;
                return true;
            }else{
                $this->debug ("File $filename Not found!");
                return false;
            }
        }
    }
    
    /**
     * Call this from your controller to load a "Custom Class"
     * @param string $className name of the class. This class must reside in CUSTOM/class directory.
     * @return bool true in success, false otherwise 
     */
    
    public function loadCustomClass($className){
        $classPath = dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/$className.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /**
     * Call this from your controller to load a "Custom Functions" file
     * @param string $funcFile name of the file. This file must reside in CUSTOM/funcs directory.
     * @return bool true in success, false otherwise 
     */
    
    public function loadCustomFunction($funcFile){
        $classPath = dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/funcs/$funcFile.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /**
     * Call this from your controller to load a Form
     * @param string $formName name of the class. This class must extend CoreForm & reside in VIEW/forms directory.
     * @return bool true in success, false otherwise 
     */
    
    public function loadForm($formName){
        $classPath = dirname(__FILE__) . "/../../" . FORMS_DIR . "/$formName.php";
        return $this->safeRequireOnce($classPath);
    }
    
    
    /* Template Related */
    
    
    /**
     * Call this withing your Controller to set a different template, other than the Default one.
     * This change will be valid only for the current "page"
     * - Call this function if you explicitly call loadView($view)
     * @param string $theme name of the template
     * @return None
     */
    
    public function setTemplate($theme){
        $this->theme = $theme;
    }
    
    


    // Data passing across controller-view 
    
    /**
     * Use this function within your controller to pass a variable to View.
     * Within View, you can get the data by calling getData() , $id is the ID of the variable.
     * @param string $id ID of the variable. You must use the same ID when you call getData() to retrie the variable
     * @param variable $data The actual variable you want to pass.
     * @return None 
     */
    
    public function setData($id,$data){
        $this->data[$id] = $data;
    }
    
    /**
     * Use this function within your View to retrive the variable you passed within your controller.
     * @param string $id ID you used when calling setData()
     * @return variable you passed using setData() - if you provide valid ID
     * @return bool false - if you provide invalid ID
     */
    
    public function getData($id){
        if(isset ($this->data[$id]))
            return $this->data[$id];
        else
            return false;
    }
    
    // Form Related
    
    /**
     * Call this function within your View to get html string of a form.
     * - Before calling this function, within your Controller prepare the form & call CoreForm::sendToView() , see CoreForm documentation 
     * @param string $formClassName name of the form - this form must exist in VIEW/forms directory.
     * @return string html data of the form, or an error string if the form was not set within controller.
     */
    
    public function getForm($formClassName){
        $formClassName = strtolower($formClassName);
//        print_r($this->formData);
        return (isset ($this->formData[$formClassName]))?($this->formData[$formClassName]):("Error: $formClassName form not found!");
    }
    
    
    
    
    /**
     * This function is used to safely load a php file. you can use it instead of require_once()
     * @param string $filename name of the file to load
     * @return bool true if file found, false otherwise. 
     */
    
    public function safeRequireOnce($filename){
        if(file_exists($filename)){
            require_once $filename;
            return true;
        }else{
            $this->debug ("File $filename Not found!");
            return false;
        }
    }
    
    
    /** @name Functions for Internal Use
     * These functions are used internally by the framework.
     * - You should NEVER call these functions! As they are automatically called by the framework.
     */
    
    //@{
    
    /**
     * Echoes the string provided as parameter $str if DEBUG_MODE is set true.
     * @param string $str the string to echo.
     */
    
    public function debug($str){
        if(DEBUG_MODE)
            echo "<br /><pre>$str</pre>";
    }
    
    /* Useful functions for index page */
    
    /**
     * Used to load the default model, view & controller.
     * - You should NEVER call this function! As this function is automatically called by the framework.
     * @param string $page "The Page"
     * @return None
     */
    
    public function loadMVC($page){
        $this->findPage($page);
        // Load Defaults
        $this->loadModel($this->page);
        $this->loadController($this->page);
        $this->generateControllerObject();  // Controller Called!
        $this->loadView($this->page);
        
    }
    
    /**
     * Loads necessary files (mainly index.php) from templates/<SELECTED TEMPLATE> folder.
     * - You should NEVER call this function! As this function is internally called by the framework. 
     */
    
    public function loadTemplate(){
        if($this->viewLoaded){
            $template = $this->theme;
            $templateIndex = dirname(__FILE__) . "/../../" . TEMPLATE_DIR . "/$template/index.php";
            if(!$this->safeRequireOnce($templateIndex))
                $this->debug ("Template file not found!");
        }
    }
    
    /**
     * Creates an object of the View class.
     * - You should NEVER call this function! As this function is automatically called by the framework. 
     */
    
    public function generateViewObject(){
        if($this->viewLoaded){
            $this->view = new View();
            // Set the template: important
            $this->view->theme = $this->theme;
        }else{
            // Check if controller loaded
            if(!$this->controllerLoaded){
                // Invalid request. report 404
                echo "Error 404 Page not found!";
                exit(0);
            }
            $this->debug("View Not Loaded");
        }
    }
    
    // Controller related
    
    /**
     * Creates object of the Controller class. Also calls the function specified by "functionToCall"
     * - You should NEVER call this function! As this function is automatically called by the framework. 
     */
    
    public function generateControllerObject(){
        if($this->controllerLoaded){
            $this->controller = new Controller();
            
            if(CONTROLLER_FUNC_CALL_ENABLED){
                if(method_exists($this->controller, $this->functionToCall))
                    call_user_func(array($this->controller, $this->functionToCall));
                else{
                    echo "Error 404: Controller function not found!";
                    exit();
                }
                    
            }
        }
    }
    
    // Utility Functions
    
    /**
     * Used internally to find out the "page" & "functionToCall"
     * - THIS IS USED INTERNALLY, NEVER CALL THIS FUNCTION! 
     * @param string $page the query string user provided
     * @return None 
     */
    
    public function findPage($page){
        $pageArr  = explode("/", $page);
        $numSegments = count($pageArr);
        
        if(!CONTROLLER_FUNC_CALL_ENABLED){
            $this->page = $page;
            return;
        }
        
        if($numSegments == 1){
            $this->page = $page;
            $this->functionToCall = "index";
        }else{
            // Check if full path exists
            $controllerPath = dirname(__FILE__) . "/../../" . CONTROL_DIR . "/$page.php";
            $viewPath = dirname(__FILE__) . "/../../" . VIEW_DIR . "/$page.php";
            if(file_exists($controllerPath) || file_exists($viewPath)){
                $this->page = $page;
                $this->functionToCall = "index";
            }else{
                // Check later.
                $this->functionToCall = $pageArr[$numSegments - 1];
                unset($pageArr[$numSegments - 1]);
                $this->page = implode("/", $pageArr);
            }
        }
//        $this->debug("Page: " . $this->page);
    }
    
    //@}
    
    
}

?>