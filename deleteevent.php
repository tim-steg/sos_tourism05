<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");
    session_start();

    if (isset($_SESSION['authuser'])) {
        if ($_GET['confirm'] == true) {
            $dbcon = new dbConnect();
            $dbcon->connectToDB();

            $dbcon->deleteEvent($_GET['id']);
            header("Location: ./my-events.php?id=".$_SESSION['userid']);
        }
    } else {
        header("Location: ./index.php");
    }
?>