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
        $this->title = "Demo 2";
    }
    
    public function mainContent() {
        // This function must be implemented!
        // now follows html:
        ?>
                    <ul>
                        <li>This is a nested view, under the &QUOT;sample&quot; folder</li>
                        <li>You can nest it as deep as you want</li>
                        <li>Loaded without any controller</li>
                    </ul>
                    
        <?php
        if(isset($_REQUEST['id']))
            echo "parameter passed via get method: " . $_REQUEST['id'];
    }
}

?>
