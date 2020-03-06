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
        $events = $this->dbo->getData("select idevent, e.name, datestart, dateend, numberallowed, v.name as `venue` from event e JOIN venue v ON e.venue=v.idvenue", [], "Event");
        return $events;
    }

    public function getEvent($eventId){
        $event = $this->dbo->getData("select idevent, e.name, datestart, dateend, numberallowed, v.name as `venue` from event e JOIN venue v ON e.venue=v.idvenue WHERE idevent=?", array($eventId), "Event");
        return $event;
    }

    public function addEvent($eventName, $datestart, $dateend, $numberallowed, $venue){
        $venueObject = $this->dbo->getData("SELECT idvenue FROM venue WHERE name=?", array($venue), "Venue");
        $venueId = $venueObject[0]->getVenueId();
        $addRowAffected = $this->dbo->modifyData("INSERT INTO EVENT(name, datestart, dateend, numberallowed, venue) VALUES(?,?,?,?,?)", array($eventName, $datestart, $dateend, $numberallowed, $venueId));
        return $addRowAffected;
    }

    public function updateEvent($eventId, $name, $startDate, $endDate, $numberallowed, $venueName){
        $venueObject = $this->dbo->getData("SELECT idvenue FROM venue WHERE name=?", array($venueName), "Venue");
        $venueId = $venueObject[0]->getVenueId();
        $updateRowAffected = $this->dbo->modifyData("UPDATE event SET name=?, datestart=?, dateend=?, numberallowed=?, venue=? WHERE idevent=?", array($name, $startDate, $endDate, $numberallowed, $venueId, $eventId));
        return $updateRowAffected;
    }

    public function deleteEvent($eventId){
        $this->dbo->beginTransaction();
        $deleteManagerEventRowsAff = $this->dbo->modifyData("DELETE FROM manager_event WHERE event=?", array($eventId));
        if($deleteManagerEventRowsAff >= 0){
            $attendeeEventRowsAff = $this->dbo->modifyData("DELETE FROM attendee_event WHERE event=?", array($eventId));
            if($attendeeEventRowsAff >= 0){
                $flag = false;
                $eventSessions = $this->dbo->getData("SELECT * FROM session WHERE event=?", array($eventId), "Session");
                foreach ($eventSessions as $session) {
                    $sessionId = $session->getObjectAsArray()['idsession'];
                    $attendeeSessionRA = $this->dbo->modifyData("DELETE FROM attendee_session WHERE session=?", array($sessionId));
                    $sessionDeleteRowsAffected = $this->dbo->modifyData("DELETE FROM session WHERE idsession=?", array($sessionId));
                    if($attendeeSessionRA >= 0 && $sessionDeleteRowsAffected >= 0){
                        $flag = true;
                    }
                    else{
                        $flag = false;
                    break;
                    }
                }
                if($flag == false){
                    $this->dbo->rollBack();
                    return "Unable to delete event";
                }
                else{
                    $deleteEventRowsAff = $this->dbo->modifyData("DELETE FROM event WHERE idevent=?", array($eventId));
                    if($deleteEventRowsAff == 1){
                        $this->dbo->commit();
                        return $deleteEventRowsAff;
                    }
                    else{
                        $this->dbo->rollBack();
                        return "Unable to delete event";
                    }
                }
            }
            else{
                $this->dbo->rollBack();
                return "Unable to delete event";
            }
        }
        else{
            $this->dbo->rollBack();
            return "Unable to delete event";
        }
    }

    public function getEventByAttendee($username){
        $events = $this->dbo->getData("select idevent, e.name, datestart, dateend, numberallowed, v.name as `venue` from event e JOIN venue v ON e.venue=v.idvenue JOIN attendee_event ae ON e.idevent=ae.event JOIN attendee a ON ae.attendee=a.idattendee WHERE a.name=?", array($username), "Event");
        return $events;
    }
}
?>