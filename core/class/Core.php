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
require dirname(__FILE__) . "/HTML.php";
require dirname(__FILE__) . "/Funcs.php";

require dirname(__FILE__) . "/CoreValidator.php";

// Helper Functions
require dirname(__FILE__) . "/../funcs/general.php";

// Required Custom Classes

require dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/Validator.php";
require dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/CustomModel.php";

/** \brief The Most important class! 
 * 
 * @author Shafiul Azam
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
    public $template;  ///<    Name of the template. This must be name of the template's folder under "templates" directory.
    public $templateFileName;   ///< name of the file to load under this template's directory. Default value is "index.php". You can change it before calling loadView()
    private $data;  ///<    Key-value array for containing variables, which are passed from Controller to View.
    private $isStatic; ///< true if the page is static: no controller to load, view automatically called.
    // Load sttus
    public $controllerLoaded = false;   ///<    Boolean, true if controller class loaded.
    public $viewLoaded = false;         ///<    Boolean, true if view class loaded.        
//    public $modelLoaded = false;        ///<    Boolean, true if "Default" model class loaded. See documentation
    
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
        // Set some default characteristics
        $this->isStatic = false;
        // init some member vars
        $this->formData = array();
        // Set site template
        $this->template = SITE_THEME;  //  Can load from DB too.
        $this->templateFileName = "index.php";
    }
    
    /* Loaders */
    
    /**
     * Use this function to Load a Model class. You can load any number of model classes.
     * Call this function within your constructor. If not called, the default Model gets loaded automatically.
     * @param string $model name of the Model class. This class must reside under MODEL directory.
     */
    
    public function loadModel($model){
        $filename = dirname(__FILE__) . "/../../" . MODEL_DIR . "/$model.php";
        require $filename;
    }
    
    /**
     * Use this function to Load a View class. You should load ONLY ONE view class for a "page".
     * Call this function within your constructor EXPLICITLY. If you forget to call this function, No VIEW will be loaded!
     *  - However, this function is automatically called by the Core if user is requesting some "static" page (page with no controller).
     * @param string $view name of the View class. This class must extend CustomView & reside under VIEW/pages/ directory.
     *  - if you don't pass the parameter, default view for the page gets loaded.
     */
    
    public function loadView($view=""){
        if(empty ($view))
            $view = $this->page;
        // First, load the CoreView Class
        require dirname(__FILE__) . "/CoreView.php";
        // Next, load template class from template folder
        $template = $this->template;
        require  dirname(__FILE__) . "/../../" . TEMPLATE_DIR . "/$template/Template.php";
        // Load the specific VIEW class.
        $filename = dirname(__FILE__) . "/../../" . VIEW_DIR . "/pages/$view.php";
        $this->viewLoaded = true;
        require $filename;
    }
    
    /**
     * Use this function where appropriate (maybe within Template class or in your VIEW classes) to load
     * the "%HTML Blocks" - you can find some sample classes in GeneralLinks and FormLinks classes.
     * @param string $block name of the file. This file must reside in VIEW/blocks/ directory. 
     */
    
    public function loadBlock($block){
        // You should load the Blocks custom class manually before calling this function.
//        require_once dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/Blocks.php";
        $filename = dirname(__FILE__) . "/../../" . VIEW_DIR . "/blocks/$block.php";
        require $filename;
    }
    
    /**
     * This function loads a Controller class. 
     * - You should NEVER call this function! As this function is automatically called by the framework.
     * 
     * @param string $controller name of the controller class
     */
    
    public function loadController($controller){
        $filename = dirname(__FILE__) . "/../../" . CONTROL_DIR . "/$controller.php";
        $this->controllerLoaded = true;
        if(file_exists($filename)){
            require $filename;
            // Also, generate the controller object & call "functionToCall"
            $this->generateControllerObject();  // Controller Called!
        }else{
            echo "Error 404: Page Not Found";
            exit();
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
    
    public function loadCustomFunctions($funcFile){
        $classPath = dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/funcs/$funcFile.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /**
     * Call this from your controller to load a Form
     * @param string $formName name of the class. This class must extend CoreForm & reside in VIEW/forms directory.
     * @return bool true in success, false otherwise 
     */
    
    public function loadForm($formName){
        // First include core form
        require_once dirname(__FILE__) . "/CoreForm.php";
        // Now include particular form
        $classPath = dirname(__FILE__) . "/../../" . FORMS_DIR . "/$formName.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /**
     * Loads necessary model classes. Must be called before database functionality.
     * 
     * Demo code is available at CustomModel class. So if your model class extends CustomModel, you do not need to call this function explicitly!
     * @param string $driver name of the database driver, i.e MySQL
     * @return bool true if success, false otherwise 
     */
    
    public function loadDatabaseDriver($driver = ""){
        // if driver empty load default
        if(empty($driver))
            $driver = DB_DRIVER;
        
        require_once dirname(__FILE__) . "/../../config/database.php";   //  Configuartion file loaded
        require_once dirname(__FILE__) . "/db/GenericDB.php";   //  Generic database loaded
        // Load implemented driver
        $classPath = dirname(__FILE__) . "/db/$driver.php";
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
    
//    public function setTemplate($theme){
//        $this->template = $theme;
//    }
    
    


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
        $formClassName = $formClassName;
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
//            $this->debug ("File $filename Not found!");
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
            echo "<pre>$str</pre>";
    }
    
    /* Useful functions for index page */
    
    /**
     * Used to load the default controller.
     * - You should NEVER call this function! As this function is automatically called by the framework.
     * @param string $page "The Page"
     * @return None
     */
    
    public function loadMVC($page){
        // Automatic Model, View loading no longer supported!
        $this->findPage($page);
        if($this->isStatic){
            // No controller. Load view
            $this->loadView();  //  Default view is loaded
        }else{
            // Load Controller.
            $this->loadController($this->page);
        }
        
    }
    
    /**
     * Loads necessary files (mainly index.php) from templates/<SELECTED TEMPLATE> folder.
     * - You should NEVER call this function! As this function is internally called by the framework. 
     */
    
    public function loadTemplate(){
        if($this->viewLoaded){
            $template = $this->template;
            $templateIndex = dirname(__FILE__) . "/../../" . TEMPLATE_DIR . "/$template/index.php";
            require $templateIndex;
        }
    }
    
    /**
     * Creates an object of the View class.
     * - You should NEVER call this function! As this function is automatically called by the framework. 
     */
    
    public function generateViewObject(){
        if($this->viewLoaded){
            $this->view = new View();
            // Check static permission
            if($this->isStatic && !$this->view->staticLoadAllowed){
                echo "Error: Loading this page statically is denied.";
                exit();
            }
            // Set the template: important
            $this->view->template = $this->template;
        }else{
            // Check if controller loaded
            if(!$this->controllerLoaded){
                // Invalid request. report 404
                header("HTTP/1.0 404 Not Found");
                echo "Error 404 Page not found!";
                exit(0);  
            }
//            $this->debug("View Not Loaded");
        }
    }
    
    // Controller related
    
    /**
     * Creates object of the Controller class. Also calls the function specified by "functionToCall"
     * - You should NEVER call this function! As this function is automatically called by the framework. 
     */
    
    public function generateControllerObject(){
        $this->controller = new Controller();
        if(method_exists($this->controller, $this->functionToCall))
            call_user_func(array($this->controller, $this->functionToCall));
        else{
            header("HTTP/1.0 404 Not Found");
                echo "Error 404: Requested controller-method not found!";
            exit();
        }
    }
    
    // Utility Functions
    
    /**
     * Used internally to find out the "page" & "functionToCall"
     * - THIS IS USED INTERNALLY, NEVER CALL THIS FUNCTION! 
     * @param string $URL the query string user provided
     * @return None 
     */
    
    private function findPage($URL){
        $pageArr  = explode("/", $URL);
        $numSegments = count($pageArr);
        
        if($numSegments == 1 && $pageArr[0] != "static"){
            $this->page = $URL;
            $this->functionToCall = DEFAULT_FUNCTION2CALL;
        }else{
            // Handle static pages first.
            if($pageArr[0] == "static"){
                // STATIC: No controller here.
                $this->isStatic = true;
                unset ($pageArr[0]);
                $this->page = implode("/", $pageArr);
            }else{
                // DYNAMIC
                // Check if full path exists
                $controllerPath = dirname(__FILE__) . "/../../" . CONTROL_DIR . "/$URL.php";
                if(file_exists($controllerPath)){
                    $this->page = $URL;
                    $this->functionToCall = DEFAULT_FUNCTION2CALL;
                }else{
                    // Check later.
                    $this->functionToCall = $pageArr[$numSegments - 1];
                    unset($pageArr[$numSegments - 1]);
                    $this->page = implode("/", $pageArr);
                }
            }    
        }
//        $this->debug("Page: " . $this->page . " FunctionToCall: " . $this->functionToCall);
    }
    
    //@}
    
    
}

?>