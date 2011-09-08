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
        // For demonstration, we're using the value set by the controller
          //  Get the instance
        $this->title = $this->core->getData('title');
        $this->heading = "Welcome to the landing page!";
    }
    
    


    public function mainContent() {
        // This function must be implemented!
        // now follows html:
        ?>
                    <h2><a href="#">License and terms of use</a></h2>
                    <div class="articles">
                        White Love Rounded is a CSS template that is free and fully standards compliant. <a href="http://www.free-css-templates.com/">Free CSS Templates</a> designed this template.
                        This template is allowed for all uses, including commercial use, as it is released under the <strong>Creative Commons Attributions 2.5</strong> license. The only stipulation to the use of this free template is that the links appearing in the footer remain intact. Beyond that, simply enjoy and have fun with it!	 
                        <br /><br />
                        <img src="<?php echo filePath("images/pic.jpg");  ?>" alt="Example pic" style="border: 3px solid #ccc;" />
                        <br /><br />
                        Donec nulla. Aenean eu augue ac nisl tincidunt rutrum. Proin erat justo, pharetra eget, posuere at, malesuada 
                        et, nulla. Donec pretium nibh sed est faucibus suscipit. Nunc nisi. Nullam vehicula. In ipsum lorem, bibendum sed, 
                        consectetuer et, gravida id, erat. Ut imperdiet, leo vel condimentum faucibus, risus justo feugiat purus, vitae 
                        congue nulla diam non urna.
                    </div>
                    <h2><a href="#">Title with a link - Example of heading 2</a></h2>
                    <div class="articles">
                        Donec nulla. Aenean eu augue ac nisl tincidunt rutrum. Proin erat justo, pharetra eget, posuere at, malesuada 
                        et, nulla. Donec pretium nibh sed est faucibus suscipit. Nunc nisi. Nullam vehicula. In ipsum lorem, bibendum sed, 
                        consectetuer et, gravida id, erat. Ut imperdiet, leo vel condimentum faucibus, risus justo feugiat purus, vitae 
                        congue nulla diam non urna.
                    </div>
        <?php
        
    }
}

?>
