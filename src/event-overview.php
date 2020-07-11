<?php 
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);
    
    $conn = new mysqli($server, $username, $password, $db);

    //$conn->query("SELECT * FROM events WHERE eventid == 1");
    $conn->close();
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
        <img src="../res/logo.png" alt="" class="logo">
        <ul>
            <li>
                <div><form action="searchevents.php" method="POST"><input class="form-control input-lg" style="border-radius: 5px;" type="text" id="search-input" placeholder="Search for an event here!"></form></div>
                <div class="create">
                    <p style="margin-bottom: 4px;"><img style="height: 10%; width: 10%; margin-right: 10px;" src="../res/searchicon.png">Search</p>
                </div>
            </li>
        </ul>
        
    </nav>

    <div class="mobile-toggle"><i class="fas fa-bars"></i></div>
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
           <div class="event-info">
                <div class="event-labels" id="name-info">Event Name: </div>
                <div class="event-labels" id="date-info">Date: </div>
                <div class="event-labels" id="organizer-info">Event Organizer: </div>
                <div class="event-labels" id="location-info">Location: </div>
                <div class="event-labels" id="contact-info">
                    Telephone: <div id="tel"></div>
                    Email: <div id="email"></div>
                    Website: <div id="web"></div>
                </div>
                <div class="event-labels" id="safety-features">Recommended Safety Features:</div>
                <div class="event-labels" id="event-requirements">
                    <table class="requirement-table">
                        <?php echo $event_reqs; ?>
                    </table>
                </div>

                <div id="event-description-input">
                    <h1>Description: </h1>
                    <p id="event-description-text"></p>
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
    <!--<script src="event-overview.js"></script>-->
    <script>
        let searchinput = document.getElementById("search-input");
        searchinput.addEventListener("input", autocomplete);

        function autocomplete(ev) {
            let data = ev.target.value;
            console.log(data);
            fetch("searchevents.php", {
                method: "POST", 
                body: new URLSearchParams('name=' + data)
            })
            .then(res => res.text())
            .then(res => console.log(res))
            .catch(error => console.log("Error: " + error));
        }
    </script>
</body>
</html>