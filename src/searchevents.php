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
    echo $search;
    $stmt = $conn->prepare("SELECT `eventname` FROM events WHERE `eventname` LIKE '%?%'");
    $stmt->bind_param("s", $search);
    
    $data = array();
    if ($stmt->execute()) {
        $stmt->bind_result($name);
        while($stmt->fetch()) {
            array_push($data, $name);
        }
    } else {
        array_push($data, "Results not found.");
    }

    echo json_encode($data);
?>