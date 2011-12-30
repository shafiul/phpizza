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
function url($url) {
    $urlArr = explode("?", $url, 2); // Split based on the query string
    if(NICE_URL_ENABLED){
        $queryString = (isset($urlArr[1])) ? ( "?" . $urlArr[1]) : ("");
        return BASE_URL . '/' . $urlArr[0] . URL_EXTENTION . $queryString;
    }else{
        $queryString = (isset($urlArr[1])) ? ( "&" . $urlArr[1]) : ("");
        return BASE_URL . '/?p=' . $urlArr[0] . $queryString;
    }
    
    
}

/**
 * Returns URL for "static" - (VIEW only, no constructor) pages of your site. You should use this 
 * function to generate URLs for the pages that have no constructor for them.
 * @param string $url 
 * @return string working URL 
 */
function url_static($url) {
    $urlArr = explode("?", $url, 2); // Split based on the query string
    if(NICE_URL_ENABLED){
        $queryString = (isset($urlArr[1])) ? ( "?" . $urlArr[1]) : ("");
        return BASE_URL . '/static/' . $urlArr[0] . URL_EXTENTION . $queryString;
    }else{
        $queryString = (isset($urlArr[1])) ? ( "&" . $urlArr[1]) : ("");
        return BASE_URL . '/?p=static/' . $urlArr[0] . $queryString;
    }
}

/**
 * Gets full path for a file, just appending constant BASE_URL in front of the file
 * @param string $filePath  relative path of the file
 * @return string full path of the file 
 */
function filePath($filePath) {
    // Returns absolute path for a file.
    return BASE_URL . "/files/$filePath";
}

/**
 * Redirection Function
 * @param string $page  URL to which the page will be redirected
 * @param bool $byHeader    if true, redirection done by html header. else, by javascript 
 */
function redirect($page="", $byHeader = true) {
    if (empty($page))
        $page = url(LANDING_PAGE);
    
    if ($byHeader) {
        header("Location: $page");
    } else {
        echo "<script>window.location = '$page';</script>";
    }
    exit();
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
function anchor($url, $text) {
    return "<a href = '" . url($url). "'>$text</a>";
}

/**
 * Provides a link, when clicked, visitor will be provided wit a "Confirmation Box" showing 
 * $confirmationMessage - if clicked yes, visitor will be redirected to $url
 * @param string $url
 * @param string $text
 * @param string $confirmationMessage
 * @return string %HTML link. 
 */
function confirmAndGo($url, $text, $confirmationMessage) {
    $url = url($url);
    return '<a href = "#" onclick ="if(confirm(\'' . $confirmationMessage . '\')){window.location=\'' . $url . '\'}">' . $text . '</a>';
}

/**
 * %HTML <img> tag generator.
 * @param string $url - path of the image
 * @param mixed $attrArr - key value pair of Tag Attributes 
 */
function img($url, $attrArr=null) {
    $attrText = '';
    if ($attrArr) {
        foreach ($attrArr as $k => $v)
            $attrText .= "$k = '$v' ";
    }
    $str = '<img ' . $attrText;
    $str .= ' src ="' . filePath($url) . '" />';
    return $str;
}

/**
 * %HTML <a> tag generator for static (VIEW only, no constructor) pages
 * @param string $url "relative" URL of the path
 * @param string $text text to display for this link
 * @return string | generated html 
 */
function anchor_static($url, $text) {
    return "<a href = '" . url_static($url). "'>$text</a>";
}


/**
 * Get an instance of view object, to use inside your template files
 */

function getView(){
    global $__viewInstance;
    return $__viewInstance;
}

/**
 * Safely returns an element from an array, empty string if not set.
 */

function arrVal($arr, $index){
    if(isset($arr[$index]))
        return $arr[$index];
    else
        return '';
}

//@}
?>