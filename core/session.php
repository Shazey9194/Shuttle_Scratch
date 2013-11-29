<<<<<<< HEAD
<?php

/**
 * Session manager description
 * 
 * <p>The session manager<p>
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 * @author Fabien MORCHOISNE <f.morchoisne@insta.fr>
 */
class Session
{

    /**
     * The session alert messages
     * 
     * @var array 
     */
    private $flash;

    /**
     * The session userdata
     * 
     * @var array 
     */
    private $userdata;

    /**
     * Construct
     * 
     * @throws \RuntimeException
     */
    public function __construct() {

        if (session_start() != TRUE) {
            throw new \RuntimeException("Cannot initialize session ! \nYour system does not support Session !");
        }

        $this->userdata = isset($_SESSION['userdata']) ? unserialize($_SESSION['userdata']) : array();
        $this->flash = isset($_SESSION['flash']) ? unserialize($_SESSION['flash']) : array();
        unset($_SESSION['flash']);
    }

    /**
     * Start a user session
     * 
     * @param array $userdata The userdatas
     */
    public function startUserSession($userdata = array()) {
        $now = new \DateTime();
        $_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['browserInfo'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['sessionDate'] = $now->format('Y-m-d H:i:s');
        $_SESSION['userdata'] = serialize($userdata);
    }

    /**
     * Destroy session
     * 
     * @throws \RuntimeException
     */
    public function endUserSession() {
        if (session_destroy()) {
            unset($_SESSION);
            $this->userdata = array();
        } else {
            throw new \RuntimeException("Unable to end session \nRefresh the page and try to logout again");
        };
    }

    /**
     * Return The session user data
     * 
     * @return array
     */
    public function getUserData() {
        return unserialize($_SESSION['userdata']);
    }

    /**
     * Return The session user data
     * 
     * @return array
     */
    public function setUserData($userdata = array()) {
        $_SESSION['userdata'] = $userdata;
    }

    /**
     * Check if sssion userdata exists
     * 
     * @return boolean
     */
    public static function existSessionData() {
        return (isset($_SESSION['userdata']) and !empty($_SESSION['userdata']));
    }

    /**
     * Check for an opened user session
     * 
     * @return boolean
     */
    public function isGranted($role = null) {

        if (!empty($this->userdata)) {

            if ($role != null) {
                return in_array($role, $this->userdata['roles']);
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Add a flash message to the session
     * 
     * @param string $type [info|success|warning|danger] The flash message type
     * @param string $message The flash message
     */
    public function addFlash($message, $type = 'info') {
        $this->flash[$type] = $message;
        $_SESSION['flash'] = serialize($this->flash);
    }

    /**
     * Return the session flash messages
     * 
     * @return void
     */
    public function getFlash() {
        return $this->flash;
    }

    /**
     * Clear the session flash messages
     * 
     * @return void
     */
    public function clearFlash() {
        $this->flash = array();
    }

}
=======
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
>>>>>>> bd14fcb1dfea292273f73a30bd5d3d024e69af83
