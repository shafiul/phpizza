<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager, 
 *              :   PROGmaatic Developer Network
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

/**
 * \brief A fundamental model class. You extend me in your MODELS
 * 
 * @author Shafiul Azam
 */

class CustomModel {
    private $db;        ///<    object for database
    
    /**
     * You should call this function as the first line within your MODEL class's constructor.
     * Loads your favorite database driver.
     */
    
    public function __construct() {
        // Load database driver. They are not automatically loaded to prevent un-necessary loading
        // since you do not perform database functionality everywhere
        global $core;
        // Load your favorite database driver, i.e MySQL
        if(!$core->loadDatabaseDriver("MySQL")){
            echo "Can not load database driver";
            exit();
        }
        
    }
}

?>
