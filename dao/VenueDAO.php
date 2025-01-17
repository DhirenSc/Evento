<?php

require_once __DIR__."/../database/connection.php";
class VenueDAO{
    
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
            self::$instance = new VenueDAO();
        }
        
        return self::$instance;
    }
    
    public function getVenues(){
        $venues = $this->dbo->getData("select * from venue", [], "Venue");
        return $venues;
    }

    public function insertVenue($name, $capacity){
        $checkVenue = $this->dbo->getData("SELECT * FROM venue WHERE name=? AND capacity=?", array($name, intval($capacity)), "Venue");
        if(count($checkVenue) > 0){
            return "Venue already exists";
        }
        else{
            $insertRowAffected = $this->dbo->modifyData("INSERT INTO venue(name, capacity) VALUES(?, ?)", array($name, intval($capacity)));
            return $insertRowAffected;
        }
    }
    
    public function updateVenue($venueId, $name, $capacity){
        $updateRowAffected = $this->dbo->modifyData("UPDATE venue set name=?, capacity=? WHERE idvenue=?", array($name, $capacity, $venueId));
        return $updateRowAffected;
    }
    
    public function deleteVenue($venueId){
        $events = $this->dbo->getData("SELECT idevent FROM event WHERE venue=?", array($venueId), "Event");
        if(count($events) >= 1){
            return "Unable to delete Venue";
        }
        else{
            $deleteVenueRowAffected = $this->dbo->modifyData("DELETE FROM venue WHERE idvenue=?", array($venueId));
            if($deleteVenueRowAffected == 1){
                return $deleteVenueRowAffected;
            }
            else{
                return "Unable to delete Venue";
            }
        }
    }
}
?>