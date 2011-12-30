<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Language" content="English" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?php
        // Get Instance of Core 
        $view = getView();
        // Print Title
        echo "<title>" . $view->title . "</title>";
        // Print CSS
        echo $view->printCss();
        // Print Javascript
        echo $view->printJs();
        ?>
    </head>
    <body>

        <div id="wrap">

            <div id="header">
                <?php $view->header(); ?>
            </div>



            <div id="content">
                <div class="left"> 
                    <?php
                    echo $view->msg();
                    echo "<br />";
                    $view->mainContent();
                    ?>
                </div>

                <div class="right"> 

                    <?php $view->sidebar("right"); ?>

                </div>
                <div style="clear: both;"> </div>
            </div>

            <?php $view->footer(); ?>

        </div>

    </body>
</html>