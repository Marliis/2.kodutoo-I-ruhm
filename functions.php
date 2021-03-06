<?php
	
	// 2.kodutöö
	//functions.php
	require("../../config.php");
	
	//alustan sessiooni, et saaks kasutada
	//$_SESSSION muutujaid
	session_start();
	
	//********************
	//****** SIGNUP ******
	//********************
	//$name = "Marliis";
	//var_dump($GLOBALS);
	
	$database = "if16_Marliis";
	
	function signup ($name, $gender, $age, $email, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (name, gender, age, email, password) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//asendan küsimärgi väärtustega
		//iga muutuja kohta tuleb kirjutada üks täht, mis tüüpi muutuja on
		//s-stringi
		//i-integer
		//d-double/float
		$stmt->bind_param("sisss", $name, $age, $email, $password, $gender);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created 
			FROM user_sample
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()) {
			//oli rida
		
			// võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				//suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			} else {
				$error = "parool vale";
			}
			
		
		} else {
			//ei olnud 
			
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
		
		
		return $error;
		
		
	}
	
	
	function savePeople ($gender, $age, $month, $TypeOfTraining, $WorkoutHours, $feeling) {
		
		//ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		// käsk
		$stmt = $mysqli->prepare("INSERT INTO AthletesData (gender, age, month, TypeOfTraining, WorkoutHours, feeling) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("siisis", $gender, $age, $month, $TypeOfTraining, $WorkoutHours, $feeling);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	
	function getAllPeople () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		//käsk
		$stmt = $mysqli->prepare("SELECT id, gender, age, month, TypeOfTraining, WorkoutHours, feeling FROM AthletesData");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $gender, $age, $month, $TypeOfTraining, $WorkoutHours, $feeling);
		$stmt->execute();
		
		// array("Marliis", "O")
		$result = array();
		
		// seni kuni on üks rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()) {
			$person = new StdClass();
			$person->id = $id;
			$person->gender = $gender;
			$person->age = $age;
			$person->month = $month;
			$person->TypeOfTraining = $TypeOfTraining;
			$person->WorkoutHours = $WorkoutHours;
			$person->feeling = $feeling;

			
			//echo $color."<br>";
			array_push($result, $person);
		}
		
	$stmt->close();
	$mysqli->close();
	
	return $result;
		
	}
	
	
	
	
	
	function cleanInput($input){
		
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		
		return $input;
	}
	
	
	
	
	/*function sum ($x, $y) {
		
		return $x + $y;
		
	}
	
	function hello ($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	
	echo sum(5476567567,234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Marliis", "Odamus");
	*/
	
	
	/*
	
	function issetAndNotEmpty($var) {	
		if ( isset ( $var ) ) {
			if ( !empty ($var ) ) {
				return true;			
			}	
		} 
		
		return false;	
	}
	
	if (issetAndNotEmpty($_POST["loginEmail"])) {
		
		//vastab tõele
		
	}
	
	
	
	
	*/
?>