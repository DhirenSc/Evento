<?php
include_once "database/connection.php";

class EventDAO {
    
    private $dbo;
    // Hold the class instance.
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
            self::$instance = new EventDAO();
        }
        
        return self::$instance;
    }

    public function getEvents(){
        $data = $this->dbo->getData("select idevent, e.name, datestart, dateend, numberallowed, v.name as `venue` from event e JOIN venue v ON e.venue=v.idvenue", [], "Event");


        return $data;
        /*
        $allEvents = array();
        foreach ($data as $row) {
            $event = array(
                "id" => $row->getIdevent(),
                "name" => $row->getName(),
                "datestart" => $row->getDatestart(),
                "dateend" => $row->getDateend(),
                "venue" => $row->getVenue()
            );
            array_push($allEvents, $event);
        }
        return $allEvents;
        */
    }
}
?>