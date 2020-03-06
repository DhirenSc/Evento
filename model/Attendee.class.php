<?php
class Attendee {

    private $idattendee;
    private $name;
    private $password;
    private $role;

    public function getAttendeeId(){
        return $this->idattendee;
    }

    public function getName(){
        return $this->name;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }

    public function getObjectAsArray(){
        return get_object_vars($this);
    }
    
}
?>