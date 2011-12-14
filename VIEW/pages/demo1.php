<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */


class View extends Template{
    public function __construct($core) {
        // Must call parent's constructor
        parent::__construct($core);
        // Allow static load
        $this->setStatic();
        // Set titles & other attributes here
        $this->title = "Demo 1";
    }
    
    public function mainContent() {
        // This function must be implemented!
        // now follows html:
        ?>
                    This view was loaded without any controller <br /><br />
                    To pass an parameter and get it in the view without the help of controller 
                    use get method. 
                    <?php echo anchor_static("demo1?id=hello", "Example Here") ?>
<!--                    <a href="demo1.html?id=hello!">Example here</a>-->
                    <br />
                    
        <?php
            if(isset($_REQUEST['id']))
                echo "parameter passed via get method: " . $_REQUEST['id'];
    }
}

?>
