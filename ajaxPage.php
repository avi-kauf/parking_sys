<?php
//written by Ariela Epstein

include 'adminFunctions.php';
$thislot = $_POST['lot_ID'];


$amounts = getLotDetails($thislot);
foreach($amounts as $key => $value) : if(is_int($key)) {
    
if($key == 0) {$type = 'Motorcycle';}
if ($key == 1) {$type = 'Emergency';}
if ($key == 2) {$type = 'Regular';}
if ($key == 3) {$type = 'Disabled';}

echo '<div class="each2"><label for="lotby['. $type . ']">Total Spots: &nbsp;' . $type .': </label>
      <input type="number" name="lotby['. $type .']" value="'. $value . '" title="up to 4 digits" maxlength="4" pattern="^[0-9]{1,4}$"/></div><br>';
} endforeach;

