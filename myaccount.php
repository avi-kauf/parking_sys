<?php
// Written by Avi
include_once 'functions.php';
include_once 'adminFunctions.php';
session_start();
////variables to send alerts/change modes 
$msg=$readonly=$update=$userUpdate="";
$alert="<script type='text/javascript'>alert("."$msg".");</script>";
$user= $_SESSION['user'];
$userName=  explode(" ", $user['User_Name']);
if(!isset($_SESSION['user'])){
    header("Location:login.php");
}

//////---------------GET METHOD-------//////
if ($_SERVER["REQUEST_METHOD"] == "GET") {
       $type = getDescription();
       $readonly="readonly";
       $update=FALSE;
}

//////---------------POST METHOD-------/////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = getDescription();
    $action = $_POST['action'];
    
    ///set to update mode
    if ($action == "UpdateMode") { 
        $readonly='';
        $update=TRUE;
    }
    
    /*confirm update- not allowing email and Ptype, if we allow such thing
    it will mess with all the data in the future*/ 
     if ($action == "UpdateInfo") { 
         
        $userfname = trim(filter_var($_POST['user']['fname'], FILTER_SANITIZE_STRING));
        $userlname = trim(filter_var($_POST['user']['lname'], FILTER_SANITIZE_STRING));
        $userUpdate["name"] = $userfname." ".$userlname;                
        $userUpdate["email"]= trim(filter_var($_POST['user']['email'], FILTER_SANITIZE_EMAIL));

        if (preg_match("/^[a-zA-Z0-9]{6,10}$/", $_POST['user']['password']) && 
                preg_match("/^[0-9]{5,7}$/", $_POST['user']['license'])) {
                $userUpdate["password"] = trim($_POST['user']['password']);
                $userUpdate["license"] = trim($_POST['user']['license']);
                }

        if(userExists($userUpdate['email'], $userUpdate['password']) &&
                $userUpdate['email']!=$user['User_Email']) {
        $msg= "user name and password are already taken";
        echo $alert;
        }
        else {
              updateUser($user['User_ID'],$userUpdate["name"],$user["User_Email"],
                $userUpdate["password"],$user["User_ParkingType"],
                $userUpdate["license"],0);
                $user = getUser($userUpdate['email'], $userUpdate['password']);
                //start new session with new updates
              if(isset($user) && is_array($user)){$user=$user[0];}
                unset($_SESSION['user']);
                $_SESSION['user'] = $user;
                header("Location:reserve.php");
            
        } 
    }         
    /// deleting action
    if($action =="delete") {
    if(deleteUser($user['User_ID']) == 1)
    {$msg = "successfully deleted ";}
    else 
        {$msg = " problem deleting ";}
    echo $alert;
    unset($_SESSION['user']);
        session_destroy();
     header("Location:login.php");
    }
}

?>
<html>
    <head>
        <link rel="icon" href="media/favicon.ico" />
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <title>My Reservations</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
          <?php if(!$update){ echo '<h2>Your Account</h2>' ;}
           else{ echo '<h2>Update Your Information</h2>';} ?> 
       <form method="post">
       <div class="each">
       <label for="user[email]">Email:</label>
       <input type="email" name="user[email]" value="<?= $user['User_Email']?>"
               readonly><?php if($update)echo" To change email, please contact "
                   . "our offices";?>
       </div>
       <div class="each">
       <label for="user[password]">Password:</label>
       <input type="password" name="user[password]" value="<?= $user['User_Password']?>"
              required="required" pattern="^[A-Za-z0-9]{6,10}$"
              title="please enter 6-10 letters or digits" <?=$readonly?>> 
       </div>
       <div class="each">
       <label for="user[fname]">First name:</label>
       <input type="text" name="user[fname]" value="<?= $userName[0]?>" 
              required="required" <?=$readonly?> > 
       </div>
       <div class="each">
       <label for="user[lname]">Last Name:</label>
       <input type="text" name="user[lname]" value="<?= $userName[1]?>" 
              required="required" <?=$readonly?> > 
       </div>
       <div class="each">
       <label for="user[ptype]">Parking Type:</label>
       <input type="text" name="user[ptype]" value=
           <?php foreach ($type as $value){ 
                if($value[0]==$user['User_ParkingType']){
           echo "$value";}}?> readonly>
        <?php if($update)echo" To change Parking Type, please contact "
       . "our offices";?>
       </div>
       <div class="each">
       <label for="user[license]">License:</label>
       <input type="text" name="user[license]" value="<?= $user['User_License']?>"
              required="required" pattern="^[0-9]{5,7}$"
              title="please enter 5-7 digits" <?=$readonly?>>
       </div>
       <div class="each">
           <?php if(!$update){ echo '
            <button type="submit" name="action" value="UpdateMode">Update</button>
            </div>
            <div class="each">
            <button type="submit" name="action" value="delete" 
           onclick="return confirm('.'"Are you sure?"'.');">Delete</button>';}
          /*update will update user while cancel will run get script to return
           to the view page
           */
           else{ echo '
               <button type="submit" name="action" value="UpdateInfo"
               onclick="return confirm('.'"Are you sure?"'.');">Confirm</button>
               </div></form>             
               <form method="get">
               <div class="each">
               <button type="submit">Cancel</button>';}            
            ?>
       </div>
        </form>
        
        <?php include 'footer.php'; ?>
    </body>
</html>

