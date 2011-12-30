<?php

/**
 * \brief Some general purpose functions
 * 
 * @author Shafiul Azam
 * 
 * Contains some general purpose functions. $core has an object of this class, named $funcs
 */
class Funcs {

    private $core;  ///<     A reference to the instance of Core class

    /**
     * You must pass the global $core as parameter
     * @param Core object $core 
     */

    public function __construct($core) {
        $this->core = $core;
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
    public function messageExit($message, $type=MSGBOX_ERROR, $pageURL='') {

//            die("$message");
        if (empty($pageURL)) {
            $pageURL = (isset($_SERVER['HTTP_REFERER'])) ? ($_SERVER['HTTP_REFERER']) : ('');
        }
        $this->setStatusMsg($message, $type);
//            redirect($pageURL . "&message=$message&type=$type");
        redirect($pageURL);
    }

    /**
     * @name PHP SESSION Related
     * 
     * If you are using any of theese functions, make sure you started Session first. Following code can safely start a PHP session: \n
     * 
     * \code
     * if(!session_id()){
     *      session_start();
     * }
     * \endcode
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
     *  - null, if not found in SESSION
     */
    public function getSessData($id) {
        if (isset($_SESSION[$id]))
            return $_SESSION[$id];
        else
            return null;
    }

    /**
     * Destroying a variable from SESSION
     * @param string $id ID used for storing the variable, used in setSessData()
     */
    public function unsetSessData($id) {
        unset($_SESSION[$id]);
    }

    //@}
    // GUI related

    /**
     * Call this function within Controller classes to set a %HTML message which you want to get displayed automatically 
     * in the generated %HTML for the page. The messages are of various types, i.e \a Success, \a Warning, \a Information or \Failure type. \n
     * Each type has it's own style, i.e. \a Success type messages are displayied withing Green background, where \a Failure type 
     * are displayed withing Red background/color styles.
     * \note This function safely starts PHP Session - as status messages are passed using PHP Session.
     * @param string $msg The %HTML message you want to get displayed
     * @param int $status see constants defined for parameter $type in messageExit() function
     */
    public function setStatusMsg($msg, $status = MSGBOX_ERROR) {
        // Safely start session fist
        if (!session_id())
            session_start();
//        $this->displayMessage = array($msg, $status);
        $dispMsg = $this->getSessData('displayMessage');
        if (!$dispMsg) {
            // Create New
            $dispMsg = array();
        }
        $dispMsg[] = array($msg, $status);
        $this->setSessData('displayMessage', $dispMsg);
    }

    /**
     * You should call this function withing your Template class.
     * 
     * - This function is called automtically! Do not call this function in your VIEW classes.
     * - Call this function in your template file. See templates/WhiteLove/index.php for example
     * 
     * Get the %HTML message set via setStatusMsg() - The function will do styling based on 
     * $status parameter of setStatusMsg() function
     * 
     * \note This function safely starts PHP Session - as status messages are passed using PHP Session.
     * 
     * @return string Generated %HTML if message exists, empty string otherwise.
     * 
     */
    public function getStatusMsg() {
        // Safely start session fist
        if (!session_id())
            session_start();
        if ($dispMsg = $this->getSessData('displayMessage')) {
            
            $str = "";
            foreach ($dispMsg as $i => $dM) {
//                echo "HI$i";
                $str .= '<div align="center"><div class="dispMsg-wrapper" id = "displayMsg' . $i . '">';
//                $str = '<div align="center"><div title = "Click to hide this notification" onclick = "$(this).fadeOut();" class="notification-wrapper" id = "displayM">'; // With jQuery's onclick - hide support
                $str .= Html::msgbox($dM[0], $dM[1]);
                $str .= '</div> <br />';
                $str .= '<script>$("#displayM").fadeIn("slow");</script> </div>';
            }
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
    public function date($unixTimestamp=null) {
        return date("j F Y, g:i a", $unixTimestamp);
    }

}

?>