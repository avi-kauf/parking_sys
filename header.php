<style>
    span#usWell {
    font-size:medium;
    color:#666;
}
</style>
<header class="hidetoo">
    <h1><?php include_once('header_selector.php'); ?><br>
    <span id="usWell"><?= $name; ?></span>
    </h1>
<?php 

if(isset($_SESSION['user'])){
//if the user is not the admin= the nav  will have these pages
if( $_SESSION['user']['admin'] == 0) { ?>
    <nav class="hidetoo">
        <ul>
          <li><a href="myaccount.php">My Account</a></li>
          <li><a href="reserve.php">Reserve a Spot</a></li>
          <li><a href="myreservations.php">My Reservations</a></li>
          <li><a href="about.php">About us</a></li>
          <li><a href="login.php?logout">Logout</a></li>  
        </ul>
    </nav>
    <?php } 
//if the user is the admin= the nav will have these pages
 else {?>
    <nav class="hidetoo">
        <ul>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="users.php">Users</a></li>
            <li class="dropdown">
            <a href="#">Database</a>
            <div class="dropdown-tabs">
            <a href="alter.php?type">Parking Type</a>
            <a href="alter.php?lot">Parking Lot</a>
            <a href="alter.php?day">Lot By Day</a>
            </div>
            </li>
            <li><a href="login.php?logout">Logout</a></li> 
        </ul>
    </nav> 
    <?php } 
}
else { ?>

    <nav>
    <ul>
        <li><a href="login.php?logout">Log In</a></li>
    </ul>
    </nav>
<?php } ?>
</header>
    
        
