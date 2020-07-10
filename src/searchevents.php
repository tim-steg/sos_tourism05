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

    $queryresult = $conn->query("SELECT * FROM events WHERE eventname LIKE %".$search."% BY ASC");
    
    $data = array();
    if ($queryresult->num_rows > 0) {
        while($name = $queryresult->fetch_assoc()) {
            $data[] = $name['eventname'];
        }
    } else if ($queryresult->num_rows <= 0) {
        $data[] = "No results found.";
    }

    echo json_encode($data);
?>