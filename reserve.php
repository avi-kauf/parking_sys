<?php 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        if(isset($_GET['logout'])) {
           unset($_SESSION['user']); 
        }
       
    }
     if ($_SERVER["REQUEST_METHOD"] == "GET") {
         
     session_start();
        
     }

    ?> 
<html> <head>
        <meta charset="UTF-8">
        <title>Reserve A Spot</title>
    </head>
    <body>
        <?php include 'navigation.php'; ?>
        
    </body>
</html>

