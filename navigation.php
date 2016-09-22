<?php 

if(isset($_SESSION['user'])){

//if the user is not the admin= the nav  will have these pages
if( $_SESSION['user']['admin'] == 0) { ?>
        <nav><a href="reserve.php">Reserve a Spot</a><a href="myReservations.php">My Reservations</a><a href="myAccount.php">My Account</a><a href="login.php?logout">Logout</a> </nav>      
 <?php } 
//if the user is the admin= the nave will have these pages
 else {?> <nav><a href="reservations.php" class="hidethese">Reservations</a><a href="users.php" class="hidethese">Users</a>
<a href="alter.php" class="hidethese">Database</a><a href="login.php?logout" class="hidethese">Logout</a> </nav> <?php } 
}
else {
    header("Location:login.php");
}


