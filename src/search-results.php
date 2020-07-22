<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");
    session_start();

    if (isset($_SESSION['authuser'])) {
        $dbcon = new dbConnect();
        $dbcon->connectToDB();
        $userid = $_SESSION['userid'];

        $search = $_GET['search'];
        $results = $dbcon->getSearchResults($search);
    } else {
        header("Location: ./login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create-event.css">
    <link rel="stylesheet" href="my-events.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>My Events</title>
</head>
<body>
    <nav>
        <img src="../res/logo.png" alt="" class="logo">
        <ul>
            <li>
                <div><form action="searchevents.php" method="POST"><input class="form-control input-lg" style="border-radius: 5px;" type="text" id="search-input" placeholder="Search for an event here!"></form></div>
                <div class="search" id="search-icon">
                    <i class="fas fa-search"></i>
                    Search
                </div>
                <br>
                <div class="create-ev" id="create-icon">
                    <i class="fas fa-plus" id="plus"></i>
                    Create Event
                </div>
            </li>
        </ul>
        
    </nav>

    <div class="content">
        <div class="top-menu">
            <a class="navlink" href="index.html" id="home">Home</a>
            <a class="navlink" href="">About</a>
            <a class="navlink" href="">Safety</a>
            <a class="navlink" href="">My Events</a>
            <a class="navlink" href=""><span></span>Log Out</a>
        </div>

        <hr>

        <div class="event-wrapper">
            <h2><i class="fas fa-bookmark"></i> Search Results:</h2>
            <?php 
                if (count($results) > 0) {
                    echo "<div><ul>";
                    foreach ($results as $res) {
                        $start = explode(" ", $res['start']); $end = explode(" ", $res['end']);
                        echo "<li>Event Name: <a href='./event-overview.php?eventid=".$res['eventid']."'>".$res['name']."</a><br>";
                        echo "Organizer: ".$res['org'];
                        echo "Start Date: ".$start[0]." - ".$end[0];
                        echo "</li>";
                    }
                    echo "</ul></div>";
                } else {
                    echo "<div>No search results found. Try searching for something else!</div>";
                }
            ?>

        <!--<div class="event-info">
                <div>
                <i class="fas fa-exclamation-circle"></i>
                <div class="event-labels" id="name-info">Event Name: Sample test event</div>
                </div>
                

                <div>
                    <i class="far fa-calendar-alt"></i>
                    <div class="event-labels" id="date-info">Date: 2020-07-15 00:00:00 - 2020-07-24 00:00:00</div>
                </div>
                

                <div>
                    <i class="fas fa-user-alt"></i>
                    <div class="event-labels" id="organizer-info"></i>Event Organizer: Cindy</div>
                </div>

                <div>
                    <a href="" class="link"><i class="fas fa-edit"></i>Click to edit or see more</a>
                </div>
        </div>-->


           
            
        </div>

    </div>

    <script src="https://kit.fontawesome.com/2f39226221.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="create-event.js"></script>
    <!--<script src="event-overview.js"></script>-->
    <script>
        let searchinput = document.getElementById("search-input");
        searchinput.addEventListener("input", autoSearch);

        function autoSearch(ev) {
            let data = ev.target.value;
            console.log(data);
            fetch("searchevents.php", {
                method: "POST", 
                body: new URLSearchParams('name='+data)
            })
            .then(res => res.text())
            .then(res => console.log(res))
            .catch(error => console.log("Error: " + error));
        }
    </script>
</body>
</html>