<?php

/**
 * Session manager description
 * 
 * <p>The session manager<p>
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class Session
{

    public static function start() {
        if (session_start() != TRUE) {
            throw new \RuntimeException("Cannot initialize session ! \nYour system does not support Session !");
        }
    }

    /**
     * Set data we need to start
     * 
     * @param array $data Data to set session
     */
    public static function startUserSession($userdata = NULL) {
        if ($userdata != NULL and !empty($userdata)) {
            self::setData($userdata);
        }
    }

    /**
     * Destroy all session var and datas
     * 
     * @throws \RuntimeException Throw an exeption if cannot end session
     */
    public static function endUserSession() {
        if (session_destroy()) {
            unset($_SESSION);
        } else {
            throw new \RuntimeException("Unable to end session \nRefresh the page and try to logout again");
        };
    }

    /**
     * Return The session user data
     * 
     * @return array
     */
    public static function getUserData() {
        return $_SESSION['userdata'];
    }

    /**
     * Set data
     * 
     * @param array $userdata The user data
     */
    public static function setData($userdata) {
        $now = new \DateTime();
        $_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['browserInfo'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['sessionDate'] = $now->format('Y-m-d H:i:s');
        $_SESSION['userdata'] = $userdata;
    }

    /**
     * reset data var to empty array
     * 
     */
    public static function unsetData() {
        $_SESSION['userdata'] = array();
    }

    /**
     * Check if we have data stored
     * 
     * @return boolean
     */
    public static function existSessionData() {
        return (isset($_SESSION['userdata']) and !empty($_SESSION['userdata']));
    }

    /**
     * Check for an opened user session
     * 
     */
    public static function run() {

        if (!isset($_SESSION['userdata'])) {
            header('location: http://' . $_SERVER['SERVER_NAME'] . '/login');
            exit;
        }
    }

}
