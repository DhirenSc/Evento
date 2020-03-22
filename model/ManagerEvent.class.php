<?php
class ManagerEvent {

    private $event;
    private $manager;

    public function getEventId(){
        return $this->event;
    }

    public function getManager(){
        return $this->manager;
    }

    public function getObjectAsArray(){
        return get_object_vars($this);
    }
}
?>