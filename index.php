<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

// Load Configuaration
require_once dirname(__FILE__) . '/config/general.php';
// Load DB
//require_once dirname(__FILE__) . '/core/class/MySQL.php';
// Load Core Class
require_once dirname(__FILE__) . '/core/class/Core.php';

// Create Core Object
$core = new Core();
$page = $core->validate->userInput('page', "", false, LANDING_PAGE);
// Remove trailish slash
$page = rtrim($page,"/");
// Load model, view & controller
$core->loadMVC($page);
$core->generateViewObject();
// Load Site Template
$core->loadTemplate();
?>

