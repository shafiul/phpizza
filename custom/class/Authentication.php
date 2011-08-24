<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Project Manager
 * Page         :
 * Description  :   This page is under construction. Never use it!
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */

class Authentication{
    /*
     * @return <mixed> returns false if there is now user available of current session username
     * otherwise mixed
     */

    public function isLoggedIn() {
        $tuser = $this->getSessData('member');
        if (!empty($tuser['username'])) {
            //  WHAT THE F!!!!
            return mysql_return_array(USER_TABLE, array("username"), array("username" => $tuser['username']), false);
        }
    }

    /*
     * returns currently logged username or if there is no user logged in then return the prameter back;
     */

    public function getLoggedUsername($default="") {
        $tuser = $this->getSessData('member');
        if ($tuser['username']) {
            return $tuser['username'];
        }
        return $default;
    }

    public function getLoggedUserEmail($default="") {
        $tuser = $this->getSessData('member');
        if (!empty($tuser['username'])) {
            $res = mysql_return_array(USER_TABLE, array("email"), array("username" => $tuser['username']), false);
            if ($res['email']) {
                return $res['email'];
            }
        }
        return $default;
    }
}

?>
