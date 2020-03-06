<?php
class Role {

    private $idrole;
    private $name;

    public function getRoleId(){
        return $this->idrole;
    }

    public function getName(){
        return $this->name;
    }
    
    public function getObjectAsArray(){
        return get_object_vars($this);
    }
}
?>