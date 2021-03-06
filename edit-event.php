<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");
    session_start();

    $dbcon = new dbConnect();
    $dbcon->connectToDB();
    $eventid = $_GET['eventid'];
    $eventdata = $dbcon->grabEventData($eventid);
    $sessdata = $dbcon->grabSessData($eventid);
    $reqdata = $dbcon->grabReqData($eventid);

    if (isset($_SESSION['authuser'])) {
        if (isset($_POST['event_submission'])) {
            $sess = $_POST['sessions'];
            $sdesc = $_POST['sessdesc'];

            //$dbcon->deleteEvent($eventid);
            $result = $dbcon->updateEvent($_SESSION['userid'], $eventid, $_POST['eventname'], $_POST['organizer'], 
                                        $_POST['startdate'], $_POST['enddate'], $_POST['location'], 
                                        $_POST['descr'], $_POST['timezone'], $_POST['site'], 
                                        $_POST['tele'], $_POST['email']);
            
            if (isset($_POST['reqs'])) {
                $reqs = $_POST['reqs'];

                for ($i = 0; $i < count($reqs); $i++) {
                    if (array_key_exists($i, $reqs) == false) {
                        $reqs[$i] = "false";
                    }
                }

                $dbcon->insertReqs($eventid, $reqs, $_POST['attend1'], $_POST['attend2']);
            } else {
                $reqs = ["false","false","false","false"];
                $dbcon->insertReqs($eventid, $reqs, $_POST['attend1'], $_POST['attend2']);
            }
            
            $dbcon->insertSessions($eventid, $sess, $sdesc);
            $dbcon->closeConn();

            header("Location: ./my-events.php?id=".$userid);
        } else if (isset($_POST['delete_submission'])) {
            header("Location: ./index.php");
        }
    } else {
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
    <link rel="stylesheet" href="./css/create-event.css">
    <title>Create A New Event</title>
</head>
<body>
    <form enctype="multipart/form-data" action="./edit-event.php" method="POST">
        <nav>
            
            <img src="./res/Logo.png" alt="" class="logo">
        
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
                    <?php echo "<a href='./my-events.php?id=".$_SESSION["userid"]."' style='text-decoration: none;'>"; ?><div type="button" class="delete">
                        <p>Delete</p>
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </div></a>
                </li>
            </ul>
            
        </nav>

        <div class="mobile-toggle"><i class="fas fa-bars"></i></div>
        <div class="content">
        <div class="top-menu">
                <a href="./index.php" id="home">Home</a>
                <a href="./about.php">About</a>
                <a href="./my-events.php">My Events</a>
                <a href="./logout.php"><span></span>Log Out</a>
        </div>

        <hr>

        <div class="event-wrapper">
            <div class="event-info">
                    <div id="event-name-input">Event Name: <input type="text" name="eventname" placeholder="Add event name here" <?php echo "value='".$eventdata['eventname']."'"; ?> required></div>
                    <div id="event-date-input" class="col-xs-2">Date: <input type="date" class="date-input" name="startdate" id="date1" placeholder="mm-dd-yyyy" <?php echo "value='".date('Y-m-d',strtotime($eventdata['startdate']))."'"; ?> required> - <input type="date" class="date-input" name="enddate" id="date2" placeholder="mm-dd-yyyy" <?php echo "value='".date('Y-m-d',strtotime($eventdata['enddate']))."'"; ?> required></div>
                    <div id="event-date-input" class="col-xs-2">Timezone: 
                    <select class="form-control" style="width: auto; display: inline-block;" name="timezone" id="">
                        <option value="AST" <?php if ($eventdata['timezone'] == "AST") { echo "selected"; } ?> >AST (Atlantic Standard Time)</option>
                        <option value="EST" <?php if ($eventdata['timezone'] == "EST") { echo "selected"; } ?> >EST (Eastern Standard Time)</option>
                        <option value="CST" <?php if ($eventdata['timezone'] == "CST") { echo "selected"; } ?> >CST (Central Standard Time)</option>
                        <option value="MST" <?php if ($eventdata['timezone'] == "MST") { echo "selected"; } ?> >MST (Mountain Standard Time)</option>
                        <option value="PST" <?php if ($eventdata['timezone'] == "PST") { echo "selected"; } ?> >PST (Pacific Standard Time)</option>
                        <option value="AKST" <?php if ($eventdata['timezone'] == "AKST") { echo "selected"; } ?> >AKST (Alaska Time)</option>
                    </select></div>
                    <div id="event-organizer-input">Event Organizer: <input type="text" name="organizer" placeholder="Add organizer name here" <?php echo "value='".$eventdata['organizer']."'"; ?> required></div>
                    <div id="event-location-input">Location: <input type="text" name="location" placeholder="Add location here" <?php echo "value='".$eventdata['location']."'"; ?> required></div>
                    <div id="event-contact-input">
                        Tel: <input type="text" name="tele" <?php echo "value='".$eventdata['telephone']."'"; ?> placeholder="Add telephone #"> 
                        Email: <input type="text" name="email" <?php echo "value='".$eventdata['email']."'"; ?> placeholder="Add email here">
                        Website: <input type="text" name="site" <?php echo "value='".$eventdata['website']."'"; ?> placeholder="Add your website">
                    </div>
                    <p id="safety" style="font-size: 24px; font-weight: bold;">Safety Features:</p>
                    <p class="reqdisc" style="font-size: 16px;">Please remember to additionally consult with your local health authorities, if needed.</p>
                    <div id="event-requirements">
                        <div id="face-mask">
                            <?php
                            if ($reqdata['facemasks'] != null) { echo '<input type="checkbox" class="reqcheck" name="reqs[0]" id="mask" checked>'; } else {
                                echo '<input type="checkbox" class="reqcheck" name="reqs[0]" id="mask">';
                            } 
                            ?>
                            <label class="reqlabel" for="mask">Require Face Masks On</label>
                        </div>
                        
                        <div>
                            <?php
                            if ($reqdata['sanitizer'] != "false") { echo '<input type="checkbox" class="reqcheck" name="reqs[1]" id="sanitizer" checked>'; } else {
                                echo '<input type="checkbox" class="reqcheck" name="reqs[1]" id="sanitizer">';
                            } 
                            ?>
                            <label for="sanitizer" class="reqlabel">Hand Sanitizer Stations</label>
                        </div>

                        <div>
                            <?php
                            if ($reqdata['tempcheck'] != "false") { echo '<input type="checkbox" class="reqcheck" name="reqs[2]" id="temp" checked>'; } else {
                                echo '<input type="checkbox" class="reqcheck"name="reqs[2]" id="temp">';
                            } 
                            ?>
                            <label for="temp" class="reqlabel">Body Temperature Check</label>
                        </div>


                        <div>
                            <label for="door">Indoor/Outdoor:</label>
                            <select class="form-control" name="attend1" style="width: auto; display: inline-block;" id="door">
                            <?php 
                                if ($reqdata["inoroutdoor"] == "ind") {
                                    echo '<option value="ind" selected>Indoor</option>
                                        <option value="out">Outdoor</option>
                                        <option value="mix">Mixed</option>';
                                } else if ($reqdata['inoroutdoor'] == "out") {
                                    echo '<option value="ind">Indoor</option>
                                        <option value="out" selected>Outdoor</option>
                                        <option value="mix">Mixed</option>';
                                } else if ($reqdata['inoroutdoor'] == "mix") {
                                    echo '<option value="ind">Indoor</option>
                                        <option value="out">Outdoor</option>
                                        <option value="mix" selected>Mixed</option>';
                                }
                            ?>
                            </select>
                        </div>

                        <div>
                            <?php 
                            if ($reqdata['notrecage'] != "false") { echo '<input type="checkbox" class="reqcheck" name="reqs[3]" id="age" checked>'; } else {
                                echo '<input type="checkbox" class="reqcheck" name="reqs[3]" id="age">';
                            } 
                            ?>
                            <label for="age" class="reqlabel">Not Recommended For Age &gt 65</label>
                        </div>

                        <div>
                            <?php 
                                echo '<label for="capacity">Capacity Limit:</label>';
                                if ($reqdata['caplimit'] == "lrg") {
                                    echo '<select class="form-control"name="attend2" style="width: auto; display: inline-block;" id="capacity" required>
                                        <option value="sml">&lt50</option>
                                        <option value="med">50-100</option>
                                        <option value="lrg" selected>&gt100</option>
                                    </select>';
                                } else if ($reqdata['caplimit'] == "med") {
                                    echo '<select class="form-control"name="attend2" style="width: auto; display: inline-block;" id="capacity" required>
                                        <option value="sml">&lt50</option>
                                        <option value="med" selected>50-100</option>
                                        <option value="lrg">&gt100</option>
                                    </select>';
                                } else if ($reqdata['caplimit'] == "sml") {
                                    echo '<select class="form-control"name="attend2" style="width: auto; display: inline-block;" id="capacity" required>
                                        <option value="sml" selected>&lt50</option>
                                        <option value="med">50-100</option>
                                        <option value="lrg">&gt100</option>
                                    </select>';
                                }
                            ?>
                        </div>

                        
                    </div>

                    <div id="event-description-input">
                        <h1>Description: </h1>
                        <textarea type="text" name="descr" placeholder="Add description here" required><?php echo $eventdata['descr']; ?></textarea>
                    </div>
            </div>

            <?php 
                if (count($sessdata) >= 1) {
                    $i = 1; $j = 0;
                    foreach ($sessdata as $s) {
                        echo `<div class="event-session" id="session`.$i.`">
                        <div class="collapsible">
                            <input type="text" class="editable" name="sessions[]" value='`.$s[$j]['sessname'].`' contenteditable placeholder="Add Session Name" required>
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                            <i class="fa fa-caret-up" aria-hidden="true"></i>
                            <i class="far fa-trash-alt"></i>
                        </div>
                        <div class="session-content">
                            <textarea type="text" name="sessdesc[]" placeholder="Enter session info" class="session-info" required>`.$s[$j]['sessdesc'].`</textarea>
                        </div></div>`;
                        $i++; $j++;
                    }
                } else {
                    echo `<div class="event-session" id="session1">
                            <div class="collapsible">
                                <input type="text" class="editable" name="sessions[]" contenteditable placeholder="Add Session Name" required>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                <i class="fa fa-caret-up" aria-hidden="true"></i>
                                <i class="far fa-trash-alt"></i>
                            </div>
                            <div class="session-content">
                                <textarea type="text" name="sessdesc[]" placeholder="Enter session info" class="session-info" required></textarea>
                            </div>
                            </div>`;
                }
            ?>
            
            <input type="button" class="add-session" style="margin-bottom: 40px;" value="Add Session">

        </div>
    </form>
    <script src="https://kit.fontawesome.com/2f39226221.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>  
    <script src="./js/create-event.js"></script>
</body>
</html>