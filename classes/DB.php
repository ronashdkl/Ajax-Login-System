<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  
 */
class DB {
    private static $_instance = NULL;
    private $_pdo,
            $_query,
            $_error = FALSE,
            $_results,
            $_count = 0;
    
    private function __construct() {
        try{
           
           $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),  Config::get('mysql/username'),  Config::get('mysql/password'));
       
            } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public static function getIntance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    
    public function query($sql, $parms = array()){
        $this->_error = FALSE;
        if($this->_query = $this->_pdo->prepare($sql)){
           $x=1;
            if(count($parms)){
               foreach ($parms as $parm){
                   $this->_query->bindValue($x, $parm);
                    $x++;
                           
               }
           }
           if($this->_query->execute()){
               $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
               $this->_count = $this->_query->rowCount();
           }else{
               $this->_error = TRUE;
           }
        }
        return $this;
    }
    
    
    public function action($action, $table, $where = array()){
        
        if(count($where)===3){
            $operators = array('=','>','<','<=','>=');
            
            $feild = $where[0];
            $operator = $where[1];
            $value  = $where[2];
        
            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$feild} {$operator} ?";
           if(!$this->query($sql, array($value))->error()){
               return $this;
           }
                }
            
        }
        return false;
    }
    public function get($table, $where){
        return $this->action("SELECT *", $table, $where);
    }
    public function result() {
        return $this->_results;
    }
    public function first(){
        return $this->result()[0];
    }
    
    
    public function insert($table, $feilds = array()){
        if(count($feilds)){
            $keys = array_keys($feilds);
            $values = '';
            $x =1;
            foreach ($feilds as $feild) {
                $values.='?';
                if($x < count($feilds)){
                    $values .= ', ';
                }
                $x++;
            }
         
           $sql = "INSERT INTO {$table} (`".implode('`,`', $keys)."`) VALUES({$values})";
          
            if(!$this->query($sql, $feilds)->error()){
               return TRUE;
           }
          
        }
        return FALSE;
    }
    public function update($table, $id, $fields){
        $set = '';
        $x = 1;
        
        foreach ($fields as $name => $value) {
            $set .="{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        
       $sql= "UPDATE {$table} SET {$set} WHERE id = {$id}";
       if(!$this->query($sql, $fields)->error()){
               return TRUE;
           }
           return FALSE;
    }
    public function delete($table, $where){
       return $this->action("DELETE ", $table, $where);
    }  
    public function count(){
        return $this->_count;
    }

    public function error(){
        return $this->_error;
    }
}