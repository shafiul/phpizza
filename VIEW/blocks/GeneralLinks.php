<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager, 
 *              :   PROGmaatic Developer Network
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

/**
 * \brief project specific class: "%HTML Block" example.
 * 
 * @author Shafiul Azam
 * A demonstration-purpose class for presenting how to write a class to create blocks.
 */

class GeneralLinks{
    
    private $block; ///< ///< An instance of the custom class "Blocks" - created in the constructor for your convenience.
    
    /**
     * Instantiate $block and build the block
     */
    
    public function __construct() {
        $this->block = new Blocks("Examples");
        // Construct the Block! First construct links...
        // Static links (nested)
        $staticPages = $this->block->li(array(
            anchor_static("sample/demo2", "sample/demo2"),
            anchor_static("demo1", "demo1")
        ));
        $generalPages = $this->block->li(array(
            anchor("index", "home"),
            anchor("sample/demo1", "sample/demo1"),
            anchor("simple_validator","Simple Validator"),
            anchor("many_views","Dynamic views")
        ));
        $formPages = $this->block->li(array(
            anchor("registration", "Registration (automatic form process)"),
            anchor("login", "login (manual form process)"),
        ));
        // Finally, set the items
        $this->block->items = array(
            "General pages $generalPages",
            "Static Pages $staticPages",
            "Forms $formPages"
        );
    }
    
    /**
     * Returns the generated html
     * @return string | generated html 
     */
    
    public function get(){
        return $this->block->create();
    }
}

?>
