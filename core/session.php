<?php

/**
 * Session manager description
 * 
 * <p>The session manager<p>
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
/* * ****************************************************
 * Todo
 * $now = new \Datetime();
 * $ma_date_formatee = $now->format('Y-m-d H:i: s');
 * **************************************************** */
class Session {

	/**
	 * Session Instance
	 * @var \Session
	 */
	private static $instance = null;

	/**
	 * Data of current session
	 * Content session_id, ip_address, browser_info[],last_session (SQL Timestamp), $data from UserModel
	 * @var array
	 */
	private $data;

	/**
	 * Constructor. Start session
	 * @throws \RuntimeException Throw an exeption if cannot start session
	 */
	private function __construct() {
		if (session_start() != TRUE) {
			throw new \RuntimeException("Cannot initialize session ! \nYour system do not support Session !");
		}
	}

	/**
	 * Get the unique session instance
	 * @return \Session Instanse of Session class
	 */
	public static function getInstance() {

		if (is_null(self::$instance)) {
			self::$instance = new Session();
		}
		return self::$instance;
	}

	/**
	 * Set data we need to start
	 * @param array $data Data to set session
	 */
	public function startUserSession($data = NULL) {
		if ($data != NULL) {
			$this->setData($data);
			$current_session = $this->getData();
			foreach ($current_session as $key => $value) {
				$_SESSION[$key] = $value;
			}
		}
	}

	/**
	 * Destroy all session var and datas
	 * @throws \RuntimeException Throw an exeption if cannot end session
	 */
	public function endUserSession() {
		if (session_destroy()) {
			unset($_SESSION);
			$this->unsetData();
		} else {
			throw new \RuntimeException("Unable to end session \nRefresh the page and try to logout again");
		};
	}

	/**
	 * Return The session Data
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Set data
	 * @param array $data
	 */
	private function setData($data) {
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$this->data = array(
			'session_id' => $data['idUser'],
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'browser_info' => $browser,
			'last_session' => date("Y-m-d H:i:s"),
			'user_data' => $data
		);
	}

	/**
	 * reset data var to empty array
	 */
	public function unsetData() {
		$this->data = array();
	}

	/**
	 * Check if we have data stored
	 * @return boolean
	 */
	public function existSessionData() {
		$sessionData = $this->getData();
		if ($sessionData != NULL && !empty($sessionData)) {
			$state = TRUE;
		} else {
			$state = FALSE;
		}
		return $state;
	}

	/**
	 * Update some session var
	 */
	public function sessionUpdate() {
		if (existSessionData() == true) {
			$current_session = $this->getData();
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$id = $_SESSION['idUser'];
			$this->data['session_id'] = $id;
			$this->data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$this->data['browser_info'] = $browser;
			$this->data['last_session'] = date("Y-m-d H:i:s");
			foreach ($current_session as $key => $value) {
				$_SESSION[$key] = $value;
			}
		}
	}

	public static function run() {
		if (!isset($_SESSION['user_data'])) {
			//$this->sessionUpdate();
			header("Location: ./login");
			exit();
		} else {
			foreach ($_SESSION as $key => $value) {
				$this->data[$key] = $value;
			}
		}
	}

}