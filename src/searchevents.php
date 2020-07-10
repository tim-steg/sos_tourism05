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

    $search = $_POST['search'];

    $searchquery = $conn->query("SELECT * FROM events WHERE eventname LIKE %".$search."% BY ASC");

    $result = array();

    if ($searchquery->num_rows > 0) {
        while($row = $searchquery->fetch_assoc()) {
            array_push($result, $row['eventname']);
        }
    } else if ($searchquery->num_rows <= 0) {
        array_push($result, "No results found.");
    }

    $conn->close();
    echo json_encode($result);
?>