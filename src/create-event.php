<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");

    if (isset($_POST['event_submission'])) {
        $dbcon = new dbConnect();
        $dbcon->connectToDB();

        $reqs = $_REQUEST['reqs'];
        $sName = $_REQUEST['sessname'];
        $sDesc = $_REQUEST['sessdesc'];

        $eventid = $dbcon->insertNewEvent(100, $_POST['eventname'], $_POST['organizer'], $_POST['startdate'], $_POST['enddate'], $_POST['location'], 
                                        $_POST['descr'], $_POST['timezone'], $_POST['site'], $_POST['tele'], $_POST['email'], $reqs, $sName, $sDesc);

        $dbcon->closeConn();
        header("Location: ./index.html");
    } else if (isset($_POST['delete_submission'])) {
        header("Location: ./index.html");
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
    <form method="POST">
        <nav>
            
            <img src="../res/logo.png" alt="" class="logo">
        
            <ul>
                <li>
                    <button type="submit" name="event_submission" id="submitbutton">
                        <div class="create">
                            <p>Create</p>
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                    </button>
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
                    <div id="event-name-input">Event Name: <input type="text" name="eventname" placeholder="Add event name here" required></div>
                    <div id="event-date-input" class="col-xs-2">Date: <input type="date" class="date-input" name="startdate" id="date1" placeholder="mm-dd-yyyy" required> - <input type="date" class="date-input" name="enddate" id="date2" placeholder="mm-dd-yyyy" required></div>
                    <div id="event-date-input" class="col-xs-2">Timezone: 
                    <select class="form-control" style="width: auto; display: inline-block;" name="timezone" id="">
                        <option value="AST">AST (Atlantic Standard Time)</option>
                        <option value="EST">EST (Eastern Standard Time)</option>
                        <option value="CST">CST (Central Standard Time)</option>
                        <option value="MST">MST (Mountain Standard Time)</option>
                        <option value="PST">PST (Pacific Standard Time)</option>
                        <option value="AKST">AKST (Alaska Time)</option>
                    </select></div>
                    <div id="event-organizer-input">Event Organizer: <input type="text" name="organizer" placeholder="Add organizer name here" required></div>
                    <div id="event-location-input">Location: <input type="text" name="location" placeholder="Add location here" required></div>
                    <div id="event-contact-input">
                        Tel: <input type="text" name="tele" placeholder="Add telephone #"> 
                        Email: <input type="text" name="email" placeholder="Add email here">
                        Website: <input type="text" name="site" placeholder="Add your website">
                    </div>
                    <p id="safety">Safety Features:</p>
                    <div id="event-requirements">
                        <div id="face-mask">
                            <input type="checkbox" value="1" name="reqs[]" id="mask">
                            <label for="mask">Require Face Masks On</label>
                        </div>
                        
                        <div>
                            <input type="checkbox" value="1" name="reqs[]" id="sanitizer">
                            <label for="sanitizer">Hand Sanitizer Stations</label>
                        </div>

                        <div>
                            <input type="checkbox" value="1" name="reqs[]" id="temp">
                            <label for="temp">Body Temperature Check</label>
                        </div>


                        <div>
                            <label for="door">Indoor/Outdoor:</label>
                            <select class="form-control" name="reqs[]" style="width: auto; display: inline-block;" id="door">
                                <option value="indoor" value="1">Indoor</option>
                                <option value="outdoor" value="2">Outdoor</option>
                                <option value="mixed" value="3">Mixed</option>
                            </select>
                        </div>

                        <div>
                            <input type="checkbox" name="reqs[]" id="age">
                            <label for="age" value="1">Not Recommended For Age &gt 65</label>
                        </div>

                        <div>
                            <label for="capacity">Capacity Limit:</label>
                            <select class="form-control"name="reqs[]" style="width: auto; display: inline-block;" id="capacity" required>
                                <option value="small" value="1">&lt50</option>
                                <option value="mediem" value="2">50-100</option>
                                <option value="large" value="3">&gt100</option>
                            </select>
                        </div>

                        
                    </div>

                    <div id="event-description-input">
                        <h1>Description: </h1>
                        <textarea type="text" name="descr" placeholder="Add description here" required></textarea>
                    </div>
            </div>

            <div class="event-session" id="session1">
                    <div class="collapsible">
                        <input type="text" class="editable" name="sessname[]" contenteditable data-placeholder="Add Session Name">
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                        <i class="far fa-trash-alt"></i>
                    </div>
                    <div class="session-content">
                        <textarea type="text" name="sessdesc[]" placeholder="enter session info" class="session-info"></textarea>
                    </div>
            </div>
            
            <input type="button" class="add-session" style="margin-bottom: 40px;" value="Add Session">

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