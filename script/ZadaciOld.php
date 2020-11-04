<!doctype html>
<?php include 'session.php';?>
<?php include 'prijavaScript.php'; ?>



<html>
	<head>
		<?php include 'head.php';?>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	</head>
	<body>
		<?php include 'regBoxes.php';?>
		<?php include 'navigacija.php';?>
		
		
		
		
		<article>
			<!--<div class='opisPosla'>
				<div class='naslov'>
					Zadaci
				</div>
				<div class='opis' >
					Zadaci nude učenicima različite načine rješavanja zadataka:
					<ul style='text-align:left;'>
						<li>
							<strong>Dnevni zadaci</strong> se svakoga dana u <strong>podne</strong> prema Hrvatskome vremenu zamjene novim zadacima. Tako su učenici uvijek u mogućnosti rješavati nove zadatke. Dnevni zadaci su uvijek onoga gradiva koje učenici trenutno uče!
						</li>
						<li>
							<strong>Tjedni izazov</strong> je zadatak koji se mijenja na tjednoj bazi i nije ga lako riješiti bez malo dubljeg promišljanja!
						</li>
						<li>
							<strong>Mentorski zadaci</strong> su zadaci namjenjeni profesorima koji žele provjeriti znanje svojih učenika. Profesor stvara 'ispit' za učenike, učenici ga rješavaju.
						</li>
						<li>
							<strong>Arhiva</strong> je mjesto za one koji žele još!
						</li>
					</ul>
				</div>
				<?php>// include 'opisPosla.php'; ?>
			</div>-->
			
			<div id="extraNavigation">
				<div class='extraNavDiv' id='extraNavDnevni'>
					<a class='extraNavLink' href="?br=Dnevni">Dnevni</a>
				</div>
				<div class='extraNavDiv' id='extraNavTjedni'>
					<a class='extraNavLink' href="?br=Tjedni">Tjedni</a>
				</div>
				<div class='extraNavDiv' id='extraNavMentorski'>
					<a class='extraNavLink' href="?br=Mentorski">Mentorski</a>
				</div>
				<div class='extraNavDiv' id='extraNavArhiva'>
					<a class='extraNavLink' href="?br=Arhiva">Arhiva</a>
				</div>
			</div>
			
			
			<script>
				function prikaziDnevne(){
					document.getElementById("dnevni").style.display="block";
					document.getElementById("mentorski").style.display="none";
					document.getElementById("arhiva").style.display="none";
					document.getElementById("tjedni").style.display="none";
					
					
				}
				function prikaziTjedni(){
					document.getElementById("dnevni").style.display="none";
					document.getElementById("mentorski").style.display="none";
					document.getElementById("arhiva").style.display="none";
					document.getElementById("tjedni").style.display="block";
					
				}
				function prikaziMentorske(){
					document.getElementById("mentorski").style.display="block";
					document.getElementById("dnevni").style.display="none";
					document.getElementById("arhiva").style.display="none";
					document.getElementById("tjedni").style.display="none";
					
				}
				function prikaziArhivu(){
					document.getElementById("arhiva").style.display="block";
					document.getElementById("mentorski").style.display="none";
					document.getElementById("dnevni").style.display="none";
					document.getElementById("tjedni").style.display="none";
					
				}
			</script>
			
			<div id="dnevni" class="divZadaci" style="display:none;">
				<p class="odabrano" style="display:inline">Dnevni zadaci</p>
				<br><button style="font-size: 20px;height: 45px;width: 130px;font-family: serif;" class="navbutton" type="button" onClick="prikaziRankListu()">Rank Lista</button>
				<script>
					function prikaziRankListu(){window.location='http://34.121.205.40/RankLista.php';}
				</script>
				<div class="ispisZadataka">
					<?php
						if(ispisiDnevni()){
							echo "<p style='margin-bottom: -25px;font-size: 25px;font-family: serif;'>Današnji dnevni zadatak</p><br>".ispisiDnevni();
						}
						else{
							echo "<p style='margin-bottom: -25px;font-size: 25px;font-family: serif;'>Današnji dnevni zadaci</p><br>".ispisiSveDnevne();
						}
					?>
				</div>
				<div class="tjedan">
					
					<?php
					if(ispisiDnevni()){
						echo "<p style='margin-bottom: -8px;font-size: 20px;font-family: serif;'>Protekli tjedan</p><br>";
						echo ispisiTjedan();
						echo "<br>";
					}
					?>
				</div>
			</div>
			
			<div id="tjedni" class="divZadaci" style="display:none;">
				<p class="odabrano" style="display:inline">Tjedni izazov</p>
				<br><button style="font-size: 20px;height: 45px;width: 130px;font-family: serif;" class="navbutton" type="button" onClick="prikaziRankListu2()">Rank Lista</button>
				<script>
					function prikaziRankListu2(){window.location='http://34.121.205.40/RankLista2.php';}
				</script>
				<div class="ispisZadataka">
					<?php
						if(ispisiTjedni()){
							echo "<p style='margin-bottom: -8px;font-size: 25px;font-family: serif;'>Ovotjedni izazov</p><br>".ispisiTjedni();
						}
						else{
							echo "<p style='margin-bottom: -8px;font-size: 25px;font-family: serif;'>Ovotjedni izazovi</p><br>".ispisiSveTjedne();
						}
					?>
				</div>
				<br>
			</div>
			
			<div id="mentorski" class="divZadaci" style="display:none;">
				<p class="odabrano" style="display:inline">Mentorski zadaci</p><br>
				<?php
					if(prijavljen()=="True"){
						if(profesor()){
							echo '____________________________________________________';
							include 'noviIzazov.php';
							echo '____________________________________________________';
						}
						echo ispisMentorskih();
					}
					else{
						echo "<strong>Prijavite se kako biste mogli vidjeti!</strong>";
					}
				?>
				
			</div>
			<div id="arhiva" class="divZadaci" style="display:none;">
				<p class="odabrano" style="display:inline">Arhiva zadataka</p><br>
				<div id="navRazredi"></div>
				<br>
				<?php
					for($i=1;$i<=4;$i++){
						echo "<div class='arhiva' id='arhiva$i' style='display:none;'>";
						echo "<div id='navigacijaArhiva$i' style='position: absolute;left: 27%;display:inline-block;margin-right:50px;'><strong>Lekcije</strong><br></div>";
						echo "<div id='zadaciArhiva$i' style='display:inline-block;'><strong>Zadaci</strong><br></div>";
						echo "</div>";
						dohvatiPodrucja($i);
					}
				?>
				<script>
					for (i=1;i<=4;i++){
						document.getElementById("navRazredi").innerHTML+="<button style='width: 120px;' class='navZadaci' id='razred"+i+"' onClick='prikaziRazred("+i+")'>"+i+". razred</button>";
					}
					function prikaziRazred(x){
						for(i=1;i<=4;i++){
							document.getElementById("arhiva"+i).style.display="none";
						}
						document.getElementById("arhiva"+x).style.display="block";
					}
					prikaziRazred(1);
					var arh="0";
					function prikaziArhivuZad(p){
						p=p.toString();
						if(arh==0){
							arh=p;
						}
						else{
							document.getElementById(arh).style.display="none";
							arh=p;
						}
						document.getElementById(p).style.display="block";
					}
				</script>
				
			</div>
			
			<script>
				a="<?php if(isset($_GET["br"])){echo $_GET["br"];}?>";
				if(a=="Dnevni"){prikaziDnevne();}
				if(a=="Mentorski"){prikaziMentorske();}
				if(a=="Arhiva"){prikaziArhivu();}
				if(a=="Tjedni"){prikaziTjedni();}
				if(a!=""){
					document.getElementById("extraNav"+a).className+=" extraNavSelected";
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
			function ispisiDnevni(){
				if(prijavljen()=="True"){
					$id=getId($_SESSION["korisnickoIme"]);
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
					
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
						$sql="select * from zadaci where razred='".$row["obrazovanje"]."' and br='1' order by datum desc limit 1";
						$rez=$conn->query($sql);
						$row=$rez->fetch_assoc();
						$conn->close();
						return "<a style='font-size:40px;' class='zadatak' href='http://34.121.205.40/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a>";
					}
					else{
						$conn->close();
						return False;
					}
				}
				else{
					return False;
				}
			}
			function ispisiTjedni(){
				if(prijavljen()=="True"){
					$id=getId($_SESSION["korisnickoIme"]);
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
					
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
						$sql="select * from zadaci where razred='".$row["obrazovanje"]."' and br='2' order by datum desc limit 1";
						$rez=$conn->query($sql);
						$row=$rez->fetch_assoc();
						$conn->close();
						return "<a style='font-size:40px;' class='zadatak' href='http://34.121.205.40/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a>";
					}
					else{
						$conn->close();
						return False;
					}
				}
				else{
					return False;
				}
			}
			function ispisiSveDnevne(){
					$id=getId($_SESSION["korisnickoIme"]);
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
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					
					$ret="";
					for($i=1;$i<5;$i++){
						$sql="select * from zadaci where razred='$i' and br='1' order by datum desc limit 1";
						$rez=$conn->query($sql);
						while($row=$rez->fetch_assoc()){
							$ret.="<p style='font-size:25px;font-family: serif;' >Dnevni zadatak za $i. razred</p><a style='font-size:40px;' class='zadatak' href='http://34.121.205.40/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a><br>";
						}
					}
					$conn->close();
					return $ret;
			
				}
			function ispisiSveTjedne(){
					$id=getId($_SESSION["korisnickoIme"]);
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
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					
					$ret="";
					for($i=1;$i<5;$i++){
						$sql="select * from zadaci where razred='$i' and br='2' order by datum desc limit 1";
						$rez=$conn->query($sql);
						while($row=$rez->fetch_assoc()){
							$ret.="<p style='font-size:25px;font-family: serif;' >Tjedni zadatak za $i. razred</p><a style='font-size:40px;' class='zadatak' href='http://34.121.205.40/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a><br>";
						}
					}
					$conn->close();
					return $ret;
			
				}
			function ispisiTjedan(){
				if(prijavljen()=="True"){
					$id=getId($_SESSION["korisnickoIme"]);
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
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
						$sql="select * from zadaci where br='1' and razred='".$row["obrazovanje"]."' order by datum desc limit 7";
						$rez=$conn->query($sql);
						$ret="";
						while($row=$rez->fetch_assoc()){
							$ret.="<p class='dan'>".$row["dan"]."  <a class='zadatak' href='http://34.121.205.40/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
						}
						$conn->close();
						
						return $ret;
					}
					else{
						$conn->close();
						return False;
					}
				}
				else{
					return False;
				}
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
			function profesor(){
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
				$nick=$_SESSION["korisnickoIme"];
				$sql="select obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function dohvatiGrupe(){
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
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select id,ime from grupe where mentorid=$mojId";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					$conn->close();
					return "Nemate grupa za odabir";
				}
				else{
					$ret="<select name='odabrano'>";
					while($row=$rez->fetch_assoc()){
						$ret.='<option value="'.$row['id'].'">'.$row['ime'].'<br>';
					}
					$ret.="</select>";
					$conn->close();
					return $ret;
				}
			}
			function ispisMentorskih(){
				if(prijavljen()=="True"){
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
					$mojId=getId($_SESSION["korisnickoIme"]);
					$sql="select mentorid from korisnici where id=$mojId and (mentorid is not null or obrazovanje='Profesor')";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						$conn->close();
						return "Nemate mentora";
					}
					else{
						$ret="<p style='font-size:25px;margin-bottom: 0px;'>Grupe</p>";
						$row=$rez->fetch_assoc();
						$mentorId=$row["mentorid"];
						if($mentorId==""){
							$mentorId=$mojId;
						}
						if(profesor()){
							$sql="select * from grupe where mentorid=$mentorId";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								$ret.="Nemate grupe";
							}
							else{
								while($row=$rez->fetch_assoc()){
									$ret.="<br><a class='grupa' href='http://34.121.205.40/Grupa.php?id=".$row["id"]."'>".$row['ime']."</a><br>Izazovi:";
									$sql="select ime,id from izazovi where trajanje='1' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows===0){
										$ret.="<br>Nema izazova";
									}
									else{
										while($row2=$rez2->fetch_assoc()){
											$ret.="<br><a class='izazov' href='http://34.121.205.40/Izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a>";
											$ret.="<form style='display:inline;' method='post' action='zaustaviIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input style='border: 1px solid red;background-color: red;' type='submit' value='Zaustavi'></form>";
											$ret.="<form style='display:inline;' method='post' action='obrisiIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input type='submit' value='Obriši'></form>";
										}
									}
									$ret.="<br>";
									$sql="select ime,id from izazovi where trajanje='0' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows!=0){
										$ret.="<br>Završeni izazovi:";
										while($row2=$rez2->fetch_assoc()){
											$ret.="<br><a class='izazov' href='http://34.121.205.40/Izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a>";
											$ret.="<form style='display:inline;' method='post' action='zaustaviIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input style='border: 1px solid green;background-color: green;' type='submit' value='Pokreni'></form>";
											$ret.="<form style='display:inline;' method='post' action='obrisiIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input type='submit' value='Obriši'></form>";
										}
									}
								}
							}
						}
						if(!profesor()){
							$sql="select * from grupe where idkor like '|$mojId|' or idkor like '|$mojId|%' or idkor like '%|$mojId|' or idkor like '%|$mojId|%' or (mentorid=$mentorId and idkor='-1')";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								$ret.="Nemate grupe";
							}
							else{
								while($row=$rez->fetch_assoc()){
									$ret.="<br><a class='grupa' href='http://34.121.205.40/Grupa.php?id=".$row["id"]."'>".$row['ime']."</a><br>Izazovi:";
									$sql="select ime,id from izazovi where trajanje='1' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows===0){
										$ret.="<br>Nema izazova";
									}
									else{
										while($row2=$rez2->fetch_assoc()){
											$ret.="<br><a class='izazov' href='http://34.121.205.40/izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a>";
										}
									}
									$sql="select ime,id from izazovi where trajanje='0' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows!=0){
										$ret.="<br>Završeni izazovi:";
										while($row2=$rez2->fetch_assoc()){
											$ret.="<br><a class='izazov' href='http://34.121.205.40/Izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a>";
										}
									}
								}
							}
						}
						$conn->close();
						return $ret;
						
					}
				}
			}
			function dohvatiSveZadatke($razred,$podrucje){
				$id=getId($_SESSION["korisnickoIme"]);
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
						$sql="select id,ime from zadaci where razred='$razred' and podrucje='$podrucje' order by datum desc";
						$rez=$conn->query($sql);
						$ret="";
						while($row=$rez->fetch_assoc()){
							$ret.="<a class='zadatak' href='http://34.121.205.40/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
						}
						$conn->close();
						
						return $ret;
			}
			function dohvatiPodrucja($razred){
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
					$sql="select podrucje from zadaci where razred=$razred";
					$rez=$conn->query($sql);
					if($rez->num_rows>0){
						$l=[];
						while($row=$rez->fetch_assoc()){
							if(!in_array($row["podrucje"],$l)){
								array_push($l,$row["podrucje"]);
							}
						}
						echo "<script>";
						for($i=0;$i<count($l);$i++){
							echo "document.getElementById('navigacijaArhiva$razred').innerHTML+='<button class=\"podrucje\" type=\"button\" onClick=\"prikaziArhivuZad(\'".$l[$i]."\')\">".$l[$i]."</button><br>';";
							unesiArhivu($razred,$l[$i]);
						}
						echo "</script>";
					}
			}
			function unesiArhivu($razred,$podrucje){
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
					
					$sql="select * from zadaci where podrucje='$podrucje'";
					$rez=$conn->query($sql);
					echo "document.getElementById('zadaciArhiva$razred').innerHTML+='<div style=\"display:none;\" id=\"$podrucje\"></div>';";
					while($row=$rez->fetch_assoc()){
						echo "document.getElementById('$podrucje').innerHTML+='<a class=\"zadatak\" href=\"http://34.121.205.40/Zadatak.php?id=".$row["id"]."\">".$row["ime"]."</a><br>';";
					}
			}
		?>
	</body>
</html>