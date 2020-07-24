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
        
        function insertReqs($eventid, $reqs, $attnd1, $attnd2) {
            // inserts the recommended precautions into its own table.
            $result = $this->conn->query("INSERT INTO `reqs` VALUES ('$eventid', '$reqs[0]', '$reqs[1]', '$reqs[2]', '$attnd1', '$reqs[3]', '$attnd2')");
            if ($result) {
                // return true on success.
                return true;
            } else {
                // return false on error.
                return false;
            }
        }

        // inserts all the various session data into a cross-reference table.
        function insertSessions($eventid, $sessions, $sessdesc) {
            try {
                $i = 0; 
                $sql = "";
                foreach ($sessions as $name) {
                    $desc = $sessdesc[$i];
                    $sql .= "INSERT INTO `sessions` VALUES ($eventid, $name, $desc);";
                    $i++;
                }
                $this->conn->query($sql);

            } catch (Exception $e) {
                die("Exception Error: ".$e->getMessage()."\n");
            }
        }

        // function to insert the core data for an event.
        function insertNewEvent($userid, $eventname, $organizer, $startdate, 
                                $enddate, $location, $descr, $timezone, $website, $tele, 
                                $email) {
            
            try {
                $stmt = $this->conn->prepare("INSERT INTO events (`userid`, `eventname`, `organizer`, `startdate`,
                `enddate`, `location`, `descr`, `timezone`, `website`, `telephone`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param("issssssssss", $userid, $eventname, $organizer, $startdate, 
                                                $enddate, $location, $descr, 
                                                $timezone, $website, $tele, $email);

                $stmt->execute();

                $eventid = $this->conn->insert_id;
                return $eventid;
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
                    $numrows = $stmt->num_rows;

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
            $dbusername = ""; $pwhash = "";

            $stmt = $this->conn->prepare("SELECT `password` FROM users WHERE username = ?");
            if ($stmt == true) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->bind_result($pwhash);
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

        // gets the userid based on the username parameter, returns -1 on error.
        function getUserID($username) {
            $userid = -1;
            $stmt = $this->conn->prepare("SELECT `id` FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($userid);
            $stmt->fetch();

            return $userid;
        }

        // gets an array of the user's events that they have created.
        function getUserEvents($userid) {
            $stmt = $this->conn->prepare("SELECT * FROM events WHERE userid=?");
            $stmt->bind_param("s", $userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l);
            $events = [];
            if ($stmt && ($stmt->num_rows >= 1)) {
                while ($stmt->fetch()) {
                    $events[] = ["id" => $a, "name" => $c, "org" => $d, "sdate" => $e, "edate" => $f];
                }
            }

            return $events;
        }

        // gets the appropriate search results from the events table, based on the parameter
        function getSearchResults($search) {
            $stmt = $this->conn->prepare("SELECT `eventid`, `eventname`, `organizer`, `startdate`, `enddate` FROM events WHERE `eventname` LIKE CONCAT('%',?,'%')");
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $name, $org, $start, $end);
            
            $results = [];
            if ($stmt && ($stmt->num_rows >= 1)) {
                while ($stmt->fetch()) {
                    $results[] = ["eventid" => $id, "name" => $name, "org" => $org, "start" => $start, "end" => $end];
                }
            }

            return $results;
        }

        function updateEvent($eventid, $name) {

        }

        // deletes the specified event from all event-related databases.
        function deleteEvent($id) {
            $stmt = $this->conn->prepare("DELETE FROM events WHERE eventid=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $this->conn->prepare("DELETE FROM reqs WHERE eventid=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $this->conn->prepare("DELETE FROM `sessions` WHERE eventid=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }
?>