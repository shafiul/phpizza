<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');



// Calculation of time taken to generate the page
// ***************************************************************************
// comment out this block in production server
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$pizzaStartTime = $time;
// ***************************************************************************
// Time Calculation

// Load Configuaration
require dirname(__FILE__) . '/config.php';
// Load Core Class
require dirname(__FILE__) . '/core/class/Core.php';

// Start PHPizza
$phpizza = new PHPizza();
$__viewInstance = null; ///< A Global instance
$page = $phpizza->validate->userInput('page', "", false, LANDING_PAGE);
// Remove trailish slash
$page = rtrim($page,"/");
// Load model, view & controller
$phpizza->loadMVC($page);

// ***************************************************************************
// Time Calculation
// comment out following code in production server
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $pizzaStartTime), 4);
if(DEBUG_MODE)
    echo '<pre><br /><br />Page generated in ' . $total_time . ' seconds</pre>';
?>

