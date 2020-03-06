<?php 
require_once "service/serviceInterface.php";
require_once "dao/AttendeeDAO.php";
// General singleton class.
class AttendeeService implements Service {
    
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
            self::$instance = new AttendeeService();
        }
        
        return self::$instance;
    }

    public function getSingle($identifier)
    {
        
    }

    public function getAll()
    {
        $attendeeDAO = AttendeeDAO::getInstance();
        return $attendeeDAO->getUsers();
    }
    public function updateAttendee($attendeeId, $name, $password, $role){
        $attendeeDAO = AttendeeDAO::getInstance();
        return $attendeeDAO->updateAttendee($attendeeId, $name, $password, $role);
    }

    public function deleteAttendee($attendeeId){
        $attendeeDAO = AttendeeDAO::getInstance();
        //return $attendeeDAO->deleteAttendee($attendeeId);
    }

    public function checkCredential($username, $password){
        $attendeeDAO = AttendeeDAO::getInstance();
        return $attendeeDAO->checkCredential($username, $password);
    }
}

?>