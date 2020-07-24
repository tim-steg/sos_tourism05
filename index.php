<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Insert info about the company.">

    <meta name="keywords" content="events, finding events, covid-19, safety, plan an event">

    <link rel="icon" href="./res/favicon.ico" type="image/x-icon">

    <title>Safebook</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <section class="home-bg">
        <header>
            <a href="index.php"><img src="./res/logo.png" alt="Logo of Logo Name Company."></a>

            <nav>
                <input type="checkbox" id="check">
                <label for="check" class="checkbtn">
                    <i class="fas fa-bars"></i>
                </label>
                
                <ul>
                    <li><a href="./about.php">About</a></li>
                    <?php 
                        if (isset($_SESSION['authuser'])) {
                            echo "<li id='login'><a class='navlink' href='./my-events.php?id=".$_SESSION['userid']."'>My Events</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |";
                            echo "<li id='login'><a class='navlink' href='./logout.php'><span></span>Log Out</a></li>";
                        } else {
                            echo "<li><a href='./search-results.php'>Events</a></li>";
                            echo "<li id='login' class='aba'><a href='./sign-up.php'>Sign Up</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |";
                            echo "<li id='login' class='bab'><a href='./login.php'>Login</a></li>";
                        }
                    ?>
                </ul>
            </nav>

        </header>

        <div class="event-bg">
            <h1>Find your next event, even in a pandemic. </h1>

            <p>Even during a pandemic we know you have places to be. But its hard keeping track of every new update that comes in. That's why we provide events catered to your needs. Find events that meet the health guidelines while priortizing your safety.</p>

            <div class="search-box">
                <form action="./search-results.php" id="searchform" method="GET">
                <label for="search"></label>
                <input type="text" name="search" id="search events" placeholder="What event are you looking for? Search for it here!" style="font-size: 20px;" size="20"
                onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">

                <input type="button" onclick="document.getElementById('searchform').submit();" value="Search" id="find-button">
                </form>
            </div>
        </div>
    </section>

    <section class="circle-box">
        <div class="circle-1"> 
            <div class="circle-text1">
            <h2>Plan your event.</h2>
            <p>Organize your event, and let your attendees know what health guidelines you're adhering to.</p>
            </div>

            <div><img src="./res/laptop.png" alt="Image of a laptop"></div>

           <div><a href="./sign-up.php" style='text-decoration: none;'><input type="button" value="Get Started" id="get-button"></a></div>
        </div>

        <div class="circle-2"> 
            <div class="circle-text2">
            <h2>Stay safe at a distance.</h2>
            <p>We provide simple and helpful ways to at a glance know what type of COVID-19 restrictions an event has in place. </p>
            </div>

            <div><img src="./res/talk.png" alt="Image of a person and a speech bubble."></div>
        </div>

        <div class="circle-3"> 
            <div class="circle-text3"> 
            <h2>Have a good time.</h2>
            <p>Don't worry about how to stay safe at your event, we have the tools to let you know!</p>
            </div>

            <div><img src="./res/headphones.png" alt="Image of a pair of headphones."></div>
        </div>
    </section>

    <div class="start-bg">
        <h1>Start planning now.</h1>
        <p>Sign up for an account today! Totally free!</p>

        <a href="./sign-up.php" style='text-decoration: none;'><input type="button" value="Get Started" id="start-button"></a>
    </div>

    <footer>
        <ul>
            <li><a href="#">Events</a></li>
            <li><a href="#">Safety</a></li>
            <li><a href="#">Terms</a></li>
            <li id="login"><a href="#">Sign up</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp
            <li id="login" class="ada"><a href="#">Log in</a></li>
        </ul>
        <!--(&nbsp;&nbsp;) adds a space between words.-->
        <a href="index.php"><img src="./res/logo.png" alt="Logo of Logo Name Company."></a>
    </footer>
</body>
</html>