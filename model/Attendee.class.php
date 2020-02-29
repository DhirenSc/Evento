<?php
class Attendee {

    private $idattendee;
    private $name;
    private $password;
    private $role;

    public function getName(){
        return $this->name;
    }

    private function getPassword(){
        return $this->password;
    }

    private function getRole(){
        return $this->role;
    }
    
}
?>