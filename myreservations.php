<!-- written by Avi Kauffmann
user can see all his reservations, cancel, or print them
-->
<?php
include_once 'adminFunctions.php';
session_start();
$msg="";
$alert="<script type='text/javascript'>alert("."$msg".");</script>";

if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
$user= $_SESSION['user'];

//////---------------GET METHOD-------//////
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $counter=1;
    $reservations=  getReserve($user['User_ID']);    
}

//////---------------POST METHOD-------/////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $action = $_POST['action'];
    
    ///delete reservation
    if ($action == "delete") { 
        $rDate = $_POST['reserve']['date'];
        $rPid = $_POST['reserve']['pid'];
        $rUid = $user['User_ID'];
        deleteFromDb($rDate, $rUid, $rPid);
        header("Location:myreservations.php");
    }  

}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="media/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <title>My Reservations</title>
       <script>
             /// confirm action
            function check() {
            return confirm("Are you sure?");
            }
        </script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="content">
            <h1>My Reservations</h1>
            <br>
        <table>
        <thead><tr>
        <td>Index</td><td>Date</td><td>Parking Lot Name</td>
        <td>Address</td><td>Deletion</td></tr></thead>
        <!--  display in each row/td the values of each reservation -->
        <?php if(isset($reservations) && is_array($reservations)) { 
        foreach ($reservations as $each=>$data): ?>
        <tbody><tr><form method="post">
           <td><?=$counter++;?></td>
           <td><?= $data['Rsrv_Date']?></td>
           <?php 
           // getting details about the reservation
           $pDetails=getParkingName($data['Rsrv_ParkingLotID']);
           $pDetails=$pDetails[0];
           ?>
           <td><?= $pDetails['Lot_Name']?></td>
           <td><?=$pDetails['Street_Name']." ".$pDetails['Building_Number'].
                   ", ".$pDetails['City']?></td>
        <!--Inputs to send info to be deleted -->
        <input type="hidden" name="reserve[date]" value="<?= $data['Rsrv_Date']?>">
        <input type="hidden" name="reserve[pid]" value="<?=$data['Rsrv_ParkingLotID']?>">
        <td><button type="submit" name="action" value="delete" 
         onclick='return check();'>Delete</button></td></form></tr>
        <?php endforeach; } ?>
        </tbody>
        </table>
            <br>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>

