<?php

/**
 * The user model
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
require_once './model/BaseModel.php';

class TicketsModel extends BaseModel {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct('ticket', 'idTicket');
	}

	/**
	 * 
	 * @param array $data
	 * @return boolean
	 */
	public function submit($data) {
		return $this->save($data);
	}

	/**
	 * 
	 * @param type $offset
	 * @param type $limit
	 */
	public function loadAllTickets($offset = 0, $limit = 0) {
		$query = $this->select()
						->from(array($this->table))
						->join('user', 'user.idUser = ' . $this->table . '.openBy')
						->limit($offset, $limit)->buildQuery();
		$result = $this->db->prepare($query);
		$result->execute();
		return $result->fetchAll();
	}

	/**
	 * 
	 * @param int $idUser
	 * @return array
	 */
	public function loadById($idTicket, $columns = array()){
		$query = $this->select($columns)
					  ->from(array($this->table))
					  ->join('user', 'user.idUser = ' . $this->table . '.openBy')
					  ->join('tickettype', 'tickettype.idTicketType = ' . $this->table . '.type')
					  ->where(array($this->primaryKey  . ' = :idTicket'))->buildQuery();
		$result = $this->db->prepare($query);
		$result->execute(array(':idTicket' => $idTicket));
		return $result->fetch();
	}

	/**
	 * 
	 * @param int $idUser
	 * @return array
	 */
	public function loadTicketsOpenBy($idUser) {
		/* $query = $this->db->select()
		  ->from($this->table_name)
		  ->where('openBy', $idUser);

		  return $query->get()->result(); */
	}

	/**
	 * 
	 * @param int $idUser
	 * @return array
	 */
	public function loadTicketsAssignedTo($idUser) {
		/* $query = $this->db->select()
		  ->from($this->table_name)
		  ->where('assignedTo', $idUser);

		  return $query->get()->result(); */
	}

	/**
	 * 
	 * @param array $data
	 * @return array
	 */
	public function loadTicketTypes() {
		$query = $this->select()->from(array('tickettype'))->buildQuery();
		$result = $this->db->prepare($query);
		$result->execute();
		return $result->fetchAll();
	}

	/**
	 * 
	 * @param array $data
	 * @return array
	 */
	public function loadProjectList() {
		$query = $this->select()->from(array('project'))->buildQuery();
		$result = $this->db->prepare($query);
		$result->execute();
		return $result->fetchAll();
	}

}
