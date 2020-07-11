<?php 
    require_once("db.php");

    if (isset($_POST['event_submission'])) {
        $dbcon = new dbConnect();
        $dbcon->connectToDB();

        $dbcon->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create-event.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
   
    <title>Event</title>
</head>
<body>
    <form action="create-event.php" method="POST" name="event-submission">
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
                    <div class="delete">
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
                    <div id="event-name-input">Event Name: <input type="text" placeholder="Add event name here"></div>
                    <div id="event-date-input">Date: <input type="date" name="" id="date1"> - <input type="date" name="" id="date2"></div>
                    <div id="event-organizer-input">Event Organizer: <input type="text" placeholder="Add organizer name here"></div>
                    <div id="event-location-input">Location: <input type="text" placeholder="Add location here"></div>
                    <div id="event-contact-input">
                        Tel: <input type="text" placeholder="Add telephone number here"> 
                        Email: <input type="text" placeholder="Add email address here">
                        Website: <input type="text" placeholder="Add link here">
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
                            <select id="capacity">
                                <option value="small">&lt50</option>
                                <option value="mediem">50-100</option>
                                <option value="large">&gt100</option>
                            </select>
                        </div>

                        
                    </div>

                    <div id="event-description-input">
                        <h1>Description: </h1>
                        <textarea type="text" placeholder="Add description here"></textarea>
                    </div>
            </div>

            <div class="event-session" id="session1">
                    <button class="collapsible">
                        <div class="editable" contenteditable data-placeholder="Add Session Name"></div>
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <div class="session-content">
                        <textarea type="text" placeholder="enter session info" class="session-info"></textarea>
                    </div>
            </div>


            <div class="event-session" id="session2">
                    <button class="collapsible">
                        <div class="editable" contenteditable data-placeholder="Add Session Name"></div>
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <div class="session-content">
                        <textarea type="text" placeholder="enter session info" class="session-info"></textarea>
                    </div>
                </div>

                <button class="add-session">Add Session</button>
                
            </div>

        </div>
    </form>
    <script src="https://kit.fontawesome.com/2f39226221.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="create-event.js"></script>
</body>
</html>