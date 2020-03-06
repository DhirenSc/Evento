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

    public function getSingle($id) {
        $eventDAO = EventDAO::getInstance();
        return $eventDAO->getEvent($id);
    }
    
    public function getAll(){
        $eventDAO = EventDAO::getInstance();
        return $eventDAO->getEvents();  
    }

    public function updateEvent($eventId, $name, $startDate, $endDate, $numberallowed, $venueName){
        $eventDAO = EventDAO::getInstance();
        return $eventDAO->updateEvent($eventId, $name, $startDate, $endDate, $numberallowed, $venueName);
    }

    public function deleteEvent($eventId){
        $eventDAO = EventDAO::getInstance();
        return $eventDAO->deleteEvent($eventId);
    }

    public function getEventByAttendee($username){
        $eventDAO = EventDAO::getInstance();
        return $eventDAO->getEventByAttendee($username);
    }
}

?>