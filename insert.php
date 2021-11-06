<?php
	$title = $_POST['title'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$VaccinationType = $_POST['VaccinationType'];
	$gender = $_POST['gender'];
	$VaccinationDate = $_POST['VaccinationDate'];
	$session = $_POST['session'];
	$street = $_POST['street'];
	$additional = $_POST['additional'];
	$zip = $_POST['zip'];
	$place = $_POST['place'];
	$country = $_POST['country'];
	$code = $_POST['code'];
	$phone = $_POST['phone'];
	$your_email = $_POST['your_email'];
	$link_address='index.html';

	if(!empty($first_name) || !empty($VaccinationType) || !empty($gender) || !empty($VaccinationDate) || !empty($session) || !empty($street) || !empty($zip) || !empty($country) || !empty($code) || !empty($phone) || !empty($your_email)){
		$host = "127.0.0.1";
		$dbUsername = "root";
		$dbPassword = "";
		$dbname = "fhir";
		
		$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

		if(mysqli_connect_error()){
			die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
		}
		else{
			$SELECT = "SELECT your_email FROM register WHERE your_email = ? Limit 1";
			$INSERT =" INSERT INTO register(title, first_name, last_name, VaccinationType, gender, VaccinationDate, session, street, additional, zip, place, country, code, phone, your_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = $conn->prepare($SELECT);
			$stmt->bind_param("s",$your_email);
			$stmt->execute();
			$stmt->bind_result($your_email);
			$stmt->store_result();
			$stmt->fetch();
			$rnum = $stmt->num_rows;

			if($rnum==0){
				$stmt->close();

				$stmt = $conn->prepare($INSERT);
				$stmt->bind_param("sssssssssisssis", $title, $first_name, $last_name, $VaccinationType, $gender, $VaccinationDate, $session, $street, $additional, $zip, $place, $country, $code, $phone, $your_email);
				$stmt->execute();
				
				echo "Record had been submitted sucessfully! <a href='".$link_address."'>Back</a>";
			}

			else{
				echo "E-mail already exits! <a href='".$link_address."'>Back</a>";
			}
			$stmt->close();
			$conn->close();
		}
	}
	else{
		echo "All field are required <a href='".$link_address."'>Back</a>";
		die();
	}
?>