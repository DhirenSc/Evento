<?php

require_once "./database/connection.php";
class RoleDAO{
    
    private $dbo;
    private static $instance = null;
    
    function __construct(){
        $this->dbo = new DB();
    }
    
    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new RoleDAO();
        }
        
        return self::$instance;
    }
    
    public function getRoles(){
        $roles = $this->dbo->getData("select * from role", [], "Role");
        return $roles;
    }
}
?>