<?php

/**
 * Configuration file - left for developers to use for their projects. 
 * Declare constants as you wish!
 * 
 */

// Member Types
    
define('HTI_INACTIVE',0);
define('HTI_VALIDEMAIL',1);
define('HTI_STUDENT',2);
define('HTI_ADMIN',3);

// Member Types - display strings

$typeDisplay = array(
    HTI_INACTIVE => 'Email not verified',
    HTI_VALIDEMAIL => 'Email verified',
    HTI_STUDENT => 'Student/Member',
    HTI_ADMIN => 'Administrator'
);

// Captcha
define('CAPTCHA_ON',true);
define('RECAPTCHA_PUBLIC','6LcIqMgSAAAAAC5upDXKTmeagzzbXxigwISg-Eeo');
define('RECAPTCHA_PRIVATE','6LcIqMgSAAAAAE1z8-D4hSStbLW9Gei5UdJSy_ty');

// Pagination

define('MEMBERS_PER_PAGE',10);

?>