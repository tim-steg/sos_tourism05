<?php
    
    // Class to connect to our service's database.
    class dbConnect {
        private $url;
        private $server;
        private $username;
        private $password;
        private $db;
        private $conn;

        function __construct() {
            // sets connection parameters
            $this->url = parse_url(getenv("CLEARDB_DATABASE_URL"));
            $this->server = $this->url["host"];
            $this->username = $this->url["user"];
            $this->password = $this->url["pass"];
            $this->db = substr($this->url["path"], 1);
            $this->conn = NULL;
        }

        // Funtion that creates a new mysqli connection and returns it.
        function connectToDB() {
            $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db) or die("Couldn't connect to server.");
        }

        // grabs event data based on the event id.
        function grabEventData($eventid) {
            $res = $this->conn->query("SELECT * FROM events WHERE eventid=$eventid");
            if ($res) {
                return $res->fetch_array(MYSQLI_ASSOC);
            } else {
                // return false on error.
                return false;
            }
        }

        // function to insert the core data for an event.
        function insertNewEvent($userid, $eventname, $organizer, $startdate, 
                                $enddate, $starttime, $endtime, $location, $descr, 
                                $timezone, $website, $tele, $email) {
            
        }

        // inserts all the various session data into a cross-reference table.
        function insertSessions($sessionArray) {
            
        }

        function closeConn() {
            $this->conn->close();
        }
    }
?>