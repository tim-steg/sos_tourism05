<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");

    if (isset($_POST['event_submission'])) {
        $dbcon = new dbConnect();
        $dbcon->connectToDB();

        echo '<script>'.print_r($_POST).'</script>';

        $dbcon->close();
    } else if (isset($_POST['delete_submission'])) {
        header("Location: ./index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="create-event.css">
    <title>Create A New Event</title>
</head>
<body>
    <form action="create-event.php" method="POST" name="event_submission">
        <nav>
            
            <img src="../res/logo.png" alt="" class="logo">
        
            <ul>
                <li>
                    <div class="create">
                        <p>Create</p>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                </li>
                <li>
                    <div type="button" onclick="deleteEvent();" class="delete">
                        <p>Delete</p>
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </div>
                </li>
            </ul>
            
        </nav>

        <div class="mobile-toggle"><i class="fas fa-bars"></i></div>
        <div class="content">
        <div class="top-menu">
                <a href="index.html" id="home">Home</a>
                <a href="">About</a>
                <a href="">Safety</a>
                <a href="">My Events</a>
                <a href=""><span></span>Log Out</a>
        </div>

        <hr>

        <div class="event-wrapper">
            <div class="event-info">
                    <div id="event-name-input">Event Name: <input type="text" placeholder="Add event name here" required></div>
                    <div id="event-date-input" class="col-xs-2">Date: <input type="date" class="date-input" name="" id="date1" placeholder="mm-dd-yyyy" required> - <input type="date" class="date-input" name="" id="date2" placeholder="mm-dd-yyyy" required></div>
                    <div id="event-date-input"></div>
                    <div id="event-organizer-input">Event Organizer: <input type="text" placeholder="Add organizer name here" required></div>
                    <div id="event-location-input">Location: <input type="text" placeholder="Add location here" required></div>
                    <div id="event-contact-input">
                        Tel: <input type="text" placeholder="Add telephone #"> 
                        Email: <input type="text" placeholder="Add email here">
                        Website: <input type="text" placeholder="Add your website">
                    </div>
                    <p id="safety">Safety Features:</p>
                    <div id="event-requirements">
                        <div id="face-mask">
                            <input type="checkbox" id="mask">
                            <label for="mask">Require Face Masks On</label>
                        </div>
                        
                        <div>
                            <input type="checkbox" id="sanitizer">
                            <label for="sanitizer">Hand Sanitizer Stations</label>
                        </div>

                        <div>
                            <input type="checkbox" id="temp">
                            <label for="temp">Body Temperature Check</label>
                        </div>


                        <div>
                            <label for="door">Indoor/Outdoor:</label>
                            <select id="door">
                                <option value="indoor">Indoor</option>
                                <option value="outdoor">Outdoor</option>
                            </select>
                        </div>

                        <div>
                            <input type="checkbox" id="age">
                            <label for="age">Not Recommended For Age &gt 65</label>
                        </div>

                        <div>
                            <label for="capacity">Capacity Limit:</label>
                            <select id="capacity" required>
                                <option value="small">&lt50</option>
                                <option value="mediem">50-100</option>
                                <option value="large">&gt100</option>
                            </select>
                        </div>

                        
                    </div>

                    <div id="event-description-input">
                        <h1>Description: </h1>
                        <textarea type="text" placeholder="Add description here" required></textarea>
                    </div>
            </div>

            <div class="event-session" id="session1">
                    <div type="button" class="collapsible">
                        <div class="editable" contenteditable data-placeholder="Add Session Name"></div>
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                        <i class="far fa-trash-alt"></i>
                    </div>
                    <div class="session-content">
                        <textarea type="text" placeholder="enter session info" class="session-info" required></textarea>
                    </div>
            </div>
            
            <button type="button" class="add-session">Add Session</button>
        </div>
    </form>
    <script src="https://kit.fontawesome.com/2f39226221.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>  
    <script src="create-event.js"></script>
    <script>
        function deleteEvent() {
            console.log("delete button clicked.");
        }
    </script>
</body>
</html>