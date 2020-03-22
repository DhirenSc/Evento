<?php
require_once __DIR__."/serviceInterface.php";
require __DIR__."/../dao/SessionDAO.php";
// General singleton class.
class SessionService implements Service {
    
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
            self::$instance = new SessionService();
        }
        
        return self::$instance;
    }

    public function getSingle($id) {
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->getSession($id);
    }
    
    public function getAll(){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->getSessions();  
    }

    public function getSessionByEvent($eventId){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->getSessionByEvent($eventId);
    }

    public function insertSession($name, $startDate, $endDate, $numberallowed, $eventName){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->insertSession($name, $startDate, $endDate, $numberallowed, $eventName);
    }

    public function updateSession($sessionId, $name, $startDate, $endDate, $numberallowed, $eventName){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->updateSession($sessionId, $name, $startDate, $endDate, $numberallowed, $eventName);
    }

    public function deleteSession($sessionId){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->deleteSession($sessionId);
    }

    public function getSessionByAttendee($username){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->getSessionByAttendee($username);
    }

    public function getSessionByManager($managerUsername){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->getSessionByManager($managerUsername);
    }

    public function registerSession($sessionId, $username){
        $sessionDAO = SessionDAO::getInstance();
        return $sessionDAO->registerSession($sessionId, $username);
    }
}

?>