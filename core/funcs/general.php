<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   Global helper Functions
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

// Site Related

    function url($url){
        return BASE_URL . "/$url" . URL_EXTENTION;
    }

// HTML Related

    function img($filePath){
        // Returns absolute path for the image
        return BASE_URL . "/$filePath";
    }
    
    function anchor($url, $text){
        return "<a href = '" . BASE_URL . "/$url" . URL_EXTENTION. "'>$text</a>";
    }

?>
