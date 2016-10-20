<?php
//written by Ariela Epstein

include 'adminFunctions.php';
$x=  getUsers();
$response= "";
session_start();

if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
      
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $action = $_POST['action'];
    
        
    if(isset($_POST['check2'])) {
        
//if the user pressed a checkbox to update but clicked the delete button        
    if($action == "delete") {
    unset($_POST['check2']);
    }
//if the checkbox is update and the user clicked update, retrieve the new info added and update the db.  
    if($action == "update2") {
    $new= array_chunk($_POST['changeme'], 7);
    
    foreach($_POST['check2'] as $bl => $email) { 
    foreach ($new as $num => $newstuff){
    if(in_array($email, $newstuff)) {
    list($id,$name,$email,$password,$ptype,$license,$admin) = $newstuff;
    updateUser($id,$name,$email,$password,$ptype,$license,$admin); }  
    }}
  
    unset($_POST['check2']);
    }
    $x = getUsers();
    }

//if the user clicked the delete checkbox and clicked the delete button= delete each user pressed, else unset the delete checkbox.      
    if (isset($_POST['check1'])) {
        
    if($action =="delete") {
    foreach ($_POST['check1'] as $num => $id) {
    $int = (int)$id;
    if(deleteUser($int) == 1)
    {$response = "successfully deleted";}
    else {$response = "problem deleting"; break;}
    }
    
    
    unset($_POST['check1']);
    $x = getUsers();
    }
    else {
    unset($_POST['check1']); } 
    } 
}   
   
    ?> 
<html>
    <head>
        <meta charset="UTF-8">
        <title>All Users</title>
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
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
                <script src="jquery.js"></script>
                <script>
//the user has to confirm before the delete process goes through.               
function myfunction() {
     return confirm("Are you sure you want to delete this user?");     
}
                </script>      
    </head>
    <body>
       
        <?php include 'header.php'; ?>
       
        <div class="content">
            <h1>All Users</h1>
            <br>
            <form method="post">
            <table border="1">
            <thead>
                <!-- 1. if the update checkbox is clicked and posted, then hide the delete button.
                2. if there are users in $x array, echo each one in a separate td.
                3. if the user clicked the checkbox and posted it and that row's email is found in the checkbox's values, then change that td/row to an input type
                (if the key in that row == 2/email || 0/id, then that td will be readonly). However if the checkbox is 
                clicked an posted but that row's email is not found in the checkbox's values, that td/row stays normal. And if the checkbox is not clicked at all, that row/td stays normal.
                -->
            <tr><td></td><td>ID</td><td>Name</td><td>Email</td><td>Password</td><td>Parking Type</td><td>License</td><td>Admin</td>
            <?php if(!isset($_POST['check2'])) { echo '<td class="hidetoo">Delete</td>';} ?>
            <td class="hidetoo">Update</td></tr>
            </thead>
          
            <?php if(isset($x) && is_array($x)) { 
            foreach ($x as $key => $value): ?>
            
            <tbody><tr class="finishhere"><td><?php echo $key +1; ?></td>
                
            <?php foreach ($value as $ke => $val): if(is_int($ke)) {  ?>
             
            <td> <?php if (isset($_POST['check2']) && in_array($value['User_Email'], $_POST['check2']) ) {
                $size = strlen($val);
                if($ke == 2 || $ke == 0) { 
                echo '<input type="text" size= "'. $size .'" readonly name="changeme[]" value="' . $val . '" style="background-color:lightyellow;" />';}
                else {echo '<input type="text" size= "'. $size .'" name="changeme[]" value="' . $val . '" style="background-color:lightyellow;" />';}
            }
            elseif(isset($_POST['check2']) && !in_array($value['User_Email'], $_POST['check2']) )
            {echo $val;}
            
            else {echo $val;}
            } ?></td>
               
            <?php  endforeach;  ?>
                
            <td class="hidetoo"  <?php if(isset($_POST['check2'])) {echo 'style="display:none;"';} ?>><input type="checkbox" name="check1[]" value="<?= $value['User_ID']; ?>"/></td>
            <td class="hidetoo"><input type="checkbox" name="check2[]" value="<?= $value['User_Email']; ?>"/></td>
            </tr> <?php endforeach; } ?>
            
            </tbody>
            </table> 
                <br>
            <?php if(!isset($_POST['check2'])) { echo 
            '<button type="submit" name="action" 
            value="delete"  class="hidethese" onclick="return myfunction();">Delete</button> 
            <button type="submit" name="action" value="update"  class="hidethese" >Update</button>
            <button type="submit" name="action" value="print" onclick="window.print()"  class="hidethese">Print</button>'; } 
            else {echo '<button type="submit" name="action" value="update2"  class="hidethese" >Update</button>'; }?>
            </form>

            <span id="error"><?php echo $response; ?></span>
        </div>
      
            
        <?php include 'footer.php'; ?>    
    </body>
</html>





