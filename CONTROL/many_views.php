<?php


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
        $this->data('title',$title);
        // Load the view
        $this->loadView("index");
    }
    
    function test2(){
        // Set data required for the view page
        
        $this->data("mainContent","<h1>This content was set from test2 function!</h1>");
        // Load the view
        $this->loadView("sample/demo1");
    }
}

?>

