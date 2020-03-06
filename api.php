<?php

require_once "router.php";
require_once "service/eventService.php";
require_once "service/sessionService.php";
require_once "service/venueService.php";
require_once "service/attendeeService.php";
require_once "service/roleService.php";
require_once "validations.php";
/*
route('/', function () {
    return "Hello World";
});

route('/getEvents', function () {
    $eventService = EventService::getInstance();
    return arrayToJSON($eventService->getAll());
});

route('/getEvent', function() {
    $eventService = EventService::getInstance();
    return arrayToJSON($eventService->getSingle(2));
});

$action = $_SERVER['REQUEST_URI'];
dispatch($action);*/

function arrayToJSON($allInstances){
    $instanceArray = array();
    foreach ($allInstances as $instance) {
        array_push($instanceArray, $instance->getObjectAsArray());
    }
    return json_encode($instanceArray);
}

if(isset($_GET["method"]) && !empty($_GET['method'])){
    $method = trim($_GET['method']);
    
    switch($method){
        case "getEvents":
            $eventService = EventService::getInstance();
            if(isset($_GET['username'])){
                echo arrayToJSON($eventService->getEventByAttendee($_GET['username']));
            }
            else{
                echo arrayToJSON($eventService->getAll());
            }
        break;
        
        case "getEvent":
            if(isset($_GET['id'])){
                $eventService = EventService::getInstance();
                echo arrayToJSON($eventService->getSingle($_GET['id']));
            }
            else{
                echo "Invalid Parameter";
            }
        break;

        case "updateEvent":
            $eventService = EventService::getInstance();
            if(isset($_POST['eventId']) && isset($_POST['name']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['numberallowed']) && isset($_POST['vName'])){
                //echo numbers($_POST['sessionId'])."--".alphabeticSpace($_POST['name'])."--".validateDate($_POST['startdate'])."--".validateDate($_POST['enddate'])."--".numbers($_POST['numberallowed'])."--".alphabeticSpace($_POST['eventName']);
                if(numbers($_POST['eventId']) && alphabeticSpace($_POST['name']) && validateDate($_POST['startdate']) && validateDate($_POST['enddate']) && numbers($_POST['numberallowed']) && alphabeticSpace($_POST['vName'])){
                    echo $eventService->updateEvent(trim($_POST['eventId']), trim($_POST['name']), trim($_POST['startdate']), trim($_POST['enddate']), trim($_POST['numberallowed']), trim($_POST['vName']));
                }
                else{
                    echo "Invalid Datatype";
                }
            }
            else{
                echo "Invalid parameters";
            }
        break;

        case "deleteEvent":
            $eventService = EventService::getInstance();
            if(isset($_POST['eventId']) && numbers($_POST['eventId'])){
                echo $eventService->deleteEvent($_POST['eventId']);
            }
        break;

        case "getSessions":
            $sessionService = SessionService::getInstance();
            if(isset($_GET['username'])){
                echo arrayToJSON($sessionService->getSessionByAttendee($_GET['username']));
            }
            else if(isset($_GET['id'])){
                echo arrayToJSON($sessionService->getSessionByEvent($_GET['id']));
            }
            else{
                echo arrayToJSON($sessionService->getAll());
            }
        break;

        case "updateSession":
            $sessionService = SessionService::getInstance();
            if(isset($_POST['sessionId']) && isset($_POST['name']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['numberallowed']) && isset($_POST['eventName'])){
                //echo numbers($_POST['sessionId'])."--".alphabeticSpace($_POST['name'])."--".validateDate($_POST['startdate'])."--".validateDate($_POST['enddate'])."--".numbers($_POST['numberallowed'])."--".alphabeticSpace($_POST['eventName']);
                if(numbers($_POST['sessionId']) && alphabeticSpace($_POST['name']) && validateDate($_POST['startdate']) && validateDate($_POST['enddate']) && numbers($_POST['numberallowed']) && alphabeticSpace($_POST['eventName'])){
                    echo $sessionService->updateSession(trim($_POST['sessionId']), trim($_POST['name']), trim($_POST['startdate']), trim($_POST['enddate']), trim($_POST['numberallowed']), trim($_POST['eventName']));
                }
                else{
                    echo "Invalid Datatype";
                }
            }
            else{
                echo "Invalid parameters";
            }
        break;

        case "deleteSession":
            $sessionService = SessionService::getInstance();
            if(isset($_POST['sessionId']) && numbers($_POST['sessionId'])){
                echo $sessionService->deleteSession($_POST['sessionId']);
            }
        break;

        case "getVenues":
            $venueService = VenueService::getInstance();
            echo arrayToJSON($venueService->getAll());
        break;

        case "updateVenue":
            $venueService = VenueService::getInstance();
            if(isset($_POST['venueId']) && isset($_POST['name']) && isset($_POST['capacity'])){
                //echo numbers($_POST['sessionId'])."--".alphabeticSpace($_POST['name'])."--".validateDate($_POST['startdate'])."--".validateDate($_POST['enddate'])."--".numbers($_POST['numberallowed'])."--".alphabeticSpace($_POST['eventName']);
                if(numbers($_POST['venueId']) && alphabeticSpace($_POST['name']) && numbers($_POST['capacity'])){
                    echo $venueService->updateVenue(trim($_POST['venueId']), trim($_POST['name']), trim($_POST['capacity']));
                }
                else{
                    echo "Invalid Datatype";
                }
            }
            else{
                echo "Invalid parameters";
            }
        break;

        case "deleteVenue":
            $venueService = VenueService::getInstance();
            if(isset($_POST['venueId']) && numbers($_POST['venueId'])){
                echo $venueService->deleteVenue($_POST['venueId']);
            }
        break;

        case "getRoles":
            $roleService = RoleService::getInstance();
            echo arrayToJSON($roleService->getAll());
        break;

        case "getUsers":
            $attendeeService = AttendeeService::getInstance();
            echo arrayToJSON($attendeeService->getAll());
        break;

        case "updateUser":
            $attendeeService = AttendeeService::getInstance();
            if(isset($_POST['attendeeId']) && isset($_POST['name']) && isset($_POST['role']) && isset($_POST['password'])){
                //echo numbers($_POST['sessionId'])."--".alphabeticSpace($_POST['name'])."--".validateDate($_POST['startdate'])."--".validateDate($_POST['enddate'])."--".numbers($_POST['numberallowed'])."--".alphabeticSpace($_POST['eventName']);
                if(numbers($_POST['attendeeId']) && alphabeticSpace($_POST['name']) && alphabeticSpace($_POST['role']) && (alphabeticNumericPunct($_POST['password']) || $_POST['password'] == "")){
                    echo $attendeeService->updateAttendee(trim($_POST['attendeeId']), trim($_POST['name']), trim($_POST['password']), trim($_POST['role']));
                }
                else{
                    echo "Invalid Datatype";
                }
            }
            else{
                echo "Invalid parameters";
            }
        break;
    
    }
}

?>