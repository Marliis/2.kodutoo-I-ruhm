<?php 
	require("functions.php");
	
	// 2.kodutöö
	// kas on sisseloginud, kui ei ole siis
	// suunata login lehele
	if (!isset ($_SESSION["userId"])) {
		
		header("Location: login.php");
		
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
		// var_dump($_POST);   //kirjutan, kui on tekkinud viga, see aitab viga tuvastada

	// ei ole tühjad väljad mida salvestada
	if ( isset($_POST["gender"]) &&
		 isset($_POST["age"]) &&
		 isset($_POST["month"]) &&
		 isset($_POST["TypeOfTraining"]) &&
		 isset($_POST["WorkoutHours"]) &&
		 isset($_POST["feeling"]) &&
		 !empty($_POST["gender"]) &&
		 !empty($_POST["age"]) &&
		 !empty($_POST["month"]) &&
		 !empty($_POST["TypeOfTraining"]) &&
		 !empty($_POST["WorkoutHours"]) &&
		 !empty($_POST["feeling"])
	  ) {
	  
	  	//$daynumber = new DateTime($_POST['date']);
	  	//$daynumber = $daynumber->format('Y-m-d');
		
		$gender=cleanInput($_POST["gender"]);
		
		savePeople($_POST["gender"], $_POST["age"], $_POST["month"], $_POST["TypeOfTraining"], $_POST["WorkoutHours"], $_POST["feeling"]);
	}
	
	$people = getAllPeople();
	
	//echo "<pre>"; //nüüd näitab netilehel ilusamini andmeid, see rida ei ole tegelikult oluline
	//var_dump($people);
	//echo "</pre>";
	
?>
<h1>Treeningu andmete sisestamine</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p> 

<h1>Salvesta andmed</h1>
<form method="POST">
			
	<label>Sugu</label><br>
	<input type="radio" name="gender" value="male" > Mees<br>
	<input type="radio" name="gender" value="female" > Naine<br>
	<input type="radio" name="gender" value="Unknown" > Ei oska öelda<br>
	
	<!--<input type="text" name="gender" ><br>-->
	
	<br><br>
	<label>Vanus</label><br>
	<input name="age" type="age" placeholder="Vanus"> 
	
	<br><br>
	<label><h3>Kuupäev</h3></label>
	<input name="month" type="month" placeholder="Kuupäev">
	
	<br><br>
	<label><h3>Treeningu laad</h3></label>
	<input name="TypeOfTraining" type="TypeOfTraining" placeholder="Treeningu laad">
	
	<br><br>
	<label><h3>Treeningu tunnid</h3></label>
	<input name="WorkoutHours" type="WorkoutHours" placeholder="Treeningu tunnid">
	
	<br><br>
	<label><h3>Enesetunne</h3></label>
	<input name="feeling" type="feeling" placeholder="Enesetunne">
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>
