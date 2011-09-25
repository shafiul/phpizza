<?php

/**
 * \brief Some general purpose functions
 * 
 * @author Shafiul Azam
 * 
 * Contains some general purpose functions. $core has an object of this class, named $funcs
 */

class Funcs {

    private $html;  ///<     A reference to the $core->$html, object of HTML class
    
    
    /**
     * You must pass the global $core as parameter
     * @param Core object $core 
     */
    
    public function __construct($core) {
        $this->html = $core->html;
    }

    /**
     * Redirection Function
     * @param string $page  URL to which the page will be redirected
     * @param bool $byHeader    if true, redirection done by html header. else, by javascript 
     */

    public function redirect($page="", $byHeader = true) {
        if(empty($page))
            $page = url(LANDING_PAGE);
        if ($byHeader) {
            header("Location: $page");
        }else{
            echo "<script>window.location = '$page'</script>";
        }
        exit();
    }

    
    /**
     * Displays a message and then dies (exits)
     * @param string $message   message which will be displayed
     * @param int $type status, there are four constants:
     *  - MSGBOX_INFO information type
     *  - MSGBOX_SUCCESS    success message
     *  - MSGBOX_WARNING    warning message
     *  - MSGBOX_ERROR  critical message
     * @param string $pageURL URL to which the page will be redirected
     */
    
    public function messageExit($message, $type=3, $pageURL='') {
//            die("$message");
        if (empty($pageURL)) {
            $pageURL = (isset($_SERVER['HTTP_REFERER'])) ? ($_SERVER['HTTP_REFERER']) : ('');
        }
        $this->setSessData('displayMessage', array($message, $type));
//            $this->redirect($pageURL . "&message=$message&type=$type");
        $this->redirect($pageURL);
    }
    
    /**
     * @name SESSION related
     * 
     * setting, getting & destroying variables in PHP SESSION (using PHP's built in $_SESSION variable)
     */
    
    //@{

    /**
     * Storing a variable in SESSION
     * @param string $id ID for the variable, use this ID in getSessData() to retrive the variable
     * @param variable $data variable to store
     */
    
    public function setSessData($id, $data) {
        $_SESSION[$id] = $data;
    }
    
    /**
     * Retrive a variable from session, previously stored by calling setSessData()
     * @param string $id ID used for storing the variable, used in setSessData()
     * @return mixed
     *  - stored variable, if it was found in SESSION
     *  - bool false, if not found in SESSION
     */

    public function getSessData($id) {
        if (isset($_SESSION[$id]))
            return $_SESSION[$id];
        else
            return false;
    }

    /**
     * Destroying a variable from SESSION
     * @param string $id ID used for storing the variable, used in setSessData()
     */
    
    public function unsetSessData($id) {
        if (isset($_SESSION[$id]))
            unset($_SESSION[$id]);
    }
    
    //@}
    
    
    /**
     * @name Functions for debugging
     */
    
    //@{
    
    public function varDumpToString($var) {
        ob_start();
        var_dump($var);
        return ob_get_clean();
    }

    
    
    public function PR($obj, $pretext="", $posttext="") {
        echo "<pre>$pretext:";
        var_dump($obj);
        echo "$posttext</pre>";
    }
    
    //@}
    
    // GUI related
    
    /**
     * Call this within controller to set a %HTML message which you want to get displayed automatically 
     * in your VIEW
     * @param string $msg The %HTML message you want to get displayed
     * @param int $status see constants defined for parameter $type in messageExit() function
     */
    
    public function setDisplayMsg($msg,$status = MSGBOX_ERROR){
//        $this->displayMessage = array($msg, $status);
        $this->setSessData('displayMessage', array($msg, $status));
    }
    
    /**
     * - This function is called automtically! Do not call this function in your VIEW
     * - Call this function in your template file. See templates/WhiteLove/index.php for example
     * 
     * Get the %HTML message set via setDisplayMsg() - The function will do styling based on 
     * $status parameter of setDisplayMsg() function
     * @return string Generated %HTML if message exists, empty string otherwise.
     * 
     */
    
    public function getDisplayMsg() {
        // Prints error/info/warning messages
        if ($dM = $this->getSessData('displayMessage')) {
            $str = '<div align="center"><div class="notification-wrapper" id = "displayM">';
//            $str = '<div align="center"><div title = "Click to hide this notification" onclick = "$(this).fadeOut();" class="notification-wrapper" id = "displayM">'; // With jQuery's onclick - hide support
            $str .= $this->html->msgbox($dM[0], $dM[1]);
            $str .= '</div> <br />';
            $str .= '<script>$("#displayM").fadeIn("slow");</script> </div>';
            // Finally, unset the session data
            $this->unsetSessData('displayMessage');
        } else {
            $str = "";
        }
        return $str;
    }
    
    
    /**
     * Returns date formatted in human readable way. 
     * @param int $unixTimestamp | Leave empty to return current time
     */
    
    public function date($unixTimestamp=null){
        return date("j F Y, g:i a",$unixTimestamp);
    }
}

?>
