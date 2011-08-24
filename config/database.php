<?php
    

    // Database Configuration
    // Change to appropriate values!
    
    // Development/Production mode?

    $developmentMode = true;

    
    define('DB_DEBUG_MODE_ON',DEBUG_MODE);
    
    // Settings
    
    if($developmentMode) {
        // DEVELOPMENT
        // Use different settings for different computers ;-)
        $host_name =  php_uname('n');
        
        if($host_name == 'HIRAYAMI-PC'){
            define('DB_HOST','');
            define('DB_USERNAME','');
            define('DB_PASSWORD','');
            define('DB_DATABASE','');
        }else{
            define('DB_HOST','localhost');
            define('DB_USERNAME','root');
            define('DB_PASSWORD','janina');
            define('DB_DATABASE','');
        }
    }else{
        // PRODUCTION
        define('DB_HOST','localhost');
        define('DB_USERNAME','');
        define('DB_PASSWORD','');
        define('DB_DATABASE','');
    }
    
    // DB Tables - Define tables here
    
?>