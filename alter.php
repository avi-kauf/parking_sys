<?php
//written by Ariela Epstein

include 'adminFunctions.php';
session_start();

$pid = $pdes = "";
$plname = $plcity= $plstreet= $plbuilding= $pllocation= $plm= $ple= $plr= $pld = $lbday = $div = "";

$message= $message2 = $message3 = "";
$lotids = getallLots();
$showtype = $showlot = $showday = "";

if(!isset($_SESSION['user'])){
    header("Location:login.php");
}

//this will only show the requested section
if($_SERVER["REQUEST_METHOD"] == 'GET') {
    if(isset($_GET['type'])) {
        $showtype = true;
    }
    if(isset($_GET['lot'])) {
        $showlot = true;
    }
    if(isset($_GET['day'])) {
        $showday = true;
    }
}


if($_SERVER["REQUEST_METHOD"] == 'POST') {
    
    $action = $_POST['action'];
    
    //if the admin presses add a parking type ($showtype will keep this div open while the admin has requested it)
    if($action == "addPType") {
        
     $pid= trim(filter_var($_POST['ptype']['id'], FILTER_SANITIZE_STRING));
     $pdes= trim($_POST['ptype']['description'], FILTER_SANITIZE_STRING);
     
     if(!empty($pid) || !empty($pdes)) {
     if(addPType($pid, $pdes) == 1) {
     $showtype = true;
     $message ="parking type added";}
     else {
     $showtype = true;
     $message = "parking type not added";
     }}
     else {
     $showtype = true;
     $message = "please fill out both fields";
     }
     }
    
    // if the admin pressed the add parking lot button ($showtype will keep this div open while the admin has requested it)
    if($action == "addPLot")
    {
        $plid= NULL;
        $plname= trim(filter_var($_POST['plot']['plname'], FILTER_SANITIZE_STRING));
        $plcity= trim(filter_var($_POST['plot']['plcity'], FILTER_SANITIZE_STRING));
        $plstreet= trim(filter_var($_POST['plot']['plstreet'], FILTER_SANITIZE_STRING));
        $plbuilding= trim(filter_var($_POST['plot']['plbuilding'], FILTER_SANITIZE_NUMBER_INT));
        $pllocation= trim(filter_var($_POST['plot']['pllocation'], FILTER_SANITIZE_STRING));
        $plm= trim(filter_var($_POST['plot']['plm'], FILTER_SANITIZE_NUMBER_INT));
        $ple= trim(filter_var($_POST['plot']['ple'], FILTER_SANITIZE_NUMBER_INT));
        $plr= trim(filter_var($_POST['plot']['plr'], FILTER_SANITIZE_NUMBER_INT));
        $pld= trim(filter_var($_POST['plot']['pld'], FILTER_SANITIZE_NUMBER_INT));
        
        if(!empty($plname)){
        if(addPLot($plid, $plname, $plcity, $plstreet, $plbuilding, $pllocation, $plm, $ple, $plr, $pld) == 1) {
        $showlot = true;    
        $message2 ="parking lot added";    
        }
        else {
        $showlot = true; 
        $message2 = "parking lot not added";
        }}
        else {
        $showlot = true; 
        $message2 = "please fill out parking lot name";
        }
        }
    
    //if the admin pressed add lot by day button ($showtype will keep this div open while the admin has requested it. $div shows the user his entered data after it was posted)   
    if($action == "lotby") {
        
      $lbday = $_POST['lotby']['day'];
     
      $dt = new DateTime($lbday);
      $lbday2 = $dt-> format('Y-m-d');
      
      $lbid = $_POST['lotby']['id2'];
      
      if(isset(
       $_POST['lotby']['Motorcycle'] ,
       $_POST['lotby']['Emergency'] ,
       $_POST['lotby']['Regular'] ,
       $_POST['lotby']['Disabled'] ))
      {
       $lbmotor = $_POST['lotby']['Motorcycle'];
       $lbemerg = $_POST['lotby']['Emergency'];
       $lbreg = $_POST['lotby']['Regular'];
       $lbdis = $_POST['lotby']['Disabled']; 
            
       if(addPDay($lbday2, $lbid, $lbmotor, $lbemerg, $lbreg, $lbdis) == 1){
        $showday = true; 
        $div = '<div id="saved"><div class="each2"><label for="lotby[Motorcycle]">Total Spots: Motorcycle : </label>
                         <input type="number" name="lotby[Motorcycle]" value="'. $lbmotor . '" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/></div><br>
                         <div class="each2"><label for="lotby[Emergency]">Total Spots: Emergency: </label>
                         <input type="number" name="lotby[Emergency]" value="'. $lbemerg . '" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/></div><br>
                         <div class="each2"><label for="lotby[Regular]">Total Spots: Regular : </label>
                         <input type="number" name="lotby[Regular]" value="'. $lbreg . '" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/></div><br>
                         <div class="each2"><label for="lotby[Disabled]">Total Spots: Disabled : </label>
                         <input type="number" name="lotby[Disabled]" value="'. $lbdis . '" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/></div><br></div>';
        $message3 = "parking lot by day added";}
       else {
        $lbid = "choose";
        $showday = true; 
        $message3 = "parking lot by day not added";}
      }
      else {
        $showday = true; 
        $message3 = "please fill out date and parking lot id";}      
    }    
    
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alter Tables</title>
        <link rel="stylesheet" type="text/css" href="cssAdmin.css">
        <script src="jquery.js" ></script>
        
    </head>
    <body>
        
               
        <?php include 'header.php'; ?>
        
        
        <div class="content">
        
            <?php if($showtype ==  true) {  ?>
            <div class='alt'>
        <form method="post">
            <h3>Add A Parking Type</h3>
            <div class="each2">
            <label for="ptype[id]">Type ID: </label><input type="text" name="ptype[id]" value="<?= $pid; ?>" title="1 Character" pattern="^[A-Za-z]{1}$"/><br>
            </div>
            <div class="each2">
            <label for="ptype[description]">Description: </label><input type="text" name="ptype[description]" value="<?= $pdes; ?>" title="can contain up to 40 characters" maxlength="40"/><br>
            </div>
            <div class="each2">
            <button type="submit" name="action" value="addPType">Add</button>
            </div>
        </form>
                <span id="error"> <?php echo $message; ?> </span>
            </div>
            <?php } ?>
            
             <?php if($showlot ==  true) {  ?>
            <div class="alt">
        <form method="post">
            <h3>Add A Parking Lot</h3>
            <div class="each2">
            <label for="plot[plname]">Name: </label><input type="text" name="plot[plname]" value="<?= $plname; ?>" title="up to 40 characters" maxlength="40"/><br>
            </div>
            <div class="each2">
            <label for="plot[plcity]">City: </label><input type="text" name="plot[plcity]" value="<?= $plcity; ?>" title="up to 15 characters" maxlength="15"/><br>
            </div>
            <div class="each2">
            <label for="plot[plstreet]">Street Name: </label><input type="text" name="plot[plstreet]" value="<?= $plstreet; ?>" title="up to 15 characters" maxlength="15"/><br>
            </div>
            <div class="each2">
            <label for="plot[plbuilding]">Building Number: </label><input type="text" name="plot[plbuilding]" value="<?= $plbuilding; ?>" title="up to 4 digits" pattern="^[0-9]{1,4}$"/><br>
            </div>
            <div class="each2">
            <label for="plot[pllocation]">Location Details: </label><textarea name="plot[pllocation]" value="<?= $pllocation; ?>" maxlength="40" ><?= $pllocation; ?></textarea><br>
            </div>
            <div class="each2">
            <label for="plot[plm]">Total Spots: Motorcycle: </label><input type="number" name="plot[plm]" value="<?= $plm; ?>" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/><br>
            </div>
            <div class="each2">
            <label for="plot[ple]">Total Spots: Emergency: </label><input type="number" name="plot[ple]" value="<?= $ple; ?>" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/><br>
            </div>
            <div class="each2">
            <label for="plot[plr]">Total Spots: Regular: </label><input type="number" name="plot[plr]" value="<?= $plr; ?>" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/><br>
            </div>
            <div class="each2">
            <label for="plot[pld]">Total Spots: Disabled: </label><input type="number" name="plot[pld]" value="<?= $pld; ?>" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/><br>
            </div>
            <div class="each2">
            <button type="submit" name="action" value="addPLot">Add</button>
            </div>
        </form>
                <span id="error"> <?php echo $message2; ?>  </span>
            </div>
             <?php } ?>
            
            <?php if($showday ==  true) { ?>
            <div class="alt">
        <form method="post">
            <h3>Add A Parking Lot to Lot By Day</h3>
            <div class="each2">
            <label for="lotby[day]">Date: </label><input type="date" name="lotby[day]" value="<?= $lbday; ?>" required/><br>
            </div>
            <div class="each2">
            <label for="lotby[id2]">Lot ID: </label>
            <select name="lotby[id2]" size="1" id="lotid">
                
                <option value="choose">Choose a Lot</option>
                <?php foreach ($lotids as $key => $value): ?>
                        <option <?php if($_SERVER["REQUEST_METHOD"] == 'POST') { if($lbid == $value[0]) {echo 'selected';} }?> value="<?= $value[0] ?>"> <?=$value[0] ?> </option>
                    <?php endforeach; ?>
            </select> 
            </div>

            <div id="ajaxreturn"></div>    
            <?php echo $div; ?>
            
            <div class="each2">
                <button type="submit" id="lotby" name="action" value="lotby">Add</button>
            </div>
        </form>
                <span id="error"> <?php echo $message3; ?> </span>
            </div>
            <?php } ?>
            
        </div>    
       <?php include 'footer.php'; ?>
        
        <script>
        $("#lotid").change(function(){
            
            $("#saved").html('');
            var lotid = $("#lotid").val();
            
    if(lotid != "choose") {
            var serialized_data = "lot_ID=" + lotid; 
            
    request1 = $.ajax({
        url: "ajaxPage.php",
        method: "post",
        data: serialized_data
    });
    request1.done(function (response, textStatus, jqXHR){  

        $("#ajaxreturn").html(response);
        request1 = null;
    });

    request1.fail(function (jqXHR, textStatus, errorThrown){
        alert("error retrieving lot's details: " + textStatus);
    });
    }
    else {
    $("#ajaxreturn").html("");   
    request1 = null;
    }
});      
        </script>  
        
    </body>
</html>

