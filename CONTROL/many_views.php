<?php

// View the effects setting CONTROLLER_FUNC_CALL_ENABLED true. but you can also 
// apply this knowledge when controller_func_call is false.


class Controller{
    function __construct() {
    }
    
    function index(){
        echo "<a href = 'many_views/test1.html'>Load VIEW/index.php view</a> <br />";
        echo "<a href = 'many_views/test1.html'>Load VIEW/sample/demo1.php view</a> <br />";
    }
    
    function test1(){
        // Set data required for the view page
        global $core;   // Get instance
        $title = "Title set via test1 function.";
        $core->setData('title',$title);
        // Load the view
        $core->loadView("index");
    }
    
    function test2(){
        // Set data required for the view page
        global $core;
        $core->setData("mainContent","<h1>This content was set from test2 function!</h1>");
        // Load the view
        $core->loadView("sample/demo1");
    }
}

?>

