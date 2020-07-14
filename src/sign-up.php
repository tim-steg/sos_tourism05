<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");
    session_start();

    $msg = "";

    if (isset($_SESSION['userauth'])) {
        // if user is logged in already, redirect them.
        header('Location: ./create-event.php');
    }

    if (isset($_POST['signup'])) {
        $dbcon = new dbConnect();
        $dbcon->connectToDB();

        if ($dbcon->accAlExists($_POST['email'], $_POST['username']) == true) {
            $msg = "Error: An account already exists with that email and/or username.";
        } else {
            $dbcon->createUser($_POST['email'], $_POST['username'], $_POST['password']);
            header("Location: ./create-events.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sign-up.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
   
    <title>Sign Up</title>
</head>
<body>
    <div class="left">
        <h1>Sign Up</h1>
        <p class="hint1">Enter your information below</p>
        <form action="">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <button type="submit" name="signup">Sign up</button>
            <p style="color: red; margin-top: 0px; font-style: italic;
                     margin-bottom: 10px; font-size: 22px; font-weight: 700;"><?php echo $msg; ?></p>
            <p class="hint2">Already have an account? <a href="log-in.html">Sign in</a></p>
          
        </form>
    </div>
    <div class="right">
        <img src="../res/logo.png" alt="" srcset="">
        <h1>Lorem ipsum dolor sit amet</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, minus animi aliquam voluptate aspernatur do</p>
    </div>
</body>
</html>