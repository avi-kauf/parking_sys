<?php 
session_start();     
?> 
<html> 
    <head>
        <link rel="icon" href="media/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Reserve A Spot</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php if (isset($_SESSION['user'])) {?>
        
        <?php }
        else { ?>
        
        <div id="unlog" style="margin-top:100px;text-align:center;">
            You Are Transferred To Login Page
            <br>
            <span id="dots"></span>
        </div>
        
         <?php } ?> 
        <?php include 'footer.php'; ?>
    </body>
</html>
<script type="text/javascript" src="dots.js"></script>
