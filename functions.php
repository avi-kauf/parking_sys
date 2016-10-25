<?php
//written by Ariela Epstein 

//connect to database
// Real database name - parking_reservation
// Test database name - phplogin
    $dsn = 'mysql:host=localhost;dbname=phplogin';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
        $db->exec("set NAMES utf8");
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
        
    }
    
//fills the select/options with description of parking type in login.php
    function getDescription() {
        try {
        global $db;
        $query = $db->prepare("SELECT Description FROM parking_type");
        $query->execute();
        $result = $query->fetchAll();
        $query->closeCursor();
        
        $length = sizeof($result);
        $i = 0;
        for ($i; $i <$length; $i++)
        { $result[$i]= $result[$i]["Description"];}
        return $result;  
        }
        catch (PDOException $ex)
        {
        echo "problem getting description from database".$ex->GetMessage();
        exit;
        }
    }
                   
//checks if the email and password exist in the database        
    function userExists($email, $password){
        try {
        global $db;
        $query = $db->prepare("SELECT * FROM user WHERE User_Email = :email AND User_Password = :password");
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $query->execute();
        $result = $query->fetch();
        $query->closeCursor();
       
        if ($result) return TRUE;
            else    return FALSE;
        }
        catch (PDOException $ex)
        {
        echo "problem checking if user exists in database".$ex->GetMessage();
        exit;
        }
    }
    
//checks if the email exists in the database
    function emailExists($email){
        try {
        global $db;
	$query = $db->prepare("SELECT * FROM user WHERE User_Email = :email");
	$query->bindValue(':email', $email);
        $query->execute();
	$result = $query->fetch();
        $query->closeCursor();
       
        if ($result) return TRUE;
        else    return FALSE;
        }
        catch (PDOException $ex)
        {
        echo "problem checking if email exists in database".$ex->GetMessage();
        exit;
        }
    }
    
//checks if the user is an admin
    function isAdmin($email) {
        try {
        global $db;
	$query = $db->prepare("SELECT * FROM user WHERE User_Email = :email AND  admin = 1");
        $query->bindValue(':email', $email);
        $query->execute();
	$result = $query->fetchAll();
        $query->closeCursor();
       
        if ($result) return TRUE;
        else    return FALSE;
        }
        catch (PDOException $ex)
        {
        echo "problem checking if user is an admin in database".$ex->GetMessage();
        exit;
        }
} 

//adds a new user to the database
    function addNewUser($user2){
    try 
    {
    global $db;
    $query = $db->prepare("INSERT INTO user values (:auto , :name, :email, :password, :ptype, :license, :admin)");
    $query->bindValue(':auto', $user2['auto']);
    $query->bindValue(':name', $user2['name2']);
    $query->bindValue(':email', $user2['email2']);
    $query->bindValue(':password', $user2['password2']);
    $query->bindValue(':ptype', $user2['ptype2']);
    $query->bindValue(':license', $user2['license2']);
    $query->bindValue(':admin', $user2['admin']);
    return $query->execute();
    
    $rowcount = $query->rowCount();
    $query->closeCursor();
    return $rowcount;
    }
     
    catch (PDOException $ex)
    {
    echo "problem adding a new user in database".$ex->GetMessage();
    exit;
    }
}
    
//retrieves a new password, updates the user's password, and sends an email to the user with new password    
    function forgotPassword($email){
    $newPassword = randomPassword();
      
    if(emailExists($email)){
    if(updatePassword($newPassword, $email) == true) {
    if(sendEmail($email,$newPassword) == true) {
    return true;
    }
    else {
    return false; 
    }}
    else { 
    return false;}
    }
}
    
//generates a random password to send to the user
    function randomPassword(){
    $alphabet= "abcdefghijklmnopqrstuvwxyz";
    $password = $alphabet[mt_rand(0, 26)] . $alphabet[mt_rand(0, 26)] . $alphabet[mt_rand(0, 26)] . $alphabet[mt_rand(0, 26)] . rand(100, 999);
    return $password;
}

//sends the email to user's email, with the restore password link, from the admin
    function sendEmail($email, $newPassword) {
    $host = $_SERVER['HTTP_HOST'];
    $project = dirname($_SERVER['PHP_SELF']);
    $scheme = $_SERVER['REQUEST_SCHEME'];
    $emailLink = $scheme.'://'.$host.$project.'/login.php?email='.$email.'&password='.$newPassword ;
	
    $message = "<a href='$emailLink'>Reset password here</a>.<br>  Thank you!";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ariela.epstein@gmail.com" . "\r\n"; 
      
    if(mail($email, "reset password", $message, $headers)) {
    return true;
    } 
    else {
    return false;} 
}

      
//after email is sent, a new password is updated in the database
    function updatePassword($newPassword, $email2) {
    try{
    global $db;
    $query = $db->prepare("UPDATE user SET User_Password = :password WHERE User_Email = :email");
    $query->bindValue(':password', $newPassword);
    $query->bindValue(':email', $email2);
    $query->execute(); 
    $query->closeCursor();
   
    return $query->rowCount() ? true : false;
    }
    catch (PDOException $ex)
    {
        echo "problem updating password in database".$ex->GetMessage();
        exit;
    }  
}
//BY Avi to get single user and add him to the session
function getUser($email, $pswrd) {
    try {
    global $db;
    $query = $db->prepare("SELECT * FROM user WHERE User_Email = :email AND User_Password = :pswrd");
    $query->bindValue(':email', $email);
    $query->bindValue(':pswrd', $pswrd);
    $query->execute();
    $result = $query->fetchAll();
    
    if($result) {return $result;}
    else{ return FALSE;}
    }
    catch (PDOException $ex)
    {
    echo "problem getting user from database".$ex->GetMessage();
    exit;
    }
}



