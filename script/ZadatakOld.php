<!doctype html>
<?php include 'session.php';?>

<script type='text/javascript'>
	a="<?php if(!isset($_GET['id'])){echo '2';}?>"
	if(a=="2"){
		window.location="http://crofiz.com/Zadaci.php";
	}
</script>

<?php include 'prijavaScript.php'; ?>


<html>
	<head>
		<?php include 'head.php';?>
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
					Zadatak
				</div>
				<div class='opis' >
					Pokušaj rješiti zadatak na papiru i onda unesi rješenje!<br>
					Običan zadatak nosi 10, dnevni 20, a tjedni čak 50 XP-a!
				</div>
				<?php include 'opisPosla.php'; ?>
			</div>
			<div style='margin-bottom: 15px;margin-top: -35px;'>
				<h2 style="display: inline;font-size:35px;"><?php echo imeZadatka(); ?></h2>
				<a title='Forum'><img src='Slicice/upitnik.jpg' style='width: 45px;display: inline;margin: 10px;position: relative;bottom: -17px;' onclick='prikaziTemu()'></a>
			</div>
			<div class='zadatakZadatak'>
				<?php echo zadatak(); ?>
				<?php if(prijavljen()){
					if(unosPokusaja()){
						echo "<p style=''>".dohvatiPosljednjiPokusaj()."</p>";
					}
				}?>
				<form style='display: inline-block;margin-bottom: 20px;margin-top: 10px;' method='post' action='ProvjeriRjesenje.php'>
					<input type='number' name='unesenoRjesenje' placeholder='Rješenje' required>
					<?php $_SESSION['idZadatak']=$_GET["id"]; ?>
					<?php if(prijavljen()=="True"){
						if(zadatakDana()){$_SESSION['zadatakDana']='1';}
						else if(tjedniIzazov()){$_SESSION['zadatakDana']='2';}
						else{$_SESSION['zadatakDana']="0";}}
						?>
					<input type='submit' value='Provjeri!'>
				</form>
			</div>
			
			<?php include 'ocjenaZadatka.php'; ?>
			
			<script>
				function prikaziTemu(){
					window.location='Tema.php?id=<?php echo $_GET["id"] ?>';
				}
			</script>
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
			function imeZadatka(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql="select ime from zadaci where id='".$_GET['id']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["ime"];
				
			}
			function zadatak(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql="select * from zadaci where id='".$_GET['id']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				$ret="";
				$ret.="Područje zadatka: ".$row["podrucje"]."<br>";
				$ret.="Razred: ".$row["razred"]."<br>";
				$ret.="<p class='tekst'>".$row["tekst"]."</p><br>";
				if($row["slika"]=='1'){
					$ret.="<img style='width:200px;' src='Slike/Zadatak".$_GET['id'].".jpg'><br>";
				}
				$ret.="Mjernja jedinica: ".$row["jedinica"]."<br>";
				return $ret;
			}

			function getId($nick){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql="select id from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["id"];
			}
			function zadatakDana(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$id=getId($_SESSION["korisnickoIme"]);
				
				$sql="select `obrazovanje` from korisnici where id='".$id."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
					$sql="select id from zadaci where razred=".$row["obrazovanje"]." and br='1' order by datum desc limit 1 ";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$conn->close();
					if($row["id"]==$_GET["id"]){
						return True;
					}
					else{
						return False;
					}
				}
				else{
					return False;
				}
			}
			function tjedniIzazov(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$id=getId($_SESSION["korisnickoIme"]);
				
				$sql="select `obrazovanje` from korisnici where id='".$id."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
					$sql="select id from zadaci where razred=".$row["obrazovanje"]." and br='2' order by datum desc limit 1 ";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$conn->close();
					if($row["id"]==$_GET["id"]){
						return True;
					}
					else{
						return False;
					}
				}
				else{
					return False;
				}
			}
			function dohvatiPosljednjiPokusaj(){
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
				$sql="SELECT * from pokusaji where idzadatak='".$_GET["id"]."' and idkorisnik='".getId($_SESSION["korisnickoIme"])."'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				if($row["tocnost"]=="1"){
					return "Već ste odgovorili točno na ovaj zadatak <br>".obradiDatum($row["datum"]);
				}
				else if($row["tocnost"]=="-1"){
					return "";
				}
				else{
					return "Odgovorili ste netočno na ovaj zadatak <br>".obradiDatum($row["datum"]);
				}
				$conn->close();
			}
			function unosPokusaja(){
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
				$sql="SELECT * from pokusaji where idzadatak='".$_GET["id"]."' and idkorisnik='".getId($_SESSION["korisnickoIme"])."'";

				$rezultat=$conn->query($sql);
				if($rezultat->num_rows === 0){
					$sql="INSERT INTO `pokusaji` (`idzadatak`, `idkorisnik`, `tocnost`) VALUES ('".$_GET["id"]."', '".getId($_SESSION["korisnickoIme"])."', '-1')";
					$conn->query($sql);
					$conn->close();
					return False;
				}
				$conn->close();
				return True;
			}
		?>
	</body>
</html>