<?php

require_once "./database/connection.php";
class VenueDAO{
    
    private $dbo;
    function __construct(){
        $this->dbo = new DB();
    }

    function getVenues(){
        $data = $this->dbo->getData("select * from venue", [], "Venue");
        
        return $data;
    }
}
?>