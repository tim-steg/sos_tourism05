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

    //$queryresult = $conn->query("SELECT eventname FROM events WHERE eventname LIKE %".$search."% BY ASC");
    
    //$data = array();
    //while ($name = mysql_fetch_array($queryresult)) {
    //    array_push($data, $name);
    //}

    //echo json_encode($data);
    echo "Test";
?>