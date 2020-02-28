<?php

require_once "./database/connection.php";
class VenueDAO{
    
    private $dbo;
    function __construct(){
        $this->dbo = new DB();
    }

    function getVenues(){
        $data = $this->dbo->getData("select * from venue", [], "Venue");
        /*if (count($data) > 0) {
            //$bigString = "<h2>Records Found: ".count($data)."</h2>\n";
            $bigString = "<table class='table table-bordered'><thead>\n
            <tr><th scope='col'>ID</th><th scope='col'>name</th><th scope='col'>capacity</th>
            </tr></thead><tbody>\n";
            foreach ($data as $row) {
                $bigString .= "<tr>
                <td>{$row['idvenue']}</a></td>
                <td>{$row['name']}</td><td>{$row['capacity']}</td>
                </tr>\n";
            }
            $bigString .= "</tbody></table>\n";
        } else {
            $bigString = "<h2>No venues exist.</h2>";
        }*/
        return $data;
    }
}
?>