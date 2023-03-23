
<!--<form>-->
<!--<input type="text" placeholder="Violation Number" name="violation_number" required/>-->
<!--<input type="text" placeholder="Pin" name="pin" required/>-->
<!--<input type="submit" Value="Submit" name="submit" />-->
<!--</form>-->

<form>
<input type="text" class="violation-no" required placeholder="Violation Number" name="violation_number" oninvalid="this.setCustomValidity('Enter valid violation number')" oninput="this.setCustomValidity('')"  />
<input type="text" class="pin-no" required placeholder="Pin" name="pin" oninvalid="this.setCustomValidity('Enter valid pin number')" oninput="this.setCustomValidity('')"  />
<input type="submit" Value="Submit" name="submit" />
</form>

<?php
include_once('violations/header.php');
global $db;
if(!empty($_REQUEST['submit'])){
	$violation_number = !empty($_REQUEST['violation_number']) ? trim($_REQUEST['violation_number']) : '';
	$pin = !empty($_REQUEST['pin']) ? trim($_REQUEST['pin']) : '';
	$db->query("SELECT * FROM `ci_violations` where violation_number = '$violation_number' and pin = '$pin'");
	if($db->num_rows > 0){
		
		
		header("Location: violations");
	
		//header("Location: /ticket/ticket-view.html");
		exit;
	}
	else{
	    echo "Enter valid violation number";
	}
}
?>