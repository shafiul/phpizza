<?php

    /* ****** ****** ****** ****** ****** ******
    *
    * Author       :   Shafiul Azam
    *              :   ishafiul@gmail.com
    *              :   Core Developer, PROGmaatic Developer Network
    *              :   shafiul.user.sf.net
    * Page         :
    * Description  :   
    * Last Updated :
    *
    * ****** ****** ****** ****** ****** ******/


    // Constants
    define('BASE_URL', 'http://localhost/htdocs/projects/gigamvc');    // Without trailing slash!!!
//    define('BASE_URL', 'http://localhost/projects/Giga_MVC');    // Without trailing slash!!!

    define('SITE_THEME','WhiteLove');
    define('LANDING_PAGE','index');
    
    define('DEBUG_MODE',true);
//    define('DEBUG_MODE',false);
    
    
    // Database
    define('DB_DRIVER','MySQL');    //  Possible values: MySQL
    // rest of the Database configurations can be edited in config/database.php file
    
    ///////////////////////////////////////////////////
    // Generally, you don't need to modify followings.
    
    define('URL_EXTENTION','');    //  Provide with leading dot (.html for example) 
    // or empty for no extention
    
    define('IMAGE_DIR','images');
    define('JS_DIR','client/js');
    define('TEMPLATE_DIR','templates');
    define('VIEW_DIR','VIEW');
    define('CONTROL_DIR','CONTROL');
    define('MODEL_DIR','MODEL');
    define('CUSTOM_DIR','custom');
    define('FORMS_DIR', VIEW_DIR . "/forms");   //  Directory where your HTML forms reside

    // Configuration - User
    define('CAPTCHA_ON',true);


?>
