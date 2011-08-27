<?php

// General Purpose Functions

class Funcs {

    private $displayMessage = "";
    private $html;  // A reference to the HTML object
    
    public function __construct($core) {
        $this->html = $core->html;
    }


    public function redirect($page='../index.php?', $byHeader = true) {
        if ($byHeader) {
            header("Location: $page");
        }
        exit();
    }

    public function messageExit($message, $type=3, $pageURL='') {
//            die("$message");
        if (empty($pageURL)) {
            $pageURL = (isset($_SERVER['HTTP_REFERER'])) ? ($_SERVER['HTTP_REFERER']) : ('');
        }
        $this->setSessData('displayMessage', array($message, $type));
//            $this->redirect($pageURL . "&message=$message&type=$type");
        $this->redirect($pageURL);
    }

    public function setSessData($id, $data) {
        $_SESSION[$id] = $data;
        return true;
    }

    public function getSessData($id) {
        if (isset($_SESSION[$id]))
            return $_SESSION[$id];
        else
            return false;
    }

    public function unsetSessData($id) {
        if (isset($_SESSION[$id]))
            unset($_SESSION[$id]);
    }

    public function redirectIfNotAuthenticated($accessLevel = 1, $returnFalse = false, $pageURL='login.html') {
        if ($member = $this->getSessData('member')) {
            if ($member['status'] >= $accessLevel)
                return $member;
        }
        if ($returnFalse)
            return false;
//            die("not authenticated");
        $this->setSessData('afterLoginRedirectUrl', $_SERVER['HTTP_REFERER']);
        $this->messageExit("You are not authenticated to access this area.", 3, $pageURL);
    }


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
    
    // GUI related
    
    public function setDisplayMsg($msg,$status = MSGBOX_ERROR){
        $this->displayMessage = array($msg, $status);
    }
    
    public function getDisplayMsg() {
        // Prints error/info/warning messages
        if (!empty($this->displayMessage)) {
            
            $str = '<div align="center"><div title = "Click to hide this notification" onclick = "$(this).fadeOut();" class="notification-wrapper" id = "displayM">';
            $str .= $this->html->msgbox($this->displayMessage[0], $this->displayMessage[1]);
            $str .= '</div> <br />';
            $str .= '<script>$("#displayM").fadeIn("slow");</script> </div>';
            $this->displayMessage = "";
        } else {
            $str = "";
        }
        return $str;
    }

}

?>
