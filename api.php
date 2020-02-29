<?php

require_once "router.php";

route('/', function () {
    return "Hello World";
});

route('/getEvents', function () {
    require_once "service/eventService.php";
    $eventService = EventService::getInstance();
    return arrayToJSON($eventService->getAll());
});

function arrayToJSON($allInstances){
    $instanceArray = array();
    foreach ($allInstances as $instance) {
        array_push($instanceArray, $instance->getObjectAsArray());
    }
    return json_encode($instanceArray);
}

$action = $_SERVER['REQUEST_URI'];
dispatch($action);
?>