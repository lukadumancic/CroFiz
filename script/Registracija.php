<?php
	include "Funkcije.php";
	session_start();
				
				if(isset($_POST["ime"])){
					$_SESSION["imeReg"]=$_POST["ime"];
				}
				if(isset($_POST["prezime"])){
					$_SESSION["prezimeReg"]=$_POST["prezime"];
				}
				if(isset($_POST["email"])){
					$_SESSION["emailReg"]=$_POST["email"];
				}
				if(isset($_POST["nick"])){
					$_SESSION["nickReg"]=$_POST["nick"];
				}

				//Ovo se izvršava već prilikom otvaranja stranice, stoga je potrebno koristiti isset, osim toga, isset će služiti za provjeru jesu li sva polja ispunjena
				//Provjera jesu li unesena polja
				if (isset($_POST["ime"]) && isset($_POST["prezime"]) && isset($_POST["email"]) && isset($_POST["nick"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && $_POST["pass2"] == $_POST["pass"]){
					
					//Dodatna provjera unosa
						if(strpos($_POST["nick"],' ') == false and strpos($_POST["nick"],'<') == false and strpos($_POST["nick"],'>') == false and strpos($_POST["ime"],'<') == false and strpos($_POST["ime"],'>') == false and strpos($_POST["prezime"],'<') == false and strpos($_POST["prezime"],'>')==false){
							if(strlen($_POST["nick"])<4){
								$_SESSION['poruka']= "Prekratak nick";
							}
							else if(strlen($_POST["pass"])<6){
								$_SESSION['poruka']="Prekratka lozinka: minimalno 6 znakova";
							}
							else{
								$conn=conn();

								//Stvaranje varijabli potrebnih za unos u bazu podataka
								$Ime=$_POST["ime"];
								$Prezime=$_POST["prezime"];
								$Nick=$_POST["nick"];
								$Pass=$_POST["pass"];
								
								
								//Heširanje passworda
								$Pass=hash("md5",$Pass);
								
								
								
								$Email=$_POST["email"];
								
								//Provjera postoji li neki korisnik s istim nickom ili emailom
								$sql="SELECT * from korisnici where nick='".$Nick."' or email='".$Email."'";
								$sql2="SELECT * from privremeniKorisnici where nick='".$Nick."' or email='".$Email."'";
								//Dohvaćanje rezultata
								$rezultat=$conn->query($sql);
								$rezultat2=$conn->query($sql2);
								//Provjera postoji li account
								//Ako ne postoji
								if($rezultat->num_rows === 0 and $rezultat2->num_rows === 0){

									//Querry
									$sql="INSERT INTO privremeniKorisnici (`br`, `ime`, `prezime`,`nick`,`pass`, `email`,`obrazovanje` , `kod`) VALUES (0 , '".$Ime."', '".$Prezime."', '".$Nick."', '".$Pass."', '".$Email. "', '".$_POST["obrazovanje"]."', '".napraviKod(). "')";


									// "$conn->query($sql)" unosi u bazu i ako vrati FALSE postoji error
									if ($conn->query($sql) === FALSE) {
										echo $conn->error;  
									}
									//Ako je sve u redu vrati se poruka
									else{
										$_SESSION['poruka']="Provjerite svoj email";
									}

									//Zatvaranje veze
									$conn->close();
								}
								//Ako postoji
								else{
									$conn->close();
									$_SESSION['poruka']="Korisničko ime ili email već je u upotrebi";
								}
							}
						}
						else{
							$_SESSION['poruka']="Zabranjeno koristenje znakova < , > i razmaka";
						}
					
					

				}

			header("Location: http://34.121.205.40/Main.php");
			die();
			
			//Funkcija koja kriptira zadani string
			function kriptiranje($str){
				$z="";
				for($i=0;$i<strlen($str);$i++){
					$z.=chr(ord($str[$i])+1);
				}
				return $z;
			}
			//Funkcija koja pravi kod
			function napraviKod(){
				$z="";
				for($i=0;$i<10;$i++){
					$z.=chr(rand(65,91));
				}
				return $z;
			}
		?>