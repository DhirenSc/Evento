<?php

require_once __DIR__."/../database/connection.php";
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

    public function insertAttendee($name, $password, $role){
        $checkAttendee = $this->dbo->getData("SELECT * FROM attendee WHERE name=? AND role=?", array($name, $role), "Attendee");
        if(count($checkAttendee) > 0){
            return "User already exists";
        }
        else{
            $role = $this->dbo->getData("SELECT idrole FROM role WHERE name=?", array($role), "Role");
            $roleId = $role[0]->getRoleId();
            $addRowAffected = $this->dbo->modifyData("INSERT INTO attendee(name, password, role) VALUES(?,?,?)", array($name, hash("sha256",$password), $roleId));
            if($addRowAffected == 1){
                return $addRowAffected;
            }
            else{
                return "Unable to add user";
            }
        }
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

    public function deleteUser($attendeeId){
        $this->dbo->beginTransaction();
        $deleteManagerEvent = $this->dbo->modifyData("DELETE FROM manager_event WHERE manager=?", array($attendeeId));
        if($deleteManagerEvent >= 0){
            $deleteSessionAttendee = $this->dbo->modifyData("DELETE FROM attendee_session WHERE attendee=?", array($attendeeId));
            if($deleteSessionAttendee >= 0){
                $deleteEventAttendee = $this->dbo->modifyData("DELETE FROM attendee_event WHERE attendee=?", array($attendeeId));
                if($deleteEventAttendee >= 0){
                    $deleteAttendee = $this->dbo->modifyData("DELETE FROM attendee WHERE idattendee=?", array($attendeeId));
                    if($deleteAttendee == 1){
                        $this->dbo->commit();
                        return $deleteAttendee;
                    }
                    else{
                        $this->dbo->rollBack();
                        return "Unable to delete attendee";
                    }
                }
                else{
                    $this->dbo->rollBack();
                    return "Unable to delete attendee";
                }
            }
            else{
                $this->dbo->rollBack();
                return "Unable to delete attendee";
            }
        }
        else{
            $this->dbo->rollBack();
            return "Unable to delete attendee";
        }
    }
}
?>