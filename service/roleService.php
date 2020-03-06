<?php 
require_once "service/serviceInterface.php";
require_once "dao/RoleDAO.php";
// General singleton class.
class RoleService implements Service {
    
    // Hold the class instance.
    private static $instance = null;
    
    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here.
    }
    
    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new RoleService();
        }
        
        return self::$instance;
    }
    
    public function getAll(){
        $roleDAO = RoleDAO::getInstance();
        return $roleDAO->getRoles();  
    }

    public function getSingle($identifier)
    {
        
    }
}

?>