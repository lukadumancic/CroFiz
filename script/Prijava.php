
		<script>
			a="<?php
				if(isset($_POST["userOrPass"])){
					if($_POST["userOrPass"]!==""){
						//Postavljanje varijabli za spajanje na bazu
						$servername = "35.238.67.22";
						$username = "root";
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
			window.location="http://crofiz.com/Main.php?msg="+a;
		</script>
		
		

		
