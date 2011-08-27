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

class Core{
    public $funcs;
    public $html;
    public $validate;
    public $view;
    public $controller;
    public $page;   //  Which page we are in?
    public $functionToCall; //  Which function to call inside Controller
    public $formData;
    // Others
    public $theme;
    private $data;
    
    // Load sttus
    public $controllerLoaded = false;
    public $viewLoaded = false;        
    public $modelLoaded = false;   // Only for default model
    
    // vars for internal use. Don't use/depend on any of these in your code
     
    // constructor
    
    public function __construct() {
        $this->html = new HTML();
        $this->funcs = new Funcs($this);
        $this->validate = new Validator($this);
        $this->formData = array();
        // Theme
        $this->theme = SITE_THEME;  //  Can lode from DB too.
    }
    
    /* Loaders */
    
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
    
    
    public function loadCustomClass($className){
        $classPath = dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/class/$className.php";
        return $this->safeRequireOnce($classPath);
    }
    
    public function loadCustomFunction($funcName){
        $classPath = dirname(__FILE__) . "/../../" . CUSTOM_DIR . "/funcs/$className.php";
        return $this->safeRequireOnce($classPath);
    }
    
    public function loadForm($formName){
        $classPath = dirname(__FILE__) . "/../../" . FORMS_DIR . "/$formName.php";
        return $this->safeRequireOnce($classPath);
    }
    
    /* Useful functions for index page */
    
    public function loadMVC($page){
        $this->findPage($page);
        // Load Defaults
        $this->loadModel($this->page);
        $this->loadController($this->page);
        $this->generateControllerObject();  // Controller Called!
        $this->loadView($this->page);
        
    }
    
    
    
    /* Template Related */
    
    public function setTemplate($theme){
        $this->theme = $theme;
    }
    
    public function loadTemplate(){
        if($this->viewLoaded){
            $template = $this->theme;
            $templateIndex = dirname(__FILE__) . "/../../" . TEMPLATE_DIR . "/$template/index.php";
            if(!$this->safeRequireOnce($templateIndex))
                $this->debug ("Template file not found!");
        }
    }
    
    
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


    // Data passing across controller-view 
    
    public function setData($id,$data){
        $this->data[$id] = $data;
    }
    
    public function getData($id){
        if(isset ($this->data[$id]))
            return $this->data[$id];
        else
            return false;
    }
    
    // Form Related
    public function getForm($formClassName){
        $formClassName = strtolower($formClassName);
//        print_r($this->formData);
        return (isset ($this->formData[$formClassName]))?($this->formData[$formClassName]):("Error: $formClassName form not found!");
    }
    // Utility Functions
    
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
        $this->debug("Page: " . $this->page);
    }
    
    public function debug($str){
        if(DEBUG_MODE)
            echo "<br /><pre>$str</pre>";
    }
    
    public function safeRequireOnce($filename){
        if(file_exists($filename)){
            require_once $filename;
            return true;
        }else{
            $this->debug ("File $filename Not found!");
            return false;
        }
    }
    
    
}

?>