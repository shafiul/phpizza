<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();


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

// Create Core Object
$core = new Core();
$page = $core->validate->userInput('page', "", false, LANDING_PAGE);
// Remove trailish slash
$page = rtrim($page,"/");
// Load model, view & controller
$core->loadMVC($page);

// ***************************************************************************
// Time Calculation
// comment out following code in production server
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $pizzaStartTime), 4);
$core->debug("<br /><br />Page generated in $total_time seconds.");

?>

