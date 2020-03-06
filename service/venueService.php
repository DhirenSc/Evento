<?php 
require_once "service/serviceInterface.php";
require_once "dao/VenueDAO.php";
// General singleton class.
class VenueService implements Service {
    
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
            self::$instance = new VenueService();
        }
        
        return self::$instance;
    }
    
    public function getAll(){
        $venueDAO = VenueDAO::getInstance();
        return $venueDAO->getVenues();  
    }

    public function getSingle($identifier)
    {
        
    }

    public function updateVenue($venueId, $name, $capacity){
        $venueDAO = VenueDAO::getInstance();
        return $venueDAO->updateVenue($venueId, $name, $capacity);
    }

    public function deleteVenue($venueId){
        $venueDAO = VenueDAO::getInstance();
        return $venueDAO->deleteVenue($venueId);
    }
}

?>