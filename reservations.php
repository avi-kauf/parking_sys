<?php 
//written by Ariela Epstein

include 'adminFunctions.php';
session_start();
$start="";
$end="";
$message= "";

if(!isset($_SESSION['user'])){
    header("Location:login.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];
     
//if the user clicked the enter button, get all reservations    
    if($action == "get"){
    $start= $_POST['start'];
    $end = $_POST['end'];
    $allreservations = getAllReservations($start, $end);
          
    } 
//if the user clicked the delete button and the delete checkbox is set, then go through each of checkbox's values and delete it from the db.    
    if($action == "delete") {
            
    if(isset($_POST['check']))
    { $hey= $_POST['check'];
          
    foreach ($hey as $key => $valuu) {
    $eachone =  explode(" ", $valuu);
    list($a, $b, $c) = $eachone;
    if(deleteFromDb($a, $b, $c) != true) {
      $message = deleteFromDb($a, $b, $c);
      break;
    }
    else {
      $message = "reservation deleted and quantity restored";
    }
    }
    
    } 
    } 
       
        
}
    
    
    ?> 
<html>
    <head>
        <link rel="icon" href="media/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <meta charset="UTF-8">
        <title>All Reservations</title>
        <style type="text/css">
            @media print {
            .hidethese {
                visibility: hidden;
            }

            .finishhere {
                page-break-after: always;
            }
            .hidetoo {
               display: none;
            }
        }

        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="content">
        <form method="post">
            <h1>All Reservations</h1>
            <div class="reserve">
            <label for="start">Start </label><input type="date" name="start" value="<?= $start; ?>"/> &nbsp;
            <label for="end">End </label><input type="date" name="end" value="<?= $end; ?>"/> &nbsp;
            <button type="submit" name="action" value="get" class="hidethese">Enter</button> 
            </div>
            <br>
            
        <table>
        <thead><tr><td></td><td>Date</td><td>User Id</td><td>Parking Lot Id</td><td class="hidetoo">Delete</td></tr></thead>
        
        <!-- if $allreservations has data from the db, then display in each row/td the values of each reservation.
        -->
        <?php if(isset($allreservations) && is_array($allreservations)) { 
        foreach ($allreservations as $key => $value): ?>
        <tbody><tr class="finishhere"><td><?= $key +1; ?></td>
        <?php foreach ($value as $val): ?>
        <td><?= $val ?> </td>
        <?php  endforeach; ?>
        <td class="hidetoo"><input type="checkbox" name="check[]" value="<?= implode($value, " "); ?>"/></td> </tr>
        <?php endforeach; } ?>
        </tbody>
        </table>
            <br>
            
        <button type="submit" name="action" value="delete"  class="hidethese" onclick='return confirm("Are you sure you want to delete this reservation?");'>Delete</button>
        <button type="submit" name="action" value="print" onclick="window.print()"  class="hidethese">Print</button>
        </form>
            
            <span id="error"><?php echo $message; ?> </span>
        </div>
            
        <?php include 'footer.php'; ?>  
    </body>
</html>



