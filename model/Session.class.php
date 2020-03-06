<?php
class Session {

    private $idsession;
    private $name;
    private $startdate;
    private $enddate;
    private $numberallowed;
    private $event;
    
    public function getIdSession(){
        return $this->idsession;
    }

    public function getName(){
        return $this->name;
    }

    public function getDatestart(){
        return $this->startdate;
    }

    public function getDateend(){
        return $this->enddate;
    }

    public function getNumberAllowed(){
        return $this->numberallowed;
    }

    public function getEvent(){
        return $this->event;
    }

    public function getObjectAsArray(){
        return get_object_vars($this);
    }
}
?>