<?php 

include 'adminFunctions.php';
session_start();
$start="";
$end="";


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
    deleteFromDb($a, $b, $c);
    }  } 
    }   
        
}
    
    
    ?> 
<html>
    <head>
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
        }

        </style>
    </head>
    <body>
        <?php include 'navigation.php'; ?>
        
        <form method="post">
            <h1>All Reservations</h1>
            <header>
                <label for="start">Start</label><input type="date" name="start" value="<?= $start; ?>"/>
                <label for="end">End</label><input type="date" name="end" value="<?= $end; ?>"/>
                <button type="submit" name="action" value="get" class="hidethese">Enter</button>
            </header>
            <hr><br>
            
        <table border="1">
        <thead><tr><td></td><td>Date</td><td>User Id</td><td>Parking Lot Id</td><td class="hidethese">Delete</td></tr></thead>
        
        <!-- if $allreservations has data from the db, then display in each row/td the values of each reservation.
        -->
        <?php if(isset($allreservations) && is_array($allreservations)) { 
        foreach ($allreservations as $key => $value): ?>
        <tbody><tr class="finishhere"><td><?= $key +1; ?></td>
        <?php foreach ($value as $val): ?>
        <td><?= $val ?> </td>
        <?php  endforeach; ?>
        <td><input class="hidethese" type="checkbox" name="check[]" value="<?= implode($value, " "); ?>"/></td> </tr>
        <?php endforeach; } ?>
        </tbody>
        </table>
            
        <button type="submit" name="action" value="delete"  class="hidethese" onclick='return confirm("Are you sure you want to delete this reservation?");'>Delete</button>
        <button type="submit" name="action" value="print" onclick="window.print()"  class="hidethese">Print</button>
        </form>
         
    </body>
</html>



