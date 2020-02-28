<?php
class Event {

    private $eventId;
    private $name;
    private $datestart;
    private $dateend;
    private $numberallowed;
    private $venueId;

    public function getName(){
        return $this->name;
    }

    public function getDatestart(){
        return $this->datestart;
    }

    public function getDateend(){
        return $this->dateend;
    }

    public function getNumberAllowed(){
        return $this->numberallowed;
    }

    public function getVenue(){
        return $this->venueId;
    }
    
}
?>