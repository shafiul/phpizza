<?php

/**
 * \brief All controller classes must extend this class
 */

class CoreController {
    public $core;   ///< A reference to the $core variable
    
    public function __construct($core) {
        $this->core = $core;
    }
}

?>