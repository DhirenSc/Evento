<?php
class DB {
    
    private $dbh;
    
    function __construct(){
        try{
            $this->dbh  = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}", $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo $e->getMessage();
            die("Bad Database Connection");
        }
    }//constructor

    function getData($query, $args, $modelName){
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($args);
        require_once "./model/".$modelName.".class.php";
        $resultByClass = $stmt->fetchAll(PDO::FETCH_CLASS,$modelName);
        return $resultByClass;
    }

    function modifyData($query, $args){
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($args);
        return $stmt->rowCount();
    }
}
?>