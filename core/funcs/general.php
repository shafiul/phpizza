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
 * @file
 * \brief General-purpose Global functions
 * 
 * @author Shafiul Azam
 */



    /**
     * @name Site related
     */

    //@{
    
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
    
    
    /**
     * Gets full path for a file, just appending constant BASE_URL in front of the file
     * @param string $filePath  relative path of the file
     * @return string full path of the file 
     */

    function filePath($filePath){
        // Returns absolute path for the image
        return BASE_URL . "/$filePath";
    }
    
    //@}

    /**
     * @name Quick %HTML generators
     */
    
    //@{
    
    /**
     * %HTML <a> tag generator
     * @param string $url "relative" URL of the path
     * @param string $text text to display for this link
     * @return string | generated html 
     */
    
    function anchor($url, $text){
        return "<a href = '" . BASE_URL . "/$url" . URL_EXTENTION. "'>$text</a>";
    }
    
    //@}

?>
