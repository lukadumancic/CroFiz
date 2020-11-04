<!doctype html>
<?php include 'session.php';?>
<script type='text/javascript'>
	//Ako postoji msg alert u linku stranice
	<?php
		if(isset($_GET["msg"])){
			echo 'alert(\''.$_GET["msg"].'\');';
		}
	?>
	a="<?php
	//Prijava korisnika
		if(isset($_POST["nickPrijava"]) && isset($_POST["passPrijava"])){

		//Postavljanje varijabli za spajanje na bazu
		$servername = "35.238.67.22";
		$username = "root";
		$password = "124578";
		$dbname = "crofiz";

		// Stvaranje veze
		$conn = new mysqli($servername, $username, $password, $dbname);


		//Stvaranje varijabli potrebnih za unos u bazu podataka
		$Pass=$_POST["passPrijava"];
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
			echo "1";
		}

		//Ako ne postoji account
		else{
			echo "0";
		}

		$conn->close();

		}
		else{
			echo "1";
		}

	?>";
	if(a=="0"){
		alert("Kriva lozinka");
	}
</script>



<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		<!-- title ide u head -->
		<title>CROFIZ</title>
	</head>
	<body onload = "pokreni()">
		<script>
			//Pokreće zadane funkcije onload
			function pokreni(){
				startTime();
			}
		</script>
		<?php include 'regBoxes.php';?>
		<?php include 'navigacija.php';?>
		
		
		<article>
			<div class='opisPosla'>
				<div class='naslov'>
					Rank Lista - Tjedni izazov
				</div>
				<div class='opis'>
					Najbolji su oni koji su najuporniji!
				</div>
				<?php include 'opisPosla.php'; ?>
			</div>
			<button class="rankListaNav" onClick="prikazi(1)">1. razred</button>
			<button class="rankListaNav" onClick="prikazi(2)">2. razred</button>
			<button class="rankListaNav" onClick="prikazi(3)">3. razred</button>
			<button class="rankListaNav" onClick="prikazi(4)">4. razred</button>
			
			<script>
				function prikazi(x){
					for(i=1;i<=4;i++){
						document.getElementById("a"+i).style.display="none";
					}
					document.getElementById("a"+x).style.display="block";
				}
			</script>
			<div id="a1" class="divZadaci" style="display:block;">
				<h2>1. razred</h2>
				<?php echo ranking(1); ?>
			</div>
			<div id="a2" class="divZadaci" style="display:none;">
				<h2>2. razred</h2>
				<?php echo ranking(2); ?>
			</div>
			<div id="a3" class="divZadaci" style="display:none;">
				<h2>3. razred</h2>
				<?php echo ranking(3); ?>
			</div>
			<div id="a4" class="divZadaci" style="display:none;">
				<h2>4. razred</h2>
				<?php echo ranking(4); ?>
			</div>
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<!-- Dodatne php funkcije -->
		<?php
			//Funkcija koja određuje jeli osoba prijavljena ili nije
			function prijavljen(){
				if($_SESSION["korisnickoIme"]=="*%test%*" and $_SESSION["zaporka"]=="*%test%*"){
					return "False";
				}
				else{
					return "True";
				}
			}
			function obradiDatum($str){
				$array=explode(' ',$str);
				$dateArray=explode('-',$array[0]);
				$timeArray=explode('.',$array[1]);
				return $dateArray[2]."-".$dateArray[1]."-".$dateArray[0]." ".$timeArray[0];
			}
			function ranking($razred){
				$servername = "35.238.67.22";
					$username = "root";
					$password = "124578";
					$dbname2 = "crofiz";

					// Stvaranje veze
					$conn2 = new mysqli($servername, $username, $password, $dbname2);
					// Provjera veze
					if ($conn2->connect_error) {
						die("Connection failed: " . $conn2->connect_error);
					}
					$sql="select * from ranklista2 where razred=$razred order by bodovi desc";
					$rez=$conn2->query($sql);
					$conn2->close();
					if($rez->num_rows===0){
						return "<strong>Nema rezultata</strong>";
					}
					else{
						$ret="";
						$rank=0;
						while($row=$rez->fetch_assoc()){
							$rank+=1;
							$ret.="<div style='margin-bottom:10px;'><p style='display:inline;'>".$rank."</p> ".infoKorisnik($row["idkorisnik"])." ".$row["bodovi"]."</div>";	
						}
						$ret.="<br>";
						return $ret;
					}
					
			}
			function infoKorisnik($id){
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
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a style='margin-left: 10px;' class='nick' href='http://34.121.205.40/Profil.php?nick=".$row["nick"]."'>".$row["ime"]." ".$row["prezime"]."</a>";
				
			}
		?>
	</body>
</html>