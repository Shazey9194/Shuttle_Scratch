<?php

abstract class BaseModel
{

    /**
     * @var PDO The PDO instance
     * 
     */
    protected $db;

    /**
     * @var string The DB host name
     * 
     */
    protected $host;

    /**
     * @var string The DB name
     *
     */
    protected $database;

    /**
     * @var string The DB user
     *
     */
    protected $user;

    /**
     * @var string The DB password
     * 
     */
    protected $password;

    /**
     * @var string The DB table name
     * 
     */
    protected $table_name;

    /**
     * @var string The primary key field name 
     * 
     */
    protected $primary_Key;

    /**
     * Construct
     * 
     */
    function __construct() {
        $this->setHost('localhost');
        $this->setUser('root');
        $this->setPassword('');
        $this->setDatabase('shuttle');

        $this->init();
    }

    /**
     * Initialise PDO
     */
    public function init() {
        $this->db = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getDatabase(), $this->getUser(), $this->getPassword());
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->exec("SET NAMES 'UTF8'");
    }

    /**
     * 
     * @return array
     */
    public function loadAll($offset = null, $limit = null) {
        
    }

    /**
     * 
     * @return array
     */
    public function loadById($id) {
        
    }

    public function getDb() {
        return $this->db;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function setDatabase($database) {
        $this->database = $database;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getTable_name() {
        return $this->table_name;
    }

    public function setTable_name($table_name) {
        $this->table_name = $table_name;
    }

    public function getPrimary_Key() {
        return $this->primary_Key;
    }

    public function setPrimary_Key($primary_Key) {
        $this->primary_Key = $primary_Key;
    }

}