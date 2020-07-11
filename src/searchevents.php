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

    $search = $_POST['name'];
    $res = $conn->query("SELECT `eventname` FROM events WHERE `eventname` LIKE '%{$search}%'");
    $data = array();
    echo $search;
    if ($res->num_rows > 0) {
        while($row = $res->fetch_assoc()) {
            foreach ($row as $key => $name) {
                array_push($data, $name);
            }
        }
    } else {
        array_push($data, "No results found.");
    }

    //echo json_encode($data);
?>