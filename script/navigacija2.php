
		
		<div id="navigacija" class="navigacija">
			<header>
				<div class='crofiz'>CROFIZ</div>
				
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

			</header>
			<nav>
				<div id="nav" onmouseover='sakrijDodatak()'>
					
					<?php if(prijavljen()!=="True"){echo '<a class="navbutton" href="http://'. $_SESSION["host"].'">Početna</a>';} ?>
					<?php if(prijavljen()==="True"){echo '<a class="navbutton" href="http://'. $_SESSION["host"].'/Naslovna.php">Naslovna</a>';} ?>
					<?php if(prijavljen()==="True"){echo '<a class="navbutton" href="http://'. $_SESSION["host"].'/Profil.php?nick='. $_SESSION["korisnickoIme"] .'">Profil</a>';} ?>
					<?php if(prijavljen()==="True"){echo '<a class="navbutton" href="http://'. $_SESSION["host"].'/Grupe.php">Grupe</a>';} ?>
					<a class="navbutton" href='http://<?php echo $_SESSION["host"]?>/Zadaci.php'>Zadaci</a>
					<a class="navbutton" href='http://<?php echo $_SESSION["host"]?>/Forum.php'>Forum</a>
					<a class="navbutton" href='http://<?php echo $_SESSION["host"]?>/Skripte.php'>Skripte</a>
					<a class="navbutton" href='http://<?php echo $_SESSION["host"]?>/Simulacije.php'>Simulacije</a>
				
				<p></p>
				</div>

			</nav>
			<div id="logReg" >
					
					<?php 
						//Ako nitko nije prijavljen ispisuje se prostor za prijavu, inače ime korisnika i logout button
						if(prijavljen()==="False"){echo '
								<button type="button" class="prijavaButton" onClick="prikaziPrijavu()">Prijava</button>	
								<button type="button" class="registracijaButton" onClick="prikaziRegistraciju()">Registracija</button>			
						';}
						else{

							echo "<div class='dodaci'>";
							echo "<a onmouseover='prikaziPoruke()' href='Poruke.php' title='Poruke'><div class='brojPoruka'>".brojPoruka()."</div><img style='height: 40px;width: 40px;' src='Slicice/poruka.jpg'></a>";
							echo "<div id='poruke' style='display:none;' onmouseleave='sakrijPoruke()'>";
							echo "</div>";
							echo "</div>";
							
							echo "<div class='dodaci'>";
							echo "<a onmouseover='prikaziObavijesti()' class='nick2' title='Obavijesti'><div class='brojObavijesti'>".brojObavijesti()."</div><img alt style='height:40px;width:40px;' src='Slicice/notification.jpg'></a>";
							echo "<div id='obavijesti' style='display:none;' onmouseleave='sakrijObavijesti()'>";
							echo "</div>";
							echo "</div>";
							
							echo "<div class='dodaci'>";
							echo "<a onmouseover='prikaziDodatak()' class='nick2' href='http://34.121.205.40/Profil.php?nick=".$_SESSION["korisnickoIme"]."'>".mojaSlika()."</a>";
							echo "<div id='dodatak' style='display:none;' onmouseleave='sakrijDodatak()'>";
							echo "<a class='dodatak' href='http://". $_SESSION["host"]."/Postavke.php'>Postavke</a>";
							echo "<a class='dodatak' href='http://". $_SESSION["host"]."/PromjenaLozinke.php'>Promjena lozinke</a>";
							echo "<form class='dodatak' method='post' style='display:inline;'><input type='hidden' style='display:inline;bottom: 10px;position: absolute;'  name='logOut' value='1'><input class='odjavaGumb' type='submit' value='Odjava'></form>";
							echo "</div>";
							echo "</div>";
						}
					?>
					<script>
						function prikaziRegistraciju(){
							izlazY();
							document.getElementById("overlayy").style.display='block';
						}
						function prikaziZaboravljenu(){
							sakrijPrijavu();
							izlazX();
							document.getElementById("overlayx").style.display='block';
						}
						function prikaziPrijavu(){
							izlazZ();
							document.getElementById("overlayz").style.display='block';
						}
						
						
						function prikaziDodatak(){
							sakrijObavijesti();
							sakrijPoruke();
							document.getElementById("dodatak").style.display='block';
						}
						function sakrijDodatak(){
							if(!$('#dodatak').is(':hover')){
								document.getElementById("dodatak").style.display='none';
							}
						}
						
						function prikaziObavijesti(){
							obav();
							sakrijDodatak();
							sakrijPoruke();
							document.getElementById("obavijesti").style.display='block';
						}
						function sakrijObavijesti(){
							if(!$('#obavijesti').is(':hover')){
								document.getElementById("obavijesti").style.display='none';
							}
						}
						
						function prikaziPoruke(){
							por();
							sakrijDodatak();
							sakrijObavijesti()
							document.getElementById("poruke").style.display='block';
						}
						function sakrijPoruke(){
							if(!$('#poruke').is(':hover')){
								document.getElementById("poruke").style.display='none';
							}
						}
					</script>
				</div>
		</div>
		
		
		
		<script>
		//Posjecena stranica u navigaciji se oboji drugom bojom
		//css-> a.current
		$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == window.location.href) {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		<script>
			function obav()
				{
				var xmlhttp;    
				if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
					}
				else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
				xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						if(xmlhttp.responseText.indexOf("a")==-1){
							console.log("0");
						}
						else{
							document.getElementById("obavijesti").innerHTML=xmlhttp.responseText;
						}
						}
					  }
					  //x=0 oznacava max 10 obavijesti
				xmlhttp.open("GET","obavijesti.php?x=0",true);
				xmlhttp.send();
				}
			function por()
				{
				var xmlhttp;    
				if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
					}
				else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
				xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						if(xmlhttp.responseText.indexOf("a")==-1){
							console.log("0");
						}
						else{
							document.getElementById("poruke").innerHTML=xmlhttp.responseText;
						}
						}
					  }
				xmlhttp.open("GET","poruke2.php",true);
				xmlhttp.send();
				}
		</script>
		
		
		<?php
			function imena(){
				if(prijavljen()=="True"){
					$servername = "35.238.67.22";
					$username = "root";
					$password = "124578";
					$dbname = "crofiz";

					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
					}
					$sql="select ime,prezime,nick from korisnici";
					$rezultat=$conn->query($sql);
					while($row=$rezultat->fetch_assoc()){
						echo "'".$row["ime"]." ".$row["prezime"]."'";
						echo ",";
						echo "'".$row["nick"]."'";
						echo ",";
					}
					$conn->close();
				}
			}
			function imena2(){
				if(prijavljen()=="True"){
					$servername = "35.238.67.22";
					$username = "root";
					$password = "124578";
					$dbname = "crofiz";

					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
					}
					$sql="select ime,prezime,nick from korisnici";
					$rezultat=$conn->query($sql);
					while($row=$rezultat->fetch_assoc()){
						echo "'".$row["nick"]."'";
						echo ",";
					}
					$conn->close();
				}
			}
			function mojaSlika(){
				if(prijavljen()=="True"){
					$servername = "35.238.67.22";
					$username = "root";
					$password = "124578";
					$dbname = "crofiz";

					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
					}
					$sql="select id from korisnici where nick='".$_SESSION["korisnickoIme"]."'";
					$rezultat=$conn->query($sql);
					$row=$rezultat->fetch_assoc();
					$conn->close();
					return "<img alt style='height:40px;width:40px;' src='Slike\\Korisnik".$row['id'].".jpg'>";
					
				}
			}
			function brojObavijesti(){
				if(prijavljen()=="True"){
					$servername = "35.238.67.22";
					$username = "root";
					$password = "124578";
					$dbname = "crofiz";

					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
					}
					$sql="select obavijest from obavijesti where `idkorisnik`='".$_SESSION["userId"]."' and pogledano='0'";
					$rezultat=$conn->query($sql);
					$x=$rezultat->num_rows;
					if($x>=10){
						$x=9;
					}
					$conn->close();
					return $x;
				}
			}
			function brojPoruka(){
				if(prijavljen()=="True"){
					$servername = "35.238.67.22";
					$username = "root";
					$password = "124578";
					$dbname = "crofiz";

					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
					}
					$sql="select id from poruke where `primatelj`='".$_SESSION["userId"]."' and pogledano='0'";
					$rezultat=$conn->query($sql);
					$x=$rezultat->num_rows;
					if($x>=10){
						$x=9;
					}
					$conn->close();
					return $x;
				}
			}
			function level1(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql="select xp from informacije where idkorisnik='".$_SESSION['userId']."'";
				
				$rez=$conn->query($sql);
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=10;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=10*pow(2,$level);
					}
					return "Level ".$level;
				}
				$conn->close();
			}
			function level2(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql="select xp from informacije where idkorisnik='".$_SESSION['userId']."'";
				
				$rez=$conn->query($sql);
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=10;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=10*pow(2,$level);
					}
					return ($xp-$manja).'/'.($veca-$manja)." XP";
				}
				$conn->close();
			}
			function postotak(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql="select xp from informacije where idkorisnik='".$_SESSION['userId']."'";
				
				$rez=$conn->query($sql);
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=10;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=10*pow(2,$level);
					}
					return ($xp-$manja)/($veca-$manja)*100;
				}
				$conn->close();
			}
			function prelazakLevela1($xpPlus){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql="select xp from informacije where idkorisnik='".$_SESSION['userId']."'";
				$rez=$conn->query($sql);
				
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=10;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=10*pow(2,$level);
					}
					$level++;
					
					if($xp-$xpPlus<$manja){
						obavijesti($_SESSION["userId"],'<a href="Leveli.php">Prešli ste na novu razinu! Sada ste razina '.$level.'</a>');
					}
				}
			}
			
			function dodajXp($xp){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				
				$sql="UPDATE `informacije` SET `xp`=`xp`+$xp where idkorisnik='".$_SESSION['userId']."'";
				
				$conn->query($sql);
				
				prelazakLevela1($xp);
				$conn->close();
			}
			function prelazakLevela2($xpPlus,$id){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql="select xp from informacije where idkorisnik='$id'";
				$rez=$conn->query($sql);
				
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=10;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=10*pow(2,$level);
					}
					$level++;
					if($xp-$xpPlus<$manja){
						obavijesti($id,'<a href="Leveli.php">Prešli ste na novu razinu! Sada ste razina '.$level.'</a>');
					}
				}
			}
			function dodajXp2($xp,$id){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql="UPDATE `informacije` SET `xp`=`xp`+$xp where idkorisnik='$id'";

				$conn->query($sql);
				prelazakLevela2($xp, $id);
				$conn->close();
			}
			function obavijesti($id,$tekst){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";


				$conn = new mysqli($servername, $username, $password, $dbname);

				if($id=="|" or $id=="" or $id==" "){
					$conn->close();
					return;
				}
				
				$sql="INSERT INTO `obavijesti` (`obavijest`, `idkorisnik`, `pogledano`) VALUES ('$tekst', '$id', '0');";
				$conn->query($sql);
				$conn->close();
			}
		?>
		