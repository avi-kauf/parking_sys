<html>
    <!-- written by Avraham Kauffmann-->
    <head>
        <link rel="icon" href="media/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <title>About Us</title>
    </head>
    <body>

<?php include 'header.php'; ?>
    
        <div class="content" style="text-align: left;">

        <h1>Our <i>PHP</i> Project </h1>
        <h2>What is this project about?</h2>
        <p> 
        In this project we built a system where a user can reserve a single 
        parking spot in a parking lot for a whole day. To create this we used a 
        mixture of tools we learned in this semester like MySQL, PHP and others
        that we've learned before such as HTML5,CSS and Java Script.</p>
        <p>
        The idea is pretty simple, you create a user in the login page and you are 
        free to start reserving once for every day. While if you want to become
        an administrator,a special permission will have to be added to your account
        through the database itself (phpMyAdmin). Once you have that permission, you'll
        have a special interface that will enable you to administrate users and their
        reservations.
        </p>
        <h2>For what &amp when was it done?</h2>
        <p>
            This project is a part of the Web Applications &amp Dynamic Web Interfaces
        Course (35-602) from the Information Science Dept. in Bar-Ilan University. It
        was done in the 2nd semester of the year 5776
        </p>
        
            <h2>Who worked on it?</h2>
            <h3 style="text-align: center;">In our team we have</h3>
        <div class="aboutUs">
            <ul class="Students">
                <li class="Student">
                    <div class="StuImg">
                        <img src="media/Ariela.jpg" class="img-circle" alt="Ariela image" width="270" height="270">
                    </div>
                    <h5>Ariela Epstein</h5>
                    <h6>(328606686)</h6>
                </li>
                
                <li class="Student">
                    <div class="StuImg">
                        <img src="media/Avi.jpg" class="img-circle" alt="Avi image" width="270" height="270">
                    </div>
                    <h5>Avraham Kauffmann</h5>
                    <h6>(333789436)</h6>
                </li>
                
                <li class="Student">
                    <div class="StuImg">
                        <img src="media/‏‏Orchan.jpg" class="img-circle" alt="Orchan image" width="270" height="270">
                    </div>
                    <h5>Orchan Magaramov</h5>
                    <h6>(317018224)</h6>
                </li>
                
            </ul>
             
                     
        </div>
    
    </div>

<?php include 'footer.php'; ?>
    </body>
</html>

