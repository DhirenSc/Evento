<?php
class Venue {

    private $idvenue;
    private $name;
    private $capacity;

    public function getVenueId(){
        return $this->idvenue;
    }

    public function getName(){
        return $this->name;
    }

    public function getCapacity(){
        return $this->capacity;
    }
    
    public function getObjectAsArray(){
        return get_object_vars($this);
    }
}
?>