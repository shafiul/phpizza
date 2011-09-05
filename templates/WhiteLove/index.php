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
            echo $core->view->printCss();
            // Print Javascript
            echo $core->view->printJs();
        ?>
    </head>
    <body>

        <div id="wrap">

            <div id="header">
                <?php $core->view->header();  ?>
            </div>



            <div id="content">
                <div class="left"> 
                    <?php
                        echo $core->funcs->getDisplayMsg();
                        echo "<br />";
                        $core->view->mainContent();
                    ?>
                </div>

                <div class="right"> 

                    <?php $core->view->sidebar("right"); ?>

                </div>
                <div style="clear: both;"> </div>
            </div>

            <div id="footer">
                <a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target="_blank">Free CSS Templates</a>
            </div>
        </div>

    </body>
</html>