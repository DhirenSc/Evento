<?php
require_once __DIR__."/../database/connection.php";

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
        $sessions = $this->dbo->getData("select idsession, s.name, startdate, enddate, s.numberallowed, e.name as `event` from event e JOIN session s ON e.idevent=s.event where e.idevent=?", array($eventId), "Session");
        return $sessions;
    }

    public function getSession($eventId){
        $session = $this->dbo->getData("select idsession, s.name, startdate, enddate, s.numberallowed, e.name as `event` from event e JOIN session s ON e.idevent=s.event WHERE s.event=?", array($eventId), "Session");
        return $session;
    }

    public function insertSession($name, $startDate, $endDate, $numberallowed, $eventName){
        $checkSession = $this->dbo->getData("SELECT * FROM session WHERE name=? AND startdate=? AND enddate=? AND numberallowed=?", array($name, $startDate, $endDate, $numberallowed), "Session");
        if(count($checkSession) > 0){
            return "Session already exists";
        }
        else{
            $eventObject = $this->dbo->getData("SELECT idevent FROM event WHERE name=?", array($eventName), "Event");
            $eventId = $eventObject[0]->getIdEvent();
            $insertRowAffected = $this->dbo->modifyData("INSERT INTO session(name, startdate, enddate, numberallowed, event) VALUES(?,?,?,?,?)", array($name, $startDate, $endDate, $numberallowed, $eventId));
            return $insertRowAffected;   
        }
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

    public function getSessionByManager($managerUsername){
        $managerEvent = $this->dbo->getData("SELECT me.event FROM manager_event me JOIN attendee a ON me.manager = a.idattendee WHERE a.name=?", array($managerUsername), "ManagerEvent");
        $eventId = $managerEvent[0]->getEventId();
        return $this->getSessionByEvent($eventId);
    }

    public function registerSession($sessionId, $username){
        $event = $this->dbo->getData("SELECT * FROM session WHERE idsession=?", array($sessionId), "Session");
        $eventId = $event[0]->getIdEvent();
        $attendee = $this->dbo->getData("SELECT * FROM attendee WHERE name=?", array($username), "Attendee");
        $attendeeId = $attendee[0]->getAttendeeId();
        $addAttendeeSession = $this->dbo->modifyData("INSERT INTO attendee_session VALUES(?,?)", array($sessionId, $attendeeId));
        if($addAttendeeSession == 1){
            $addAttendeeEvent = $this->dbo->modifyData("INSERT INTO attendee_event VALUES(?,?)", array($eventId, $attendeeId, 0));
            if($addAttendeeEvent == 1){
                return $addAttendeeEvent;
            }
            else{
                return "Unable to register";
            }
        }
        else{
            return "Unable to register";
        }
    }
}
?>