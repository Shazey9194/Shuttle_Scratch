<?php

/**
 * The base model
 * 
 * @author Alann Dragin <a.dragin@insta.fr>
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 * @author Alex Maxime Cadevall <a.cadevall@insta.fr>
 */
abstract class BaseModel
{

    /**
     * The PDO instance
     * 
     * @var \PDO
     */
    protected $db;

    /**
     *
     * @var type 
     */
    public $query;

    /**
     *
     * @var type 
     */
    protected $config;

    /**
     *
     * @var type 
     */
    protected $table;

    /**
     * The primary key field name or name in a table
     * 
     * @var integer
     */
    protected $primaryKey;

    /**
     * Constructor
     * 
     * @param string $table The DataBase table name <b>REQUIRED</b>
     * @param string $primaryKey The primary key field name <b>OPTIONAL</b>
     */
    function __construct($table, $primaryKey) {

        $this->query = array(
            'select' => '',
            'from' => '',
            'where' => '',
            'join' => '',
            'orderBy' => '',
            'limit' => '',
        );

        $this->config = array(
            'host' => 'localhost',
            'database' => 'shuttle',
            'user' => 'root',
            'password' => '',
            'charset' => 'UTF8'
        );

        $this->table = $table;
        $this->primaryKey = $primaryKey;

        $this->init();
    }

    /**
     * Initialise PDO Object
     * 
     * @return void
     * @throws Exception PDOException
     */
    protected function init() {

        try {
            $this->db = new PDO('mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['database'], $this->config['user'], $this->config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db->exec('SET NAMES "' . $this->config['charset'] . '"');
        } catch (PDOException $ex) {
            print 'Unable to connect to Database ! Check configuration in "init()" method !\nERROR : !' . $ex->getMessage();
        }
    }

    /**
     * Unset PDO Objects
     * 
     * @return void
     */
    protected function close() {

        $this->db = NULL;
    }

    /**
     * 
     * @return string $sql The SQL query
     */
    public function buildQuery() {

        if ($this->query['select'] != '') {
            $sql = 'SELECT ' . $this->query['select'];
        } else {
            $sql = 'SELECT *';
        }

        if ($this->query['from'] != '') {
            $sql .= ' FROM ' . $this->query['from'];
        } else {
            $sql .= ' FROM ' . $this->table;
        }

        $sql .= $this->query['join'];


        if ($this->query['where'] != '') {
            $sql .= ' WHERE ' . $this->query['where'];
        }

        $sql .= $this->query['orderBy'] . $this->query['limit'];

        return (string) $sql;
    }

    /**
     * Build a 'select' query
     * 
     * @param array $columns
     */
    public function select($columns = array()) {

        if (!empty($columns)) {

            if ($this->query['select'] != '') {
                $this->query['select'] .= ',';
            }

            $this->query['select'] .= implode(',', $columns);
        }

        return $this;
    }

    /**
     * Build a 'from' query
     * 
     * @param array $tables
     */
    public function from($tables = array()) {

        if (!empty($tables)) {

            if ($this->query['from'] != '') {
                $this->query['from'] .= ',';
            }

            $this->query['from'] .= implode(',', $tables);
        }

        return $this;
    }

    /**
     * Build a 'join' query
     * 
     * @param string $table The joined table
     * @param string $ref The reference clause
     */
    public function join($table = null, $ref = null) {

        if (!is_null($table) and !is_null($ref)) {

            $this->query['join'] .= ' JOIN ' . $table . ' ON ' . $ref;
        }

        return $this;
    }

    /**
     * Build a 'where' query
     * 
     * @param array $clauses
     */
    public function where($clauses = array(), $logic = 'AND') {

        if (!empty($clauses)) {

            if ($this->query['where'] != '') {
                $this->query['where'] .= ' ' . $logic . ' ';
            }

            $this->query['where'] .= '(' . implode(' AND ', $clauses) . ')';
        }

        return $this;
    }

    /**
     * Build an 'order by' query
     * 
     * @param array $columns The ordered columns
     * @param string The ordering way
     */
    public function orderBy($columns = array(), $way = 'ASC') {

        if (!empty($columns)) {
            $this->query['orderBy'] = ' ORDER BY ' . implode(',', $columns) . ' ' . $way;
        }

        return $this;
    }

    /**
     * Build a 'limit' query
     * 
     * @param int $offet The query offset
     * @param int $limit The query limit
     */
    public function limit($offset = 0, $limit = 1) {

        if ($limit > 0 and $offset >= 0) {
            $this->query['limit'] = ' LIMIT ' . $offset . ', ' . $limit;
        }

        return $this;
    }

}
