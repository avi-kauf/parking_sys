<?php
// Written by Avi
include_once 'adminFunctions.php';
session_start();
$msg=$userName=$userPT=$ready="";
$alert="<script type='text/javascript'>alert("."$msg".");</script>";

if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
$user= $_SESSION['user'];
$userName=  explode(" ", $user['User_Name']);
$userPT=$user['User_ParkingType'];
$userID=$user['User_ID'];

/// always get availability info
$lots=  getAllLBD();
$lots= availableLots($lots, $userID, $userPT);


//////---------------GET METHOD-------//////
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $ready = FALSE;
    $dates= getDates($lots);
}

//////---------------POST METHOD-------/////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $action=$_POST['action'];
    
    ///Check from date 
    if ($action == "checkDate") { 
        $ready=TRUE;
        $rDate = $_POST['reserve']['date'];
        //grab lots of that day
        $lotOfDay=array(); 
        foreach ($lots as $lbd=>$val) {
                    if($val['Date']==$rDate){
                    array_push($lotOfDay,$val);
                }}
    }
    
    ///add reservation 
    if ($action == "reserve") { 
        $rDate = $_POST['reserve']['date'];
        $rPid = $_POST['reserve']['pid'];
        $rUid = $user['User_ID'];
        $type = $user['User_ParkingType'];
        addReserve($rDate, $rUid, $rPid);
        reduceAvailability($rDate, $rPid, $type);
        header("Location:reserve.php");
    }

}
 
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
        
        <h2>Hi <?=$userName[0]?>! <br> Please reserve a parking spot:</h2>
        <form method="post">
       <div class="each">
       <label for="reserve[date]">Select a Date:</label>
       <select size="1" name="reserve[date]">
                     <?php if(!($ready)):?>
                    <?php foreach ($dates as $date): ?>
                        <option value="<?=$date?>"> <?=$date?> </option>
                    <?php endforeach;endif;?> 
                    <?php if($ready):?>?>
                         <option value="<?=$rDate?>"> <?=$rDate?> </option>
                         <?php endif;?>
       </select>
       </div>
       <?php if($ready):?>
       <div class="each">
       <label for="reserve[pid]">Select a Parking Lot:</label>
       <select size="1" name="reserve[pid]">
           <?php if(isset($lotOfDay) && is_array($lotOfDay)): 
            foreach ($lotOfDay as $each=>$data): 
           // getting details about the reservation
           $pDetails=getParkingName($data["Lot_ID"]);
           $pDetails=$pDetails[0];
           ?>
           <option value="<?=$data["Lot_ID"]?>"> <?= 
                    $pDetails['Lot_Name']." at:".$pDetails['Street_Name'].
                   " ".$pDetails['Building_Number'].
                   ", ".$pDetails['City']?>  
                   </option>
             <?php endforeach;endif;?>
       </select>
       </div>
        <?php endif;?>
       <div class="each">
           <?php if($ready){ echo '
            <button type="submit" name="action" value="reserve">
            Confirm Reservation</button>';}
           else{ echo '
               <button type="submit" name="action" value="checkDate">
               Check Date</button>';}            
            ?>
       </div>
        </form>
        
        <?php include 'footer.php'; ?>
    </body>
</html>
 
