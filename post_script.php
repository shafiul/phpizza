<?php

/**
 * @file
 * \brief Custom scripting to run after %PHPizza has completed running.
 * 
 * You may write your own codes here which you want to run after 
 * the framework has completed running.
 */


// Code beyond this line is totally optional.



// ***************************************************************************
// Time Calculation
// comment out following code in production server
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$pizzaFinishTime = $time;
global $pizzaStartTime;
$total_time = round(($pizzaFinishTime - $pizzaStartTime), 4);
if(DEBUG_MODE)
    echo '<pre><br /><br />Page generated in ' . $total_time . ' seconds</pre>';
?>