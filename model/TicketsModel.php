<?php
/**
 * The user model
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */

require_once './model/BaseModel.php';

class TicketsModel extends BaseModel {

	/**
	 * 
	 */
	public function __construct() {
		parent::__construct('user', 'idUser');
	}

}
