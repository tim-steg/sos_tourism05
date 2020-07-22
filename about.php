<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="events, finding events, covid-19, safety, plan an event">

    <link rel="icon" href="./res/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <title>Logo Name Company</title>
    <link rel="stylesheet" href="about.css">
</head>

<body>
    <section class="about-bg">
        <header>
            <a href="index.php"><img src="./res/pink logo.png" alt="Logo of Logo Name Company."></a>

            <nav>
                <input type="checkbox" id="check">
                <label for="check" class="checkbtn">
                    <i class="fas fa-bars"></i>
                </label>
                
                <ul>
                    <?php 
                        if (isset($_SESSION['authuser'])) {
                            echo "<li id='login'><a class='navlink' href='./my-events.php?id=".$_SESSION['userid']."'>My Events</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |";
                            echo "<li><a href='about.php'>About</a></li>";
                            echo "<li id='login'><a class='navlink' href='./logout.php'><span></span>Log Out</a></li>";
                        } else {
                            echo "<li><a href='./search-results.php'>Events</a></li>";
                            echo "<li><a href='about.php'>About</a></li>";
                            echo "<li id='login' class='aba'><a href='./sign-up.php'>Sign Up</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |";
                            echo "<li id='login' class='bab'><a href='./login.php'>Login</a></li>";
                        }
                    ?>
                    <!--<li><a href="#">Events</a></li>
                    <li><a href="about.html">About</a></li>
                    <li id="login" class="aba"><a href="#">Sign up</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |
                    <li id="login" class="bab"><a href="login.html">Log in</a></li>-->
                </ul>
            </nav>
        </header>

        <div class="about-us">
            <div class="big-about">
                <h1>About Us</h1>
            </div>

              
            <div class="about-text1">
                <div class="text1">
                    <h2>Our Goal</h2>
                    <p>is to provide a service that allows participants to still create events, while also keeping watch over their health. We use interactive features that remind participants to keep in mind the health guidelines that everyone must follow.</p>
                </div>

                <img class="img-bb" src="./res/pen.jpg" alt="Image of a man writing in a planner.">
            </div>
            

            <div class="about-text2">
                <div class="text2">
                    <h2>Our Mission</h2>
                    <p>is to keep our customers safe during these difficult times by prioritizing their health and safety above all and reminding our customers to remember the rules and guidelines, so that everyone can have a good time.</p>
                </div>

                <img class="img-bb" src="./res/board.jpg" alt="Image of people talking around a table.">
            </div>

            <div class="meet-team">
                <h2>Meet the Team</h2>

                <img src="./res/tim.jpg" alt="Profile of team member.">

                <img src="./res/chidi.jpg" alt="Profile of team member.">

                <img  src="./res/cindy.jpg" alt="Profile of team member.">

                <img src="./res/christian.jpg" alt="Profile of team member.">

                <img src="./res/roopali.jpg" alt="Profile of team member.">
            </div>
        </div>
    </section>

    <section class="contact">
        <div class="form-bg">
            <form action="">
                <label id="label-to" for="contact form">Contact Us</label>

                <label for="full name"></label>
                <input type="text" name="full name" id="full name" value="Full Name"
                onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
            
                <label for="email"></label>
                <input type="email" name="email" id="email" value="Email"
                onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">

                <label for="feedback"></label>
                <input type="text" name="feedback" id="feedback" value="What can we do better?"
                onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">

                <input type="button" value="Submit" id="send-button">
            </form>
        </div>
    </section>

    <footer>
        <ul>
            <li><a href="search-results.php?search=">Events</a></li>
            <li><a href="#">Terms</a></li>
            <li id="login"><a href="sign-up.php">Sign up</a></li>&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp
            <li id="login" class="ada"><a href="login.php">Log in</a></li>
        </ul>
        <!--(&nbsp;&nbsp;) adds a space between words.-->
        <a href="index.php"><img src="./res/logo.png" alt="Logo of Logo Name Company."></a>
    </footer>
</body>
</html>