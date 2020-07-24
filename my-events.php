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
        $events = $dbcon->getUserEvents($userid);
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
        <img src="./res/logo.png" alt="" class="logo">
        <ul>
            <li>
                <div><form action="search-results.php" id="searchform" method="GET"><input class="form-control input-lg" style="border-radius: 5px;" name="search" type="text" id="search-input" placeholder="Search for an event here!"></form></div>
                <a href="javascript:void()" style="text-decoration: none;" onclick="document.getElementById('searchform').submit();"><div class="search">
                    <i class="fas fa-search"></i>
                    Search
                </div></a>
                <br>
                <a href="./create-event.php" style="text-decoration: none;"><div class="create-ev" id="create-icon">
                    <i class="fas fa-plus" id="plus"></i>
                    Create Event
                </div></a>
            </li>
        </ul>
        
    </nav>

    <div class="content">
        <div class="top-menu">
            <a class="navlink" href="index.php" id="home">Home</a>
            <a class="navlink" href="about.php">About</a>
            <?php echo "<a class='navlink' href='./my-events.php?id=".$_SESSION['userid']."'>My Events</a>"; ?>
            <a class="navlink" href="./logout.php"><span></span>Log Out</a>
        </div>

        <hr>

        <!-- drop down notification -->
        <div class="drop">
            <button class="mainmenubtn"><i class="fas fa-bell"></i>Notifications</button>
            <div class="drop-child">
                <?php 
                    $notif = $dbcon->checkNotifications($_SESSION['userid']);
                    if (count($notif) >= 1) {
                        $i = 0;
                        echo "<ul>";
                        foreach ($notif as $n) {
                            echo "<li>".$n[$i]."<li>";
                            $i++;
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No notification right now.</p>";
                    }
                ?>
            </div>
        </div>

        <div class="event-wrapper">
            <h2><i class="fas fa-bookmark"></i> My Events:</h2>
            <?php 
                if (count($events) > 0) {
                    foreach ($events as $ev) {
                        $start = explode(" ", $ev['sdate']); $end = explode(" ", $ev['edate']);
                        echo "<div class='event-info'>
                                <div>
                                    <i class='fas fa-exclamation-circle'></i>
                                    <div class='event-labels' id='name-info'>Event Name: <a href='./event-overview.php?eventid=".$ev['id']."'>".$ev['name']."</a></div>
                                </div>
                                <div>
                                    <i class='far fa-calendar-alt'></i>
                                    <div class='event-labels' id='date-info'>Date: ".date("m-d-Y", strtotime($start[0]))." - ".date("m-d-Y", strtotime($end[0]))."</div>
                                </div>
                                <div>
                                    <i class='fas fa-user-alt'></i>
                                    <div class='event-labels' id='organizer-info'>Organizer: ".$ev['org']."</div>
                                </div>
                                <div>
                                    <a href='edit-event.php?eventid=".$ev['id']."' class='link'><i class='fas fa-edit'></i>Click to edit this event</a>
                                    <a style='margin-left: 20px;' href='javascript:void()' class='link' onclick='deleteEvent(".$ev['id'].")'><i class='fa fa-trash'></i>Delete Event</a>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<div><a href='create-event.php?userid=".$_SESSION['userid']."'>Click here to create an event.</a></div>";
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

        function deleteEvent(id) {
            let answer = confirm("Are you sure you want to delete this event? This cannot be undone.");
            if (answer == true) {
                window.location.href = "https://sostourism05.herokuapp.com/deleteevent.php?id="+id+"&confirm="+answer;
            }
        }
    </script>
</body>
</html>