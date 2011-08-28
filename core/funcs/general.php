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

/**
 * \brief General-purpose Global functions
 * 
 * @author Shafiul Azam
 */

// Site Related
    
    /**
     * Always use this function to use URLs
     *  - If you just type an URL (i.e in href attribute in an <a> tag ) it might not work. you should 
     *  pass your url through this function
     * @param string $url 
     * @return string working URL for the framework 
     */
    
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
