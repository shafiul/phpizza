<?php

/**
 * \brief All controller classes must extend this class
 */
class CoreController {

    public $core = null;   ///< A reference to the $core variable
    public $funcs = null;
    public $validate = null;

    /**
     * Constructor
     * @param type $core 
     */

    public function __construct($core) {
        $this->core = $core;
        $this->funcs = $core->funcs;
        $this->validate = $core->validate;
    }

    /**
     * Please see Core::loadModel()
     */
    public function loadModel($model) {
        return $this->core->loadModel($model);
    }
    
    /**
     * Please see Core::loadView()
     */
    
    public function loadView($view="") {
        return $this->core->loadView($view);
    }



    /**
     * Please see Core::loadBlock()
     */
    public function loadBlock($block) {
        return $this->core->loadBlock($block);
    }

    /**
     * Call this from your controller to load a Form
     * 
     * WARNING: No directory hierarchy is supported under VIEW/forms directory. That means, all of your forms 
     * must reside in VIEW/forms directory, you can not create directory & load forms from them!
     * 
     * @param string $formName name of the class. This class must extend CoreForm & reside in VIEW/forms directory.
     * @return object of newly created class
     */
    public function loadForm($formName) {
        // First include core form
        require_once $this->core->coreDir . "/class/CoreForm.php";
        // Now include particular form
        $classPath = PROJECT_DIR . "/" . FORMS_DIR . "/$formName.php";
        require $classPath;
        $var = new $formName($this->core);
        return $var;
    }

    /**
     * Call this from your controller to load a "Custom Functions" file
     * @param string $funcFile name of the file. This file must reside in CUSTOM/funcs directory.
     * @return bool true in success, false otherwise 
     */
    public function load3p($fileName) {
        require_once PROJECT_DIR . '/' . THIRDPARTY_DIR . '/' . $fileName . '.php';
    }

    /**
     *
     * @param type $funcFile
     * @return type 
     */
    public function loadCustomFunctions($funcFile) {
        $classPath = PROJECT_DIR . "/" . CUSTOM_DIR . "/funcs/$funcFile.php";
        return $this->safeRequireOnce($classPath);
    }

    /**
     * Get instance of an autoloaded class. This can be autoloaded Custom Class or Model
     * @param type $className
     * @param string $type - This can be any of 'custom' or 'model' or 'func'
     * @return object - instance of the autoloaded class if successful. FALSE otherwise 
     */
    public function autoload($className, $type='custom') {
        return (isset($this->core->autoloadedData[$type][$className])) ? ($this->core->autoloadedData[$type][$className]) : (false);
    }

    // Data passing across controller-view 

    /**
     * Use this function within your controller to pass a variable to your View class. \n 
     * Within View, you can get the data as a member variable, writing:
     * \code
     * $this->id
     * \endcode
     * \see Also see this function to pass variable -  Core::setData() 
     * @param string $id ID of the variable. You must use the same ID when you call getData() to retrie the variable
     * @param variable $data The actual variable you want to pass.
     * @return None 
     */
    public function data($id, $data) {
        $this->core->cData[$id] = $data;
    }

    /**
     * Similar to Funcs::setStatusMsg()
     */
    public function msg($msg, $status="") {
        $this->funcs->setStatusMsg($msg, $status);
    }
    
    
    /**
     * Similar to Funcs::getStatusMsg()
     */
    
    public function getMsg(){
        return $this->funcs->getStatusMsg();
    }

    

    /**
     * Similar to Funcs::messageExit()
     */
    public function kill($msg='', $type=MSGBOX_ERROR, $redirectURL='') {
        $this->funcs->messageExit($msg, $type, $redirectURL);
    }
    
    
    /**
     * @name PHP Session Related \n
     * If you are using any of theese functions, make sure you started PHP Session first. Following code can safely start a PHP session: \n
     * 
     * \code
     * if(!session_id()){
     *      session_start();
     * }
     * \endcode
     * 
     */
    
    //@{
    
    /**
     *  Similar to Funcs::setSessData()
     */
    public function setSessData($id, $data) {
        $_SESSION[$id] = $data;
    }
    
    /**
     * Similar to Funcs::getSessData()
     */

    public function getSessData($id) {
        if (isset($_SESSION[$id]))
            return $_SESSION[$id];
        else
            return null;
    }
    
    /** similar to Funcs::unsetSessData()
     *
     */
    
    public function unsetSessData($id){
        unset($_SESSION[$id]);
    }
    
    //@}
    
    

    /**
     * Echoes the string provided as parameter $str if DEBUG_MODE is set true.
     * @param string $str the string to echo.
     */
    public function debug($str) {
        if (DEBUG_MODE)
            echo "<pre>$str</pre>";
    }

}

?>