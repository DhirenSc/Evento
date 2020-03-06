<?php
include_once "database/connection.php";

class SessionDAO {
    
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
            self::$instance = new SessionDAO();
        }
        
        return self::$instance;
    }

    public function getSessions(){
        $sessions = $this->dbo->getData("select idsession, s.name, startdate, enddate, s.numberallowed, e.name as `event` from event e JOIN session s ON e.idevent=s.event", [], "Session");
        return $sessions;
    }

    public function getSessionByEvent($eventId){
        $sessions = $this->dbo->getData("SELECT * FROM session WHERE event=?", array($eventId), "Session");
        return $sessions;
    }

    public function getSession($eventId){
        $session = $this->dbo->getData("select idsession, s.name, startdate, enddate, s.numberallowed, e.name as `event` from event e JOIN session s ON e.idevent=s.event WHERE s.event=?", array($eventId), "Session");
        return $session;
    }

    public function updateSession($sessionId, $name, $startDate, $endDate, $numberallowed, $eventName){
        $eventObject = $this->dbo->getData("SELECT idevent FROM event WHERE name=?", array($eventName), "Event");
        $eventId = $eventObject[0]->getIdEvent();
        $updateRowAffected = $this->dbo->modifyData("UPDATE session set name=?, startdate=?, enddate=?, numberallowed=? WHERE event=? AND idsession=?", array($name, $startDate, $endDate, $numberallowed, $eventId, $sessionId));
        return $updateRowAffected;
    }

    public function deleteSession($sessionId){
        $this->dbo->beginTransaction();
        $attendeeSessionRA = $this->dbo->modifyData("DELETE FROM attendee_session WHERE session=?", array($sessionId));
        if($attendeeSessionRA >= 0){
            $sessionDeleteRowsAffected = $this->dbo->modifyData("DELETE FROM session WHERE idsession=?", array($sessionId));
            if($sessionDeleteRowsAffected == 1){
                $this->dbo->commit();
                return $sessionDeleteRowsAffected;
            }
            else{
                $this->dbo->rollBack();
                return "Unable to delete session";
            }
        }
        else{
            $this->dbo->rollBack();
            return "Unable to delete session";
        }
    }

    public function getSessionByAttendee($username){
        $sessions = $this->dbo->getData("select s.idsession, s.name, startdate, enddate, s.numberallowed, e.name as `event` from event e JOIN session s ON e.idevent=s.event JOIN attendee_session ats ON s.idsession=ats.session JOIN attendee a ON ats.attendee=a.idattendee WHERE a.name=?", array($username), "Session");
        return $sessions;
    }
}
?>