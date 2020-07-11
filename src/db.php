<?php
    
    // Class to connect to our service's database.
    class dbConnect {
        private $url, $server, $username, $password, $db, $conn;

        function __construct() {
            $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
            $server = $url["host"];
            $username = $url["user"];
            $password = $url["pass"];
            $db = substr($url["path"], 1);
        }

        // Funtion that creates a new mysqli connection and returns it.
        function connectToDB() {
            $conn = new mysqli($this->server, $this->username, $this->password, $this->db) or die("Couldn't connect to server.");
            return $conn;
        }

        // grabs event data based on the event id.
        function grabEventData($conn, $eventid) {
            $res = $conn->query("SELECT * FROM events WHERE eventid=$eventid");
            if ($res) {
                return $res->fetch_array(MYSQLI_ASSOC);
            } else {
                // return false on error.
                return false;
            }
        }
    }
?>