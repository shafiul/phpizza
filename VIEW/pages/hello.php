<?php

class View extends Template{
    function __construct($core) {
        parent::__construct($core);
    }
    
    function mainContent() {
        echo 'Hello, world!';
    }
}

?>
