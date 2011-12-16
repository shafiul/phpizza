<?php

/**
 * Lets see how security can be breach by a malicious class
 */

class MaliciousClass{
    
    function __construct() {
        ;
    }
    
    
    /**
     * try to get DB credentials :P
     */
    
    function getDbInfo(){
        $config = Config::getInstance();
    }
}

?>
