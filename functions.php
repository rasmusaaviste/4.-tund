<?php


	//alustan sessiooni, et saaks kasutada $_SESSION muutujaid
	
	session_start();



	//****************
	//*** SIGNUP *****
	//****************
	$database = "if16_Aavister";
	
	function signup ($email, $password) {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email,password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus"; 
			
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
		
	}
	
	function login($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tulpadele muutujad
		$stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase, $created);
		$stmt->execute();
		
		if($stmt->fetch()) {
			//oli rida
			
			
			//võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDatabase) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				 $_SESSION["userId"] = $id;
				 $_SESSION["email"] = $emailFromDatabase;
				 
				 //suunaks uuele lehele
				 header("Location: data.php");
				
				
			} else {
				//ei olnud
				$error = "Parool on vale";
				
				
			} 
			
			
			} else {
			$error = "sellise emailiga ".$email. "kasutajat ei olnud";
		}
		
		return $error;
		
	}





























































	//functions.php
	
	
	/* function sum ($x, $y) {
		
		return $x + $y;
		
		
	}

	echo sum(5476567567, 234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>"; */
	
	
	/* function hello ($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
	
	}
	echo hello ("Rasmus", "Aaviste");
 */



?>