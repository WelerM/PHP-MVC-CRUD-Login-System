<?php


namespace core\classes;

use Exception;
use PDO;
use PDOException;

$root = $_SERVER["DOCUMENT_ROOT"] . '/buildlookmvc';
require_once  $root . '/config.php';

class Database
{
    private $conn;

    private function turn_on()
    {
        $this->conn = new PDO(
            'mysql:'.
            'host='.MYSQL_SERVER.';'.
            'dbname='.MYSQL_DATABASE.';'.
            'charset='.MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );

        //debug 
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 }

    private function turn_off()
    {

        $this->conn = null;
    }

    public function select($sql, $params = null)
    {
        $sql = trim($sql);
        //Verifies if it's a "SELECT" instruction
        if (!preg_match("/^SELECT/i", $sql)) {
            throw new Exception("DATABASE - not a SELECT instruction");
        }

        $this->turn_on();

        $results = null;

        try {
            if (!empty($params)) {
                $execute = $this->conn->prepare($sql);
                $execute->execute($params);
                $results = $execute->fetchAll(PDO::FETCH_CLASS);
            }else{
                $execute = $this->conn->prepare($sql);
                $execute->execute();
                $results = $execute->fetchAll(PDO::FETCH_CLASS);
            }
        
        } catch (PDOException $e) {
            return false;
        }


        $this->turn_off();

        return $results;
    }

    public function insert($sql, $params = null)
    {
        $sql = trim($sql);
        //Verifies if it's a "INSERT" instruction
        if (!preg_match("/^INSERT/i", $sql)) {
            throw new Exception("DATABASE - not a insert instruction");
        }

        $this->turn_on();

        $results = null;

        try {
            if (!empty($params)) {
                $execute = $this->conn->prepare($sql);
                $execute->execute($params);

            }else{
                $execute = $this->conn->prepare($sql);
                $execute->execute();
               
            }

        
        } catch (PDOException $e) {
            return false;
        }


        $this->turn_off();

    }

    public function update($sql, $params = null)
    {
        $sql = trim($sql);
        //Verifies if it's a "update" instruction
        if (!preg_match("/^UPDATE/i", $sql)) {
            throw new Exception("DATABASE - not a update instruction");
        }

        $this->turn_on();

        $results = null;

        try {
            if (!empty($params)) {
                $execute = $this->conn->prepare($sql);
                $execute->execute($params);

            }else{
                $execute = $this->conn->prepare($sql);
                $execute->execute();
               
            }

        
        } catch (PDOException $e) {
            return false;
        }


        $this->turn_off();

    }
    
    public function delete($sql, $params = null)
    {
        $sql = trim($sql);
        //Verifies if it's a "DELETE" instruction
        if (!preg_match("/^DELETE/i", $sql)) {
            throw new Exception("DATABASE - not a DELETE instruction");
        }

        $this->turn_on();

        $results = null;

        try {
            if (!empty($params)) {
                $execute = $this->conn->prepare($sql);
                $execute->execute($params);

            }else{
                $execute = $this->conn->prepare($sql);
                $execute->execute();
               
            }

        
        } catch (PDOException $e) {
            return false;
        }


        $this->turn_off();

    }
    
}

