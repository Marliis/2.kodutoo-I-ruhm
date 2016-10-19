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
	
		// var_dump($_POST);   kirjutan selle, et tekkinud vigu tekkida

	// ei ole tühjad väljad mida salvestada
	if ( isset($_POST["gender"]) &&
		 isset($_POST["age"]) &&
		 isset($_POST["daynumber"]) &&
		 isset($_POST["month"]) &&
		 isset($_POST["WorkoutHours"]) &&
		 !empty($_POST["gender"]) &&
		 !empty($_POST["age"]) &&
		 !empty($_POST["daynumber"]) &&
		 !empty($_POST["month"]) &&
		 !empty($_POST["WorkoutHours"])
	  ) {
		
		$gender=cleanInput($_POST["gender"]);
		
		savePeople($_POST["gender"], $_POST["age"], $_POST["daynumber"], $_POST["month"], $_POST["WorkoutHours"]);
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
	<input name="daynumber" type="daynumber" placeholder="Kuupäev">
	<input name="month" type="month" placeholder="Kuu">
	
	<br><br>
	<label><h3>Treeningu tunnid</h3></label>
	<input name="WorkoutHours" type="workouthours">
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>
