<?php 
   
include "functions.php";
$message="";
$message2= "";
$user["email"]=$user["password"]= "";
$user2["email2"] = "";


 
//when the user clicks the new password email link- the fields will contain the new password
if ($_SERVER["REQUEST_METHOD"] == "GET") { 
         
    $type = getDescription();
           
    if (isset($_GET["email"]) ) {
    $user["email"] =$_GET["email"];
    $user["password"] =$_GET["password"]; 
     
    }
    if(isset($_GET['logout'])) {
        session_start();
        unset($_SESSION['user']);
        session_destroy();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $type = getDescription();
    $action = $_POST['action'];
    session_start();
        
        
//when login is pressed- checks the input validity and starts a new user session
    if ($action == "login") {  
        
    $user["email"]= filter_var($_POST['user']['email'], FILTER_SANITIZE_EMAIL);
    $user["password"] =$_POST['user']['password'];
        
    if (userExists($user['email'], $user['password'])) {
            
    $_SESSION['user'] = $user;
            
    if (isAdmin($user['email'])) {
    $_SESSION['user']['admin'] = 1;
    header("Location:reservations.php");
    }
    else { $_SESSION['user']['admin'] = 0;
    header("Location:reserve.php");
    }
    }
    else {
        $message = "the email/password does not exist, please sign up"; }
    }
    
//when the user forgot his password- a new password is generated and sent to the email of the user
    if ($action == "forgot") {
  
    $user1['email1']= filter_var($_POST['user1']['email1'], FILTER_SANITIZE_EMAIL);
 
    if(emailExists($user1['email1'])) {
     
    if(forgotPassword($user1['email1'])) {
    $message ="A new password has been sent to your email." ; 
    }
    else {
        $message = "Email/Password update fail.";
    }
    }
    else { $message = "this email does not exist, please sign up";
    $user2['email2'] = $user1['email1'];}
 
 }

//when creating a new user- checks the input validity and starts the session for the user
    if ($action == "newuser"){
    $user2["auto"] = NULL;
    $userfname = trim(filter_var($_POST['user2']['fname2'], FILTER_SANITIZE_STRING));
    $userlname = trim(filter_var($_POST['user2']['lname2'], FILTER_SANITIZE_STRING));
    $user2["name2"] = $userfname." ".$userlname;                
    $user2["email2"]= trim(filter_var($_POST['user2']['email2'], FILTER_SANITIZE_EMAIL));
    $subtype= substr($_POST['user2']['ptype2'], 0, 1);
    $user2["ptype2"]= $subtype;
    $user2["admin"] = 0; 
    
    if (preg_match("/^[a-zA-Z0-9]{6,10}$/", $_POST['user2']['password2']) && preg_match("/^[0-9]{5,7}$/", $_POST['user2']['license2'])) {
    $user2["password2"] = trim($_POST['user2']['password2']);
    $user2["license2"] = trim($_POST['user2']['license2']);
    }
    
    if(userExists($user2['email2'], $user2['password2'])) {
    $message2= "user name and password are already taken";
    }
    else {
        
    if(addNewUser($user2)) { 
        
    if(isAdmin($user2['email2'])) {
    $_SESSION['user']['admin'] = 1; 
    }
    else {
    $_SESSION['user']['admin']= 0; 
    }
  
   
    $_SESSION['user'] = $user2;
    header("Location:reserve.php");
    }
    else { 
    $message2 = "failed to add to database, since email address exists already";
    }
    } 
    
    }
    
}




?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="loginCSS.css">
        <script src="jquery.js"></script>
        <script>
            
        </script>
    </head>
    <body> 
      <article>
            
      <aside id="existing"> 
          <form method="post">
      <h1>Log In</h1>    
      <label for="user[email]">Email:</label>
      <input type="email" name="user[email]" value="<?= $user["email"] ?>" required="required" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="please enter a valid email address"><br>
      <label for="user[password]">Password:</label>
      <input type="password" name="user[password]" value="<?= $user["password"] ?>" required="required" pattern="^[A-Za-z0-9]{6,10}$" title="please enter 6-10 letters or digits" ><br> 
      <button type="submit" name="action" value="login">Login</button><br><br>
          </form>
          
          <form method="post">
      <h1>Forgot Password</h1>
      <label for="user1[email1]">Email:</label>
      <input type="email" name="user1[email1]" required="required"  pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="please enter a valid email address"><br>
      <button type="submit" name="action" value="forgot">Forgot Password</button>
         </form>
          <?php  echo $message; ?>
      </aside>
        <hr>
       
      <aside id="new">
            <form method="post">
       <h1>Sign Up</h1>
       <label for="user2[email2]">Email:</label>
       <input type="email" name="user2[email2]" value="<?= $user2["email2"] ?>" required="required" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="please enter a valid email address"> <br>
       <label for="user2[password2]">Password:</label>
       <input type="password" name="user2[password2]" required="required" pattern="^[A-Za-z0-9]{6,10}$" title="please enter 6-10 letters or digits" > <br>
       <label for="user2[fname2]">First Name:</label>
       <input type="text" name="user2[fname2]" required="required" > <br>
       <label for="user2[lname2]">Last Name:</label>
       <input type="text" name="user2[lname2]" required="required" > <br>
       <label for="user2[ptype2]">Parking Type:</label>
       <select size="1" name="user2[ptype2]">
                    <?php foreach ($type as $value): ?>
                        <option value="<?= $value ?>"> <?= $value ?> </option>
                    <?php endforeach;
                    ?>
       </select><br>
       <label for="user2[license2]">License:</label>
       <input type="text" name="user2[license2]" required="required" pattern="^[0-9]{5,7}$" title="please enter 5-7 digits"><br>
       <button type="submit" name="action" value="newuser">Sign Up</button>
           </form>
            <?php  echo $message2; ?>
       </aside>
    
       </article>
    </body>
</html>