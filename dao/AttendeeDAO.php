<?php

require_once "./database/connection.php";
class AttendeeDAO{
    
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
            self::$instance = new AttendeeDAO();
        }
        
        return self::$instance;
    }
    
    public function getUsers(){
        $attendees = $this->dbo->getData("select idattendee, a.name, r.name as `role` from attendee a join role r on a.role=r.idrole", [], "Attendee");
        return $attendees;
    }
    
    public function updateAttendee($attendeeId, $name, $password, $role){
        $role = $this->dbo->getData("SELECT idrole FROM role WHERE name=?", array($role), "Role");
        $roleId = $role[0]->getRoleId();
        if($attendeeId == 1){
            return "Unable to update attendee";
        }
        else{
            $updatedRowAffected = 0;
            if($password == ""){
                $updatedRowAffected = $this->dbo->modifyData("UPDATE attendee set name=?, role=? WHERE idattendee=?", array($name, $roleId, $attendeeId));
            }
            else{
                $updatedRowAffected = $this->dbo->modifyData("UPDATE attendee set name=?, password=?, role=? WHERE idattendee=?", array($name, $password, $roleId, $attendeeId));
            }
            if($updatedRowAffected == 1){
                return $updatedRowAffected;
            }
            else{
                return "Unable to update attendee";
            }
        }
        
    }
    
    public function checkCredential($username, $password){
        $attendee = $this->dbo->getData("SELECT idattendee, a.name, password, r.name as `role` FROM attendee a join role r ON a.role = r.idrole WHERE a.name=?", array($username), "Attendee");
        if(count($attendee) == 1){
            $dbPassword = hash("sha256",$password);
            if($attendee[0]->getName() == $username && $dbPassword == $attendee[0]->getPassword()){
                return $attendee[0]->getRole();
            }
            else{
                return "Wrong Credentials";
            }
        }
        else{
            return "Wrong Credentials";
        }
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