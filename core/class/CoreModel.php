<?php

/**
 * \brief A fundamental model class. You extend this class in your MODELS
 * 
 * @author Shafiul Azam
 */

class CoreModel {
    public $core;
    private $db;        ///<    object for database
    
    /**
     * You should call this function as the first line within your MODEL class's constructor.
     * 
     * Loads your favorite database driver.
     * 
     * Load database driver. They are not automatically loaded to prevent un-necessary loading 
     * since you do not perform database functionality everywhere
     */
    
    public function __construct($core) {
        $this->core = $core;
    }
}

?>
