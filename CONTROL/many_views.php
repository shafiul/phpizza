<?php

// View the effects setting CONTROLLER_FUNC_CALL_ENABLED true. but you can also 
// apply this knowledge when controller_func_call is false.


class Controller extends CoreController{
    function __construct($core) {
        // Call parent's constructor. 
        parent::__construct($core);
    }
    
    function index(){
        echo anchor("many_views/test1", "Load VIEW/index.php view");
        echo "<br />";
        echo anchor("many_views/test2", "Load VIEW/sample/demo1.php view");
    }
    
    function test1(){
        // Set data required for the view page
           // Get instance
        $title = "Title set via test1 function.";
        $this->core->setData('title',$title);
        // Load the view
        $this->core->loadView("index");
    }
    
    function test2(){
        // Set data required for the view page
        
        $this->core->setData("mainContent","<h1>This content was set from test2 function!</h1>");
        // Load the view
        $this->core->loadView("sample/demo1");
    }
}

?>

