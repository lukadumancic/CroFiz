
		<script>
			a="<?php
				if(isset($_POST["userOrPass"])){
					if($_POST["userOrPass"]!==""){
						//Postavljanje varijabli za spajanje na bazu
						$servername = "hugeiceberg.ddns.net";
						$username = "admin";
						$password = "124578";
						$dbname = "crofiz";

						// Stvaranje veze
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Provjera veze
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 
						
						//Querry
						$sql="INSERT INTO zaboravljeno (`zab`) VALUES ('".$_POST["userOrPass"]."')";
						//Slanje
						if ($conn->query($sql) === FALSE) {
							echo $conn->error;  
						}
						$conn->close();
						echo "Provjerite email";
					}
				}
			?>";
			window.location="http://hugeiceberg.ddns.net/WebPage/Main.php?msg="+a;
		</script>
		
		

		
