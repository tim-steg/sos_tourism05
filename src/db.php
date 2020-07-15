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
                $i = 0;

                $name = "";
                $desc = "";

                $stmt = $this->conn->prepare("INSERT INTO sessions (`eventid`, `sessname`, `sessdesc`) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $eventid, $name, $desc);

                for ($i = 0; $i < count($sessionName); $i++) {
                    $name = $sessionName[$i];
                    $desc = $sessionDesc[$i];
                    $stmt->execute();
                }

            } catch (Exception $e) {
                die("Exception Error: ".$e->getMessage()."\n");
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
            } catch (Exception $e) {
                die("Exception Error: ".$e->getMessage()."\n");
            }
        }

        // checks if an account already exists on-signup with the same username or email.
        function accAlExists($email, $username) {
            try {
                $numrows = -1;
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                $numrows = $stmt->num_rows();

                if ($numrows >= 1) {
                    // account exists, has the same email.
                    return true;
                } else if ($numrows <= 0) {
                    $numrows = -1;
                    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $stmt->store_result();
                    $numrows = $stmt->num_rows();

                    if ($numrows >= 1) {
                        // has same username
                        return true;
                    }

                    // account doesn't exist.
                    return false;
                }
            } catch (Exception $e) {
                die("Exception Error: ".$e->getMessage()."\n");
            }
        }

        // creates a new user entry on the database.
        function createUser($email, $username, $password) {
            try {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("INSERT INTO users (`email`, `password`, `username`, `status`) VALUES (?, ?, ?, ?)");
                if ($stmt) {
                    $num = 1;
                    $stmt->bind_param("sssi", $email, $hash, $username, $num);
                    $stmt->execute();
                }
            } catch (Exception $e) {
                die("Exception Error: " .$e->getMessage()."\n");
            }
        }

        function closeConn() {
            $this->conn->close();
        }

        // checks the user credentials against the database, and returns true if they match.
        function checkLogin($username, $password) {
            $dbusername = ""; $dbhash = "";

            $stmt = $this->conn->prepare("SELECT `username`, `password` FROM events WHERE username=?");
            if ($stmt == true) {
                $stmt->bind_param("s",$username);
                $stmt->execute();
                $stmt->bind_result($dbusername, $pwhash);
                $stmt->fetch();

                $verify = password_verify($password, $pwhash);
                if ($verify == true) {
                    // user credentials match
                    return true;
                }
            }
            // user credentials don't match, or there is an error.
            return false;
        }
    }
?>