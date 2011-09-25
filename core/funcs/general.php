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
     *  - If you just type an URL (i.e in "href" attribute in an <a> tag ) it might not work. You should 
     *  pass your url through this function
     * @param string $url 
     * @return string working URL
     */
    
    function url($url){
        return BASE_URL . "/$url" . URL_EXTENTION;
    }
    
    /**
     * Returns URL for "static" - (VIEW only, no constructor) pages of your site. You should use this 
     * function to generate URLs for the pages that have no constructor for them.
     * @param string $url 
     * @return string working URL 
     */
    
    function url_static($url){
        return BASE_URL . "/static/$url" . URL_EXTENTION;
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
        $urlArr = explode("?", $url,2); // Split based on the query string
        $queryString = (isset ($urlArr[1]))?( "?" . $urlArr[1]):("");
        return "<a href = '" . BASE_URL . "/" . $urlArr[0] . URL_EXTENTION . $queryString . "'>$text</a>";
    }
    
    function confirmAndGo($url,$text,$confirmationMessage){
        $url = url($url);
        return '<a href = "#" onclick ="if(confirm(\'' . $confirmationMessage . '\')){window.location=\'' . $url .'\'}">' . $text . '</a>';
    }
    
    
    
    /**
     * %HTML <a> tag generator for static (VIEW only, no constructor) pages
     * @param string $url "relative" URL of the path
     * @param string $text text to display for this link
     * @return string | generated html 
     */
    
    function anchor_static($url, $text){
        $urlArr = explode("?", $url,2); // Split based on the query string
        $queryString = (isset ($urlArr[1]))?("?" . $urlArr[1]):("");
        return "<a href = '" . BASE_URL . "/static/" . $urlArr[0] . URL_EXTENTION. $queryString . "'>$text</a>";
    }
    
    //@}

?>
