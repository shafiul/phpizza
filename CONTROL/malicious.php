<?php


class Controller extends CoreController{
    function __construct($core) {
        parent::__construct($core);
    }
    
    function index(){
        $mc = new MaliciousClass();
        $mc->getDbInfo();
    }
}



?>
