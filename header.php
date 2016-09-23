<style>
header {
    margin: 0 auto;
    background: #73AEDB ;
    clear: both;
   
}
header h1{
     color: #333;
     font-weight: bold;
     font-family: cursive;
}
nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #e7e7e7;
    background-color: #f3f3f3;
}

nav ul li {
    float: left;
}
nav ul li a {
    display: block;
    color: #666;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
nav ul li a:hover{
    background-color: #ddd;
}
nav ul li:last-child{
    float: right;
    background-color: #4CAF50;
}
</style>

<header>
    <h1 align="center">Parking Reservation</h1>
</header>

<?php 
if(isset($_SESSION['user'])){
//if the user is not the admin= the nav  will have these pages
if( $_SESSION['user']['admin'] == 0) { ?>
    <nav>
        <ul>
          <li><a href="myaccount.php">My Account</a></li>
          <li><a href="reserve.php">Reserve a Spot</a></li>
          <li><a href="myreservations.php">My Reservations</a></li>
          <li><a href="about.php">About us</a></li>
          <li><a href="login.php?logout">Logout</a></li>  
        </ul>
    </nav>
    <?php } 
//if the user is the admin= the nave will have these pages
 else {?>
    <nav>
        <ul>
            <li><a href="reservations.php" class="hidethese">Reservations</a></li>
            <li><a href="users.php" class="hidethese">Users</a></li>
            <li><a href="alter.php" class="hidethese">Database</a></li>
            <li><a href="login.php?logout" class="hidethese">Logout</a></li> 
        </ul>
    </nav> 
    <?php } 
}
else {
    header("Location:login.php");
        }
 ?>



