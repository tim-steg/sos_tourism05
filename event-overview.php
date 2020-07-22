<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require("db.php");

    $db = new dbConnect();
    $db->connectToDB();

    $eventid = $_GET['eventid'];

    // Grabs the event info that pertains to the eventid in the url.
    $evdata = $db->grabEventData($eventid);
    if ($evdata == false) {
        die("404: Page Not Found.");
    }

    $event_reqs = "";

    $db->closeConn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create-event.css">
    <link rel="stylesheet" href="event-overview.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Event</title>
</head>
<body>
    <nav>
        <img src="./res/logo.png" alt="" class="logo">
        <ul>
            <li>
                <div><form action="searchevents.php" method="POST"><input class="form-control input-lg" style="border-radius: 5px;" type="text" id="search-input" placeholder="Search for an event here!"></form></div>
                <div class="create">
                    <p style="margin-bottom: 4px;"><img style="height: 10%; width: 10%; margin-right: 10px;" src="./res/searchicon.png">Search</p>
                </div>
            </li>
        </ul>
        
    </nav>

    <div class="mobile-toggle"><i class="fas fa-bars"></i></div>
    <div class="content">
        <div class="top-menu">
                <a class="navlink" href="index.php" id="home">Home</a>
                <a class="navlink" href="">About</a>
                <a class="navlink" href="">Safety</a>
                <a class="navlink" href="">My Events</a>
                <a class="navlink" href="./index.php"><span></span>Log Out</a>
        </div>

        <hr>

        <div class="event-wrapper">
            <div class="event-info">
                <div class="event-labels" id="name-info">Event Name: <?php echo $evdata['eventname']; ?></div>
                <div class="event-labels" id="date-info">
                    <div style="font-style: bolder;">Date: <div class="event-text"></div>
                    <?php 
                        $s = explode(" ",$evdata['startdate']); $e = explode(" ",$evdata['enddate']);
                        echo date("m-d-Y", strtotime($s[0]))." - ".date("m-d-Y", strtotime($e[0])); 
                    ?>
                    </div>
                </div>
                <div class="event-labels" id="organizer-info">Event Organizer: <div class="event-text"><?php echo $evdata['organizer']; ?></div></div>
                <div class="event-labels" id="location-info">Location: <div class="event-text"><?php echo $evdata['location']; ?></div></div>
                <div class="event-labels" id="contact-info">
                    Telephone: <div id="tel" style="display: inline;"><?php if ($evdata['telephone'] != "") { echo $evdata['telephone']; } else { echo "N/A"; } ?></div><br>
                    Email: <div id="email" style="display: inline;"><?php if ($evdata['email'] != "") { echo $evdata['email']; } else { echo "N/A"; } ?></div><br>
                    Website: <div id="web" style="display: inline;"><?php if ($evdata['website'] != "") { echo $evdata['website']; } else { echo "N/A"; } ?></div><br>
                </div>
                <div class="event-labels" id="safety-features">Recommended Safety Features:</div>
                <div class="event-labels" id="event-requirements">
                    <table class="requirement-table">
                        <?php echo $event_reqs; ?>
                    </table>
                </div>

                <div id="event-description-input">
                    <h1>Description:</h1>
                    <p id="event-description-text"><?php echo $evdata['descr']; ?></p>
                </div>
            </div>
            
        </div>

    </div>

    <script src="https://kit.fontawesome.com/2f39226221.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="create-event.js"></script>
    <script src="event-overview.js"></script>
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