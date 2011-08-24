<?php

class Controller{
    
    function index(){
            global $core;
            echo $core->getDisplayMsg();
        ?>
        <ul>
            <li><a href="simple_validator/test.html">Invalid example (user did not submit desired value): page redirects to this page</a></li>
            <li><a href="simple_validator/test.html?noRedirect=yes">Invalid example (user did not submit desired value): page does not redirect</a></li>
            <li><a href="simple_validator/test.html?id=something">Valid Example. Value passed is: &quot;something&quot;</a></li>
<!--            <li><a href="simple_validator.html"></a></li>-->
            
        </ul>
        <?php
    }
    
    function test(){
        global $core;
        $id = $core->validate->userInput('id');
        $noRedirect = $core->validate->userInput('noRedirect',"",false);    //  Not required, uses a default value 
        
        if($noRedirect == "yes"){
            // Don't exit, process within this page
            $errorMsg = $core->validate->exitIfInvalid(false);
            if($errorMsg)
                echo "Error occured. Details: $errorMsg";
        }else{
            $core->validate->exitIfInvalid();   // Exit if not valid
        }
        
        
        
        echo "<br />ID is: &quot;$id&quot; | noRedirect Is: &quot;$noRedirect&quot;";
        
        echo "<hr /><a href = '../simple_validator.html'>Back</a>";
    }
    
}

?>