<?php

class Controller extends CoreController{
    function __construct($core) {
        parent::__construct($core);
    }
    
    function index(){
        echo 'Hello!';
    }
    
    function world(){
        $this->loadView();
    }
}

?>
