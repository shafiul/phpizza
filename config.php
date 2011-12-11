<?php

    /**
     * Configuration
     * **************
     * There are some general purpose configuration, like Database settings 
     * or your base URL etc. 
     */

    /**
     * Database Configuration
     */ 
     
    define('DB_DRIVER','MySQL');    //  Possible values: 'MySQL'    
    define('DB_HOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','janina');
    define('DB_DATABASE','gigamvc');

    
    /**
     * Base URL: Location where your site exists. Must begin with http or https
     * DO NOT GIVE ANY TRAILING SLASHES!
     * This is important to show images or javascript/css files properly.
     */
    
    define('BASE_URL', 'http://localhost/htdocs/projects/gigamvc');    // Without trailing slash!!!
//    define('BASE_URL', 'http://localhost/projects/Giga_MVC');    // Without trailing slash!!!

    
    
    /**
     * Templating/Theming
     * 
     * Name the default theme/template for the site. There is a built-in template 'WhiteLove'
     * You may also change template within your Controller class.
     */
    
    define('SITE_THEME','WhiteLove');
    
    
    /**
     * Landing Page
     * 
     * This is the Controller path which is automatically loaded, if user does not 
     * provide any. For example, if user types http://example.com then this Controller class 
     * along with the View class will be loaded.
     */
    
    define('LANDING_PAGE','index');
    
    /**
     * Debug Mode
     */
    
    define('DEBUG_MODE',true);
//    define('DEBUG_MODE',false);
    
    /**
     * URL Extention
     * 
     * All of your URLs will end with this extention. Provide with leading dot (for example: '.html')
     * Leave empty, for no extentions.
     * YOU MAY NEED TO CHANGE .htaccess FILE ACCORDINGLY IF YOU PUT ANY VALUE IN THIS!
     */
    
    define('URL_EXTENTION','');    //  Provide with leading dot (.html for example) 
    // or empty for no extention
    
    /**
     * Default FunctionToCall
     * 
     * This function will be called within your Controller class if not provided any.
     */
    
    define('DEFAULT_FUNCTION2CALL',"index");
    
    
    /**
     * Internal Paths
     * 
     * Do not change them. Modify only if you do understand what you are doing!
     */
    
    define('IMAGE_DIR','images');
    define('JS_DIR','client/js');
    define('TEMPLATE_DIR','templates');
    define('VIEW_DIR','VIEW');
    define('CONTROL_DIR','CONTROL');
    define('MODEL_DIR','MODEL');
    define('CUSTOM_DIR','custom');
    define('FORMS_DIR', VIEW_DIR . "/forms");   //  Directory where your HTML forms reside

    
    /**
     * System configuration : Never change following settings!
     */
    
    
    define('PROJECT_DIR', dirname(__FILE__));
    


?>
