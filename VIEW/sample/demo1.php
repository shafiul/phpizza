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
    public function __construct() {
        // Must call parent's constructor
        parent::__construct();
        // Set titles & other attributes here
        $this->title = "Demo 1";
    }
    
    public function mainContent() {
        global $core;   //  Got instance of core
        // This function must be implemented!
        // now follows html:
        ?>
                    <ul>
                        <li>This is a nested view, under the &QUOT;sample&quot; folder</li>
                        <li>You can nest it as deep as you want</li>
                    </ul>
                    <br />
                    
        <?php
            echo $core->getData("mainContent");
    }
}

?>
