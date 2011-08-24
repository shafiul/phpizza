<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Language" content="English" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
            // Get Instance of Core 
            global $core;
            // Print Title
            echo "<title>" . $core->view->title . "</title>";
            // Print CSS
            $core->view->printCss();
            // Print Javascript
            $core->view->printJs();
        ?>
    </head>
    <body>

        <div id="wrap">

            <div id="header">
                <h1><a href="#">Website Title</a></h1>
                <h2>Subheader, website description H2</h2>
            </div>



            <div id="content">
                <div class="left"> 
                    <?php
                        $core->view->printMainPageContent();
                    ?>
                </div>

                <div class="right"> 

                    <h2>Categories :</h2>
                    <ul>
                        <li><a href="#">World Politics</a></li> 
                        <li><a href="#">Europe Sport</a></li> 
                        <li><a href="#">Networking</a></li> 
                        <li><a href="#">Nature - Africa</a></li>
                        <li><a href="#">SuperCool</a></li> 
                        <li><a href="#">Last Category</a></li>
                    </ul>

                    <h2>Archives</h2>
                    <ul>
                        <li><a href="#">January 2007</a></li> 
                        <li><a href="#">February 2007</a></li> 
                        <li><a href="#">March 2007</a></li> 
                        <li><a href="#">April 2007</a></li>
                        <li><a href="#">May 2007</a></li> 
                        <li><a href="#">June 2007</a></li> 
                        <li><a href="#">July 2007</a></li> 
                        <li><a href="#">August 2007</a></li> 
                        <li><a href="#">September 2007</a></li>
                        <li><a href="#">October 2007</a></li>
                        <li><a href="#">November 2007</a></li>
                        <li><a href="#">December 2007</a></li>
                    </ul>

                </div>
                <div style="clear: both;"> </div>
            </div>

            <div id="footer">
                <a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target="_blank">Free CSS Templates</a>
            </div>
        </div>

    </body>
</html>