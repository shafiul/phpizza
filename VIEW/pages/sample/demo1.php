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
        // Set titles & other attributes here
        $this->title = "Demo 1 passing param";
    }
    
    public function mainContent() {
           //  Got instance of core
        // This function must be implemented!
        // now follows html:
        ?>
                    <ul>
                        <li>This is a nested view, under the &QUOT;sample&quot; folder</li>
                        <li>You can nest it as deep as you want</li>
                    </ul>
                    <br />
                    
        <?php
            echo $this->core->getData("mainContent");
    }
}

?>
