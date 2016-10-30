<!-- written by Orchan Magramov
user can see all his reservations, cancel, or print them
-->
<?php
include_once 'functions.php';
session_start();
//Print_r($_SESSION['user']);


//-- While user is logged --//
if (isset($_SESSION['user'])) {
    
$userPar=$_SESSION['user']['User_ParkingType'];
$userLic=$_SESSION['user']['User_License'];
$userId=$_SESSION['user']['User_ID'];  

//-- Showing User Parking Type --//
if($userPar=="R"){
    $parkingType="Regular Parking";
    $imgOpc='<div class="highlight-region" style="top:368px;  left:220px;"></div>';
            $height='310px';
            $width='170px';
}
  elseif($userPar=="M"){
    $parkingType="Motorcycle Parking";
    $imgOpc='<div class="highlight-region" style="top:371px;  left:390px; background-position:-170px;"></div>';
            $height='310px';
            $width='170px';
}
    elseif($userPar=="E"){
        $parkingType="Emergency Parking"; 
        $imgOpc='<div class="highlight-region" style="top:551px;  left:562px; background-position:-342px -500px;"></div>';
        $height='120px';
        $width='428px';
    }
      elseif($userPar=="D"){
        $parkingType="Disabled Parking"; 
          $imgOpc='<div class="highlight-region" style="top:368px; left:562px; background-position:-342px 0px;"></div>';
          $height='137px';
            $width='428px';
    }
else{
     $parkingType="There is not reserved spots";
     $userLic="";
}
//-- Showing User Parking Type --//


//-- Delete Function According To Button --//

//-- Delete Function According To Button --//


}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="media/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>My Reservations</title>
        <style>
            // MyResrvation section
.parkCont {
    position:relative;
    height:317px;
    width:780px;
}
.parkCont div{
    position:absolute;
    background-image:url(media/park.jpg);
}
.parkCont .bg-image {
    opacity:0.3;
    height:317px;
    width:780px;
    margin-left:220px;
    margin-top:65px;
}
.parkCont div.highlight-region {
    opacity:0;
    height:<?= $height ?>;
    width:<?= $width ?>;
}
.parkCont div.highlight-region {
    opacity:1;
}
.noRerve{
    margin-top:100px;
    text-align:center;
}
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php if (isset($_SESSION['user'])) {?>
            <div id="logged">
            <h2>Reservation Control Panel</h2>
        <table style="width:40%">
            <tr>
               <th>Reservations</th>
               <th>License</th>
               <th>Cancel</th>
               <th>Print</th>
            </tr>
            <tr>
                <td><?= $parkingType; ?></td>
                <td><?= wordwrap($userLic,2,'-',true) ?></td>
                <?php 
                if($userPar== "R" || $userPar=="E" || $userPar=="D" || $userPar=="M"){
                    ?>
                <td><button type="submit" name="action" value="deleteR">Cancel</button></td>
                <td><button name="action" value="PrintRes">Print</button></td>
                <?php }
                else{?>
                <td></td>
                <td></td>
                <?php } ?>

            </tr>
        </table>
        </div>
        <?php
        if($userPar== "R" || $userPar=="E" || $userPar=="D" || $userPar=="M"){?>
            <div class="parkCont">
            <div class="bg-image"></div>
             <?=$imgOpc?>
        </div>
        <?php }
        else {?>
        <div class="noRerve"><a href="reserve.php">Please Reserve a Spot</div>
        <?php } ?>
        
<?php }
else{ ?>
            <div id="unlog" style="margin-top:100px;text-align:center;">
            You Are Transferred To Login Page
            <br>
            <span id="dots"></span>
        </div>
         <script type="text/javascript" src="dots.js"></script>   
    <?php } ?> 
        <?php include 'footer.php'; ?>
    </body>
</html>
