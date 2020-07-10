<?php
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);
    
    $conn = new mysqli($server, $username, $password, $db);

    if($conn->connect_error) {
        die("Connection failed.");
    }

    $search = $_GET['name'];

    $searchquery = "SELECT eventname FROM events WHERE eventname LIKE :search BY ASC";
    $stmt = $this->$conn->prepare($searchquery);
    $stmt->execute(["eventname" => "%" . $search . "%"]);
    $result = $stmt->get_result();
    
    $data = $resdata->fetch_all(MYSQLI_ASSOC);
    $array = array();
    if ($data) {
        foreach ($data as $eventname) {
            array_push($array, $eventname);
        }
    } else {
        array_push($array, "No results found.");
    }

    $conn->close();
    echo json_encode($array);
?>