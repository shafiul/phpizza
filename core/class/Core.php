<?php

// define some paths

$pizza__CorePath =  PROJECT_DIR . "/core";
$pizza__CustomPath = PROJECT_DIR . "/" . CUSTOM_DIR;

// Include required Classes
require "$pizza__CorePath/class/HTML.php";
require "$pizza__CorePath/class/Funcs.php";

require "$pizza__CorePath/class/CoreValidator.php";

// Helper Functions
require "$pizza__CorePath/funcs/general.php";

// Required Custom Classes
require "$pizza__CustomPath/class/Validator.php";

// Autoloader

/**
 * Autoloading Custom Classes - custom classes exist in custom/class directory.
 * @param type $className 
 */

function __autoload($className){
    require PROJECT_DIR . "/custom/class/$className.php";
}

/** \brief The Most important class - makes the framework working! 
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
    
    // vars for internal use. Don't use/depend on any of these in your code
    
    private $__coreDir;
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
        // Set up internal vars
        $this->__coreDir = PROJECT_DIR . "/core";
    }
    
    /* Loaders */
    
    /**
     * Use this function to Load a Model class. You can load any number of model classes.
     * 
     * Call this function within your constructor. If not called, the default Model gets loaded automatically.
     * @param string $model name of the Model class. This class must reside under MODEL directory.
     */
    
    public function loadModel($model,&$var){
        // First include once core model class
        require_once $this->__coreDir . "/class/CoreModel.php";
        // Load DB driver
        $this->loadDatabaseDriver();
        $filename = PROJECT_DIR . "/" . MODEL_DIR . "/$model.php";
        require $filename;
        $className = end(explode("/", $model));
        $var = new $className($this);
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
        require $this->__coreDir . "/class/CoreView.php";
        // Next, load template class from template folder
        $template = $this->template;
        require  PROJECT_DIR . "/" . TEMPLATE_DIR . "/$template/Template.php";
        // Load the specific VIEW class.
        $filename = PROJECT_DIR . "/" . VIEW_DIR . "/pages/$view.php";
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
        $filename = PROJECT_DIR . "/" . VIEW_DIR . "/blocks/$block.php";
        require $filename;
    }
    
    /**
     * This function loads a Controller class. 
     * - You should NEVER call this function! As this function is automatically called by the framework.
     * 
     * @param string $controller name of the controller class
     */
    
    private function loadController($controller){
        // Load Core Controller
        require $this->__coreDir . "/class/CoreController.php";
        // Load this specific controller
        $filename = PROJECT_DIR . "/" . CONTROL_DIR . "/$controller.php";
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
        $classPath = PROJECT_DIR . "/" . CUSTOM_DIR . "/class/$className.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /**
     * Call this from your controller to load a "Custom Functions" file
     * @param string $funcFile name of the file. This file must reside in CUSTOM/funcs directory.
     * @return bool true in success, false otherwise 
     */
    
    public function loadCustomFunctions($funcFile){
        $classPath = PROJECT_DIR . "/" . CUSTOM_DIR . "/funcs/$funcFile.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /**
     * Call this from your controller to load a Form
     * 
     * WARNING: No directory hierarchy is supported under VIEW/forms directory. That means, all of your forms 
     * must reside in VIEW/forms directory, you can not create directory & load forms from them!
     * 
     * @param string $formName name of the class. This class must extend CoreForm & reside in VIEW/forms directory.
     * @return bool true in success, false otherwise 
     */
    
    public function loadForm($formName,&$var){
        // First include core form
        require_once $this->__coreDir . "/class/CoreForm.php";
        // Now include particular form
        $classPath = PROJECT_DIR . "/" . FORMS_DIR . "/$formName.php";
        require $classPath;
        $var = new $formName($this);
    }
    
    /**
     * Loads necessary model classes. Must be called before database functionality.
     * 
     * Demo code is available at CustomModel class. So if your model class extends CustomModel, you do not need to call this function explicitly!
     * @param string $driver name of the database driver, i.e MySQL
     */
    
    public function loadDatabaseDriver(){
        $driver = DB_DRIVER;
        require_once $this->__coreDir . "/class/db/GenericDB.php";   //  Generic database loaded
        // Load implemented driver
        require_once $this->__coreDir . "/class/db/$driver.php";
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
     * 
     * It also calls generateViewObject() followed by loadTemplate() to finish generating the page.
     * 
     * Warning:
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
        // Create VIEW
        $this->generateViewObject();
        // Load Site Template
        $this->loadTemplate();
        
    }
    
    /**
     * Loads necessary files (mainly index.php) from templates/<SELECTED TEMPLATE> folder.
     * - You should NEVER call this function! As this function is internally called by the framework. 
     */
    
    private function loadTemplate(){
        if($this->viewLoaded){
            $template = $this->template;
            $templateIndex = PROJECT_DIR . "/" . TEMPLATE_DIR . "/$template/" . $this->templateFileName;
            require $templateIndex;
        }
    }
    
    /**
     * Creates an object of the View class.
     * - You should NEVER call this function! As this function is automatically called by the framework. 
     */
    
    private function generateViewObject(){
        if($this->viewLoaded){
            $this->view = new View($this);
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
        $this->controller = new Controller($this);
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
                $controllerPath = PROJECT_DIR . "/" . CONTROL_DIR . "/$URL.php";
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