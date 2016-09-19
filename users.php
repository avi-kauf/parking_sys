<?php
include 'adminFunctions.php';
$x=  getUsers();
$message= "";

if(isset($_GET['Logout'])) {
           unset($_SESSION['user']); 
        }
       



if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
       
       
       
           
        
     
       
      $action = $_POST['action'];
    
        
    if(isset($_POST['check2'])) {
        
         if($action == "delete") {
             unset($_POST['check2']);
         }
   
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

      
    
     if (isset($_POST['check1'])) {
         if($action =="delete") {
         
        
         
         foreach ($_POST['check1'] as $num => $id) {
         $int = (int)$id;
            deleteUser($int);}
          
             
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
        <title>Users</title>
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
               
function myfunction() {
     return confirm("Are you sure you want to delete this user?");
       
}

                </script>
       
    </head>
    <body>
        <?php include 'navigation.php'; ?>
        
        
            <h1>All Users</h1>
            <hr><br>
            <form method="post">
            <table border="1">
            <thead>
            <tr><td></td><td>ID</td><td>Name</td><td>Email</td><td>Password</td><td>Parking Type</td><td>License</td><td>Admin</td>
            <?php if(!isset($_POST['check2'])) { echo '<td class="hidetoo">Delete</td>';} ?>
                    <td class="hidetoo">Update</td></tr>
            </thead>
          
            <?php if(isset($x) && is_array($x)) { 
                   foreach ($x as $key => $value): ?>
            
        <tbody><tr class="finishhere"><td><?php echo $key +1; ?></td>
                
             <?php foreach ($value as $ke => $val): if(is_int($ke)) {  ?>
             
                <td> <?php if (isset($_POST['check2']) && in_array($value['User_Email'], $_POST['check2']) ) {
                            echo '<input type="text" name="changeme[]" value="' . $val . '" style="background-color:lightyellow;"/>';
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
               <?php if(!isset($_POST['check2'])) { echo 
              '<button type="submit" name="action" 
               value="delete"  class="hidethese" onclick="return myfunction();">Delete</button> 
               <button type="submit" name="action" value="update"  class="hidethese" >Update</button>
               <button type="submit" name="action" value="print" onclick="window.print()"  class="hidethese">Print</button>'; } 
               else {echo '<button type="submit" name="action" value="update2"  class="hidethese" >Update</button>'; }?>
 </form>

           
    </body>
</html>





