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
        
        private function insertReqs($eventid, $reqs) {
            // inserts the recommended precautions into its own table.
            $stmt = $this->conn->prepare("INSERT INTO reqs (`eventid`, `facemasks`, `sanitizer`, `tempcheck`, `inoroutdoor`, `notrecage`, `caplimit`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiiiii", $eventid, $reqs[0], $reqs[1], $reqs[2], $reqs[3], $reqs[4], $reqs[5]);
        }

        // inserts all the various session data into a cross-reference table.
        private function insertSessions($eventid, $sessionName, $sessionDesc) {
            try {
                $list = array_combine($sessionName, $sessionDesc);

                $stmt = $this->conn->prepare("INSERT INTO sessions (eventid, eventname, eventdesc) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $eventid, $eventname, $eventdesc);

                foreach ($list as $session) {
                    $stmt->execute();
                }

            } catch (Exception $err) {
                return $err;
            }
        }

        // function to insert the core data for an event.
        function insertNewEvent($userid, $eventname, $organizer, $startdate, 
                                $enddate, $location, $descr, $timezone, $website, $tele, 
                                $email, $reqs, $sessName, $sessDesc) {
            
            try {
                $stmt = $this->conn->prepare("INSERT INTO events (`userid`, `eventname`, `organizer`, `startdate`,
                `enddate`, `location`, `descr`, `timezone`, `website`, `telephone`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param("issssssssss", $userid, $eventname, $organizer, $startdate, 
                                                $enddate, $location, $descr, 
                                                $timezone, $website, $tele, $email);

                $stmt->execute();

                $eventid = $this->conn->insert_id;
                $this->insertReqs($eventid, $reqs);
                $this->insertSessions($eventid, $sessName, $sessDesc);
            } catch (Exception $err) {
                return $err;
            }
        }

        function closeConn() {
            $this->conn->close();
        }
    }
?>