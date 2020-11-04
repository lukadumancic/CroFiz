
		<?php
			include 'Funkcije.php';
			include 'session.php';
			
				if(isset($_GET["kod"])){
					$conn=conn();
					//Query 
					$sql="SELECT * from privremeniKorisnici where kod='".$_GET["kod"]."'";
					//Dohvaćanje rezultata

					$rezultat=$conn->query($sql);
					if($rezultat->num_rows === 1){

						//Dohvaćanje reda
						$row = $rezultat->fetch_assoc();
						
						
						//Unos podataka u glavnu bazu korisnika
						$sql="INSERT INTO korisnici (`ime`, `prezime`,`nick`,`pass`,`obrazovanje`, `email`) VALUES ('".$row["ime"]."', '".$row["prezime"]."', '".$row["nick"]."', '".$row["pass"]."', '".$row["obrazovanje"]."', '".$row["email"]. "')";
						ubaciPocetno();
						$_SESSION["korisnickoIme"]=$row["nick"];
						$_SESSION["zaporka"]=$row["pass"];
						if ($conn->query($sql) === FALSE) {
								echo $conn->error;  
						}
						
						//Brisanje iz privremene baze korisnika
						$sql="DELETE FROM privremenikorisnici WHERE kod='".$_GET["kod"]."'";
						if ($conn->query($sql) === FALSE) {
								echo $conn->error;  
						}
						
						$conn->close();
					}
					else{
						$conn->close();
					}
						
				} 
			
				else{
				}
				header("Location: http://34.121.205.40/Postignuca.php");
				die();
			?>
		