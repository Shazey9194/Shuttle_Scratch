<?php

/**
 * The base model
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 */
abstract class BaseModel
{

    /**
     * 
     * @var PDO The PDO instance
     */
    protected $db;

    /**
     * 
     * @var string The DB host name
     */
    protected $host;

    /**
     * 
     * @var string The DB name
     */
    protected $database;

    /**
     * 
     * @var string The DB user
     */
    protected $user;

    /**
     * 
     * @var string The DB password
     */
    protected $password;

    /**
     * 
     * @var string The DB table name
     */
    protected $table_name;

    /**
     * 
     * @var string The primary key field name
     */
    protected $primary_Key;

    /**
     * Construct
     * 
     */
    function __construct($table_name, $primary_Key) {
        
        $this->setHost('localhost');
        $this->setUser('root');
        $this->setPassword('');
        $this->setDatabase('shuttle');
        $this->setTable_name($table_name);
        $this->setPrimary_Key($primary_Key);
        $this->init();
    }

    /**
     * Initialise PDO
     * 
     */
    public function init() {
            try {
        $this->db = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getDatabase(), $this->getUser(), $this->getPassword());
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $this->db->exec("SET NAMES 'UTF8'");
            } catch(PDOException $ex) {
                
                print "ERROR : !".$ex->getMessage();
            }
            
    }

    public function close() {

        $this->db = NULL;
    }

    /**
     * 
     * @return array
     */
    public function loadAll($offset = 0, $limit = 0) {
        try{
        $sql = 'SELECT * FROM '.$this->getTable_name()." LIMIT :limit OFFSET :offset";
        $loadAll =$this->db->prepare($sql,array(PDO::ATTR_CURSOR =>PDO::CURSOR_FWDONLY));
        $loadAll->execute(array(':limit'=>$limit,':offset'=>$offset));
        return $loadAll->fetchAll();
        } catch (Exception $ex) {
            print " ERROR ! : ".$ex->getMessage();
        }  
    }

    /**
     * 
     * @return array
     */
    
     public function loadById($id) {
        $sql = 'SELECT * FROM'.$this->getTable_name()." WHERE ".$this->getPrimary_Key()."= :id";
         try {
        $loadById = $this->db->prepare($sql, array(PDO::ATTR_CURSOR =>PDO:: CURSOR_FWDONLY));
        $loadById->execute(array(':id'=>$id));
         return $loadById->fetch();
             
         } catch (Exception $ex) {
             print "ERROR ! : ".$ex->getMessage() ;     
         }
    }
 
    /**
     * 
     * @param type $id
     */
    
    public function deleteById($id) {
        $sql="DELETE FROM ".$this->getTable_name()." WHERE".$this->getPrimary_Key()."= :id";
        try{
            $delete_sql = $this->db->prepare($sql);
            $this->db->beginTransaction();
            $delete_sql->execute(array(':id'=>$id));
            $this->db->commit();
            $delete_sql->closeCursor();
            
            print 'Suppréssion effectué';
            
        } catch (Exception $ex) {
            $this->db->rollBack();
            print "ERROR ! : ".$ex->getMessage();
        }
    }
    
    /**
     * 
     * @param type $id
     * @param type $data
     */
    
    public function updateFields($id,$data) {
        $flag =0;
        $array_values_update=array();
        $array_execute=array();
        $i=1;
        $j=1;
        try {
            
         $sql = "UPDATE ".$this->getTable_name()." SET ";

        foreach ($data as $field => $value) 
         {
            if($flag ==0)
            {
            $sql.=' '.$field.' = :value'.$i;
            $flag =1;
            }
            else
            {
            $sql.=' '.', '.$field.' = :value'.$i;
            }
            
            array_push($array_values_update,$value);
            $i++;
         }
         
          $sql.=$this->getPrimary_Key().' = :id';
          
          foreach ($array_values_update as $values) {
              array_push($array_execute,array(':values'.$j=>$values));
              $j++;
          }
          
          array_push($array_execute,array(':id'=>$id));
          
          $update = $this->db->prepare($sql);
          $this->db->beginTransaction();
          $update->execute($array_execute);
          $this->db->commit();
          $update->closeCursor();
          print "Modification(s) enregistrée(s)";
         
        } catch (Exception $ex) {
            $this->db->rollBack();
            print "ERROR ! :".$ex->getMessage();
        }
        
    }
    
    /**
     * 
     * @param type $data
     */
    
    public function insertData($data) {
        
        $fields =array();
        $values= array();
        $values_execute=array();
        $flag=0;
  
     $sql ="INSERT INTO ".$this->getTable_name()." (";
     
     foreach ($data as $field =>$values) {
         
      array_push($fields,$field);
      array_push($values,$value);
           
     }
     
     foreach ($fields as $field) {
         
         if($flag==0)
         {
         $sql.=$field;
         $flag=1;
         }
         $sql.=", ".$field;
     }
     
     $sql.=")";
     
     $sql.=" VALUES (";
     foreach ($values as $value){
         $sql.='?,';
         if(end($values))
         {
             $sql.='?)';
         }
     }
     
     $insert = $this->db->prepare($sql);
     try
     {
      $this->db->beginTransaction();
      $insert->execute($values);
      $this->db->commit();
      $insert->closeCursor();
      
      print "Inscription enregistrée ";
      
         
     } catch (Exception $ex) {
         $this->db->rollBack();
         print "ERROR ! : ".$ex->getMessage();
     }
    }
    
    /**
     * 
     * @param type $data
     */
    
    public function save($data) {
        
        if(array_key_exists($this->getPrimary_Key(), $data))
        {
            updateFields($this->getPrimary_Key(),$data);
        }
           insertData($data);  
    }
    
    /**
     * 
     * @return type
     */
    
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
