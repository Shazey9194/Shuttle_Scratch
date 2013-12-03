<?php

require_once './model/BaseModel.php';

/**
 * The user model
 * 
 * @author Alann Dragin <a.dragin@insta.fr>
 * 
 */

class ProjectsModel extends BaseModel{
    
  function __construct() {
        parent::__construct('project', 'idProject');
    }
	
	public function close() {
		parent::close();
	}

	public function deleteByIdProject($id) {
        
  
         $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id';
        $deleteById = $this->db->prepare($sql);

        return $deleteById->execute(array(':id' => $id));
        
	}

	
	public function init() {
		parent::init();
	}
    
	public function loadAll($offset = 0, $limit = 0) {
		return parent::loadAll($offset, $limit);
	}

	public function loadById($id, $columns = array()) {
        return parent::loadById($id, $columns);
    }

    public function save($data, $table = null) {
        return parent::save($data, $table);
    }

     public function createProject($data) {
        $sql = 'INSERT INTO ';
        $sql .= $this->table;
        $sql .= ' (' . implode(',', array_keys($data)) . ') VALUES (:' . implode(',:', array_keys($data)) . ')';

        $insert = $this->db->prepare($sql);

        return $insert->execute($data);
    }
}

