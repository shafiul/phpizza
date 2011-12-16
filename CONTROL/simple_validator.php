<?php

class Controller extends CoreController{
    
    
    public function __construct($core) {
        parent::__construct($core);
    }
    
    function index(){
            echo $this->getMsg();
        ?>
        <ul>
            <li><a href="<?php echo url('simple_validator/test'); ?>">Invalid example (user did not submit desired value): page redirects to this page</a></li>
            <li><a href="<?php echo url('simple_validator/test?noRedirect=yes'); ?>">Invalid example (user did not submit desired value): page does not redirect</a></li>
            <li><a href="<?php echo url('simple_validator/test?id=something'); ?>">Valid Example. Value passed is: &quot;something&quot;</a></li>

            
        </ul>
        <?php
//        $this->core->loadView();
    }
    
    function test(){
        
        $id = $this->validate->input('id');
        $noRedirect = $this->validate->input('noRedirect',"",false);    //  Not required, uses a default value 
        
        if($noRedirect == "yes"){
            // Don't exit, process within this page
            $errorMsg = $this->validate->exitIfInvalid(false);
            if($errorMsg)
                echo "Error occured. Details: $errorMsg";
        }else{
            $this->validate->exitIfInvalid();   // Exit if not valid
        }
        
        
        
        echo "<br />ID is: &quot;$id&quot; | noRedirect Is: &quot;$noRedirect&quot;";
        
        echo '<hr />' . anchor('simple_validator', 'Back');
       
    }
    
}

?>