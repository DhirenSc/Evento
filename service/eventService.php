<?php 
include "serviceInterface.php";
include "dao/EventDAO.php";
// General singleton class.
class EventService implements Service {
    
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
            self::$instance = new EventService();
        }
        
        return self::$instance;
    }

    public function getSingle() {

    }
    
    public function getAll(){
        $eventDAO = EventDAO::getInstance();
        return $eventDAO->getEvents();  
    }
}

?>