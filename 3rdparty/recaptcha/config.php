<?php

/* * ***** ****** ****** ****** ****** ******
 *
 * Author       :   Shafiul Azam
 *              :   ishafiul@gmail.com
 *              :   Core Developer
 * Page         :
 * Description  :   
 * Last Updated :
 *
 * ****** ****** ****** ****** ****** ***** */
if (!session_id())
    session_start();

require_once dirname(__FILE__) . '/recaptchalib.php';

$publickey = "6LdFv8ISAAAAAHvYr-VMCckRF_y_Cwba_2R3cemp";
$privatekey = "6LdFv8ISAAAAAPFZVD3HwPFBJ-dJPnioTxTs5jb3 ";

define('USE_RECAPTCHA', true);

function recaptcha_client_head($themeName = "white") {
    if (!USE_RECAPTCHA)
        return "";
    $str = '<script type="text/javascript">
                var RecaptchaOptions = {
                theme : "' . $themeName . '"
                };';
    //*
    $str .= '
     function showRecaptcha(element, submitButton, recaptchaButton, themeName) {

                Recaptcha.destroy();
                Recaptcha.create("6LdFv8ISAAAAAHvYr-VMCckRF_y_Cwba_2R3cemp", element, {
                    theme: themeName,
                    tabindex: 0,
                    callback: Recaptcha.focus_response_field
                });
            }';
     //*/
    $str .= '</script>';
    return $str;
}

function recaptcha_client_form() {
    global $publickey;
    return recaptcha_get_html($publickey);
}

function recaptcha_server() {
    global $publickey, $privatekey;
    if (USE_RECAPTCHA) {
        $resp = recaptcha_check_answer($privatekey,
                        $_SERVER["REMOTE_ADDR"],
                        $_POST["recaptcha_challenge_field"],
                        $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid)
            return false;
    }
    return true;
}