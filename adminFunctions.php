<?php
include_once 'functions.php';
   
function getAllReservations($start, $end) {
    global $db;
    $query = $db->prepare("SELECT * FROM reservation WHERE Rsrv_Date BETWEEN :start AND :end");
    $query->bindValue(':start', $start);
    $query->bindValue(':end', $end);  
    $query->execute();
    $result = $query->fetchAll();
  
    if ($result) {
        $length = sizeof($result);
    $l = sizeof($result[$length -1]);
    $length2 =  $l / 2;
     for($i = 0; $i <$length; $i++) {
        for($m = 0; $m<$length2; $m++) {
            $stuff[$i][$m] = $result[$i][$m]; 
        }
     }
    return $stuff; }
    else    { return FALSE;}
            
}

function deleteFromDb($date, $uid, $pid) {
    global $db;
    $query = $db->prepare("DELETE FROM reservation WHERE Rsrv_Date = :date AND Rsrv_UserID = :uid AND Rsrv_ParkingLotID = :pid");
    $query->bindValue(':date', $date);
    $query->bindValue(':uid', $uid);
    $query->bindValue(':pid', $pid);
    $query->execute();
   
}

function getUsers() {
    global $db;
    $query = $db->prepare("SELECT * FROM user");
    $query->execute();
    $result = $query->fetchAll();
    
    if($result) {return $result;}
    else{ return FALSE;}
}

function updateUser($id,$name,$email,$password,$ptype,$license,$admin) {
    global $db;
        $query = $db->prepare("UPDATE user SET User_ID = :id, User_Name = :name, User_email = :email, User_Password = :password, User_ParkingType = :ptype,
            User_License = :license, admin = :admin WHERE User_Email = :email");
	$query->bindValue(':id', $id);
        $query->bindValue(':name', $name);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $query->bindValue(':ptype', $ptype);
        $query->bindValue(':license', $license);
        $query->bindValue(':admin', $admin);
        $query->execute();
    
}

function deleteUser($id) {
    global $db;
     $query = $db->prepare("DELETE FROM user WHERE User_ID = :id");
     $query->bindValue(':id', $id);
     $query->execute();
}