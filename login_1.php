<?php 
//--Written by Ariela Epstein--//
   
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
    header("Location:myaccount.php");
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
        
    if(addNewUser($user2) == 1) { 
        
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
        <title>Login/ Sign Up</title>
        <script type="text/javascript" src="jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style type="text/css">
input[type=text], input[type=email]
{
  border: 1px solid #ccc;
  border-radius: 3px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  width:200px;
  min-height: 28px;
  padding: 4px 20px 4px 8px;
  font-size: 12px;
  -moz-transition: all .2s linear;
  -webkit-transition: all .2s linear;
  transition: all .2s linear;
}
input[type=text]:focus,input[type=email]:focus
{
  width: 400px;
  border-color: #51a7e8;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1),0 0 5px rgba(81,167,232,0.5);
  outline: none;
}
input[type=password]
{
  border: 1px solid #ccc;
  border-radius: 3px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  width:200px;
  min-height: 28px;
  padding: 4px 20px 4px 8px;
  font-size: 12px;
  -moz-transition: all .2s linear;
  -webkit-transition: all .2s linear;
  transition: all .2s linear;
}
input[type=password]:focus
{
  width: 400px;
  border-color: #51a7e8;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1),0 0 5px rgba(81,167,232,0.5);
  outline: none;
}
</style>  
  <script>
  $(function() {
    $( ".content" ).tabs();
  });
  </script>
    </head>
    <body>
        <?php include 'header.php'; ?>
 <div class="content" style="width: 480px;">
     <ul>
         <li><a href="#loginp">Log In</a></li>
         <li><a href="#loginp2">Signup</a></li>
         <li><a href="#forgotPass">Forgot Password</a></li>
     </ul>
     
      <div id="loginp"> 
      <form method="post">
      <div class="each">
      <label for="user[email]">Email:</label>
      <input type="email" name="user[email]" value="<?= $user["email"] ?>" required="required" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="please enter a valid email address">
      </div>
      <div class="each">
      <label for="user[password]">Password:</label>
      <input type="password" name="user[password]" value="<?= $user["password"] ?>" required="required" pattern="^[A-Za-z0-9]{6,10}$" title="please enter 6-10 letters or digits" > 
      </div>
      <div class="each">
      <button type="submit" name="action" value="login">Login</button>
      </div> 
          <span id="error">  <?php  echo $message; ?> </span>
      </form>
        
      </div>

      <div id="loginp2">
        <form method="post">
       <div class="each">
       <label for="user2[email2]">Email:</label>
       <input type="email" name="user2[email2]" value="<?= $user2["email2"] ?>" required="required" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="please enter a valid email address">
       </div>
       <div class="each">
       <label for="user2[password2]">Password:</label>
       <input type="password" name="user2[password2]" required="required" pattern="^[A-Za-z0-9]{6,10}$" title="please enter 6-10 letters or digits" > 
       </div>
       <div class="each">
       <label for="user2[fname2]">First Name:</label>
       <input type="text" name="user2[fname2]" required="required" > 
       </div>
       <div class="each">
       <label for="user2[lname2]">Last Name:</label>
       <input type="text" name="user2[lname2]" required="required" >
       </div>
       <div class="each">
       <label for="user2[ptype2]">Parking Type:</label>
       <select size="1" name="user2[ptype2]">
                    <?php foreach ($type as $value): ?>
                        <option value="<?= $value ?>"> <?= $value ?> </option>
                    <?php endforeach;
                    ?>
       </select>
       </div>
       <div class="each">
       <label for="user2[license2]">License:</label>
       <input type="text" name="user2[license2]" required="required" pattern="^[0-9]{5,7}$" title="please enter 5-7 digits">
       </div>
       <div class="each">
       <button type="submit" name="action" value="newuser">Sign Up</button>
       </div>
            <span id="error"> <?php  echo $message2; ?> </span>
        </form>
        
       </div>
    
     <div id="forgotPass">
            <form method="post">
      <div class="each">
      <label for="user1[email1]">Email:</label>
      <input type="email" name="user1[email1]" required="required"  pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="please enter a valid email address">
      </div>
      <div class="each">
      <button type="submit" name="action" value="forgot">Forgot Password</button>
      </div>
      </form>  
     </div>
 </div>      
        <?php include 'footer.php'; ?>
    </body>
</html>
