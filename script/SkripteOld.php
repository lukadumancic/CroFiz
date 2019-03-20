<html>
	<body>
	
		<head>
	
			<link rel="stylesheet" type="text/css" href="Style.css" />
			<title>CRO FIZ</title>
	
		</head>

		<script>
		
			//Postavke na početku
			a="<?php
			session_start();
			if (isset($_SESSION["korisnickoIme"])){
				if ($_SESSION["korisnickoIme"]==="*%test%*"){
					echo "1";
				}
			}
			else{
				echo "1";
			}
			?>";
			if (a=="1"){
				window.location = 'http://hugeiceberg.ddns.net/WebPage/Main.php';
		
			}
		</script>

		
		
		
		
		<!-- Gumb koji vraća na naslovnu -->
		<button type="button" onClick="vratiNaNaslovnu()">Naslovna</button>
		
		<script>
			function vratiNaNaslovnu(){
				window.location = 'http://hugeiceberg.ddns.net/WebPage/Naslovna.php';
			}
		</script>
		
		<!-- Prostor ispisa -->
		<section>
			<p id="parUnos"></p>
			<p id="par"></p>
			<p id="prikaz"></p>
		</section>
		<aside>
			<button type="button" onClick="skripteMentor()">Mentor</button>
			<p id="parOdabir"></p>
		</aside>
		
		<!-- Funkcije koje moraju biti na početku -->
		
		<script>
			a="<?php
			//Ispis skripte
				if(isset($_POST["id"])){

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
					$sql="select type from skripte where id='".$_POST["id"]."'";
					$rezultat=$conn->query($sql);
					$row=$rezultat->fetch_assoc();
					//Ako je slika
					if(strpos($row["type"],"mage")){
						echo "<textarea class='slika' style='background-image:url(http://hugeiceberg.ddns.net/WebPage/Slike/".$_POST["id"].".jpg);' ></textarea>";
					}
					else if(strpos($row["type"],"/pdf")){
						echo "1";
					}
					else{
						echo "2";
					}
				}	
			?>";
			if(a!="1" && a!="2"){
				document.getElementById("prikaz").innerHTML=a;
			}
			else if(a=="1"){
				window.open("http://hugeiceberg.ddns.net/WebPage/Dokumenti/<?php if(isset($_POST["id"])){echo $_POST["id"];} ?>.pdf");
			}
			else{
				window.open("http://hugeiceberg.ddns.net/WebPage/Dokumenti/<?php if(isset($_POST["id"])){echo $_POST["id"];} ?>.docx");
			}
			
			//Ispis svih skripti Mentora
			function skripteMentor(){
				document.getElementById("parOdabir").innerHTML="<?php 
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
					$sql="select id,name,type,idkorisnik from skripte where idkorisnik='".idMentor()."'";
					$rezultat=$conn->query($sql);
					while($row=$rezultat->fetch_assoc()){
						echo "<form method='post'><input type='hidden' name='id' value='".$row['id']."'><input type='submit' value='Prikaži ".$row["name"]." ".$row["type"]." by: ".getIme($row["idkorisnik"])."'></form>";
					}
					$conn->close();
				?>";
			}
		</script>
		
		
		
		<script>
			//TODO:
			if(<?php echo True; ?>){
				document.getElementById("parUnos").innerHTML='<?php echo '<form method="post" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="20000000"><input name="userfile" type="file" id="userfile"><input type="checkbox" value="svi">Svi<br>';
				
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
				$sql="select id,ime from grupe where mentorid='".idMentor()."'";
				$rezultat=$conn->query($sql);
				while($row=$rezultat->fetch_assoc()){
					echo '<input type="checkbox" value="'.$row["id"].'">'.$row["ime"].'<br>';
				}
				echo '<input name="upload" type="submit" id="upload" value=" Upload "></form>';
				?>';
			}
		</script>
		
		<?php
			//Upload skripte
			if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
				$fileName = $_FILES['userfile']['name'];
				$tmpName  = $_FILES['userfile']['tmp_name'];
				$fileSize = $_FILES['userfile']['size'];
				$fileType = $_FILES['userfile']['type'];
				
				
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
				//Ako je slika
				if(strpos($fileType,"mage")){
					$data= addslashes($_FILES['userfile']['tmp_name']);
					$name= addslashes($_FILES['userfile']['name']);
					$data= file_get_contents($data);
					$data= base64_encode($data);
					$sql="INSERT INTO skripte (name, size, type, content ,idkorisnik, br) ".
					"VALUES ('$fileName', '$fileSize', '$fileType', '$data', '".getId($_SESSION["korisnickoIme"])."','0')";
					$conn->query($sql);
				}
				else{
					
					$fp      = fopen($tmpName, 'r');
					$content = fread($fp, filesize($tmpName));
					$content = addslashes($content);
					fclose($fp);
					
					if(!get_magic_quotes_gpc()){
						$fileName = addslashes($fileName);
					}
					$sql="INSERT INTO skripte (name, size, type, content ,idkorisnik,br) ".
					"VALUES ('$fileName', '$fileSize', '$fileType', '$content', '".getId($_SESSION["korisnickoIme"])."','0')";
					$conn->query($sql);
				}
				$conn->close();
			}
		?>
		
		<script>
			document.getElementById("par").innerHTML="<?php
				
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
				$sql="select id,name,type,idkorisnik from skripte";
				$rezultat=$conn->query($sql);
				while($row=$rezultat->fetch_assoc()){
					echo "<form method='post'><input type='hidden' name='id' value='".$row['id']."'><input type='submit' value='Prikaži ".$row["name"]." ".$row["type"]." by: ".getIme($row["idkorisnik"])."'></form>";
				}
				$conn->close();
			?>";
			
		</script>
		
		
		<!-- Dodatne funkcije -->
		<?php 
			//Funkcija vraća ljepši zapis datuma nego li je zapisan u bazi podataka
			function obradiDatum($str){
				$array=explode(' ',$str);
				$dateArray=explode('-',$array[0]);
				$timeArray=explode('.',$array[1]);
				return $dateArray[2]."-".$dateArray[1]."-".$dateArray[0]." ".$timeArray[0];
			}
			//TODO: ova funkcija ne dozvoljava pisanje znakova < i > i " , jer postoji mogućnost da se promjeni čitav html
			function promjeniZnakove($str){
				$znakovi = array('"');
				$str=str_replace($znakovi,'\\\\"', $str);
				$znakovi = array("'");
				return str_replace($znakovi,"\\\\'", $str);
			}
			//Dohvaćanje id-a korisnika
			function getId($nick){
				$servername = "hugeiceberg.ddns.net";
				$username = "admin";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn2 = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn2->connect_error) {
					die("Connection failed: " . $conn2->connect_error);
				}
				$sql="select id from korisnici where nick='".$nick."'";
				$rez=$conn2->query($sql);
				$row=$rez->fetch_assoc();
				$conn2->close();
				return $row["id"];
			}
			function getObrazovanje($nick){
				$id=getId($_SESSION["korisnickoIme"]);
				$servername = "hugeiceberg.ddns.net";
				$username = "admin";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn2 = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn2->connect_error) {
					die("Connection failed: " . $conn2->connect_error);
				}
				$sql="select `obrazovanje` from korisnici where id='".$id."'";
				$rez=$conn2->query($sql);
				$row=$rez->fetch_assoc();
				$conn2->close();
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function getIme($id){
				$servername = "hugeiceberg.ddns.net";
				$username = "admin";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn2 = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn2->connect_error) {
					die("Connection failed: " . $conn2->connect_error);
				}
				$sql="select ime,prezime from korisnici where id='".$id."'";
				$rez=$conn2->query($sql);
				$row=$rez->fetch_assoc();
				$conn2->close();
				return $row["ime"].' '.$row["prezime"];
			}
			function idMentor(){
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
				$sql="select mentorid from korisnici where id='".getId($_SESSION['korisnickoIme'])."'";
				$rezultat=$conn->query($sql);
				while($row=$rezultat->fetch_assoc()){
					return $row["mentorid"];
				}
				return getId($_SESSION['korisnickoIme']);
				
			}

		?>
		
		
	<body>
</html>