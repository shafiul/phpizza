<?php
require dirname(__FILE__) . '/pre_script.php';
// Load Configuaration
require dirname(__FILE__) . '/config.php';
// Load Core Class
require dirname(__FILE__) . '/core/class/Core.php';

// Start PHPizza
$phpizza = new PHPizza();
$__viewInstance = null; ///< A Global instance
$page = $phpizza->validate->input('p', "", false, LANDING_PAGE);
// Remove trailish slash
$page = rtrim($page,"/");
// Load model, view & controller
$phpizza->loadMVC($page);
require dirname(__FILE__) . '/post_script.php';
?>

