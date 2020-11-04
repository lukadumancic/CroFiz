<?php
		if(isset($_POST["nickPrijava"]) && isset($_POST["passPrijava"])){
			$conn=conn();

			//Stvaranje varijabli potrebnih za unos u bazu podataka
			$Pass=$_POST["passPrijava"];
			$Pass=hash("md5",$Pass);
			$Nick=$_POST["nickPrijava"];

			//Query 
			$sql="SELECT * from korisnici where nick='".$Nick."' and pass='".$Pass."'";
			//Dohvaćanje rezultata
			$rezultat=$conn->query($sql);
			//Provjera postoji li account
			if($rezultat->num_rows === 1){
				$row = $rezultat->fetch_assoc();

				//Session varijable
				$_SESSION["korisnickoIme"]=$Nick;
				$_SESSION["zaporka"]=$Pass;
				
				$_SESSION["zabLoz"]=0;
			}

			//Ako ne postoji account
			else{
				$_SESSION["poruka"]="Kriva lozinka ili korisničko ime!";
				$_SESSION["zabLoz"]=1;
			}

			$conn->close();
			if(prijavljen()=="True"){
				$_SESSION["userId"]=getId($_SESSION["korisnickoIme"]);
			}
		}

	?>
