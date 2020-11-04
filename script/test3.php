<!doctype html>

<?php include 'session.php';?>

<script>
	a="<?php
	if(isset($_POST["logOut"])){
		$_SESSION["korisnickoIme"]="*%test%*";
		$_SESSION["zaporka"]="*%test%*";
	}
	//Prijava korisnika
		if(prijavljen()=="False"){
			echo "1";
		}

	?>";
	if(a=="1"){
		window.location='http://localhost/Main.php';
	}
</script>

<script type='text/javascript'>
	//Ako postoji msg alert u linku stranice
	<?php
		if(isset($_GET["msg"])){
			echo 'alert(\''.$_GET["msg"].'\');';
		}
	?>
	if(a=="0"){
		alert("Kriva lozinka");
	}
</script>



<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		<title>CROFIZ</title>
		<script src="../../jquery-1.10.2.js"></script>
	<script src="../../ui/jquery.ui.core.js"></script>
	<script src="../../ui/jquery.ui.widget.js"></script>
	<script src="../../ui/jquery.ui.mouse.js"></script>
	<script src="../../ui/jquery.ui.draggable.js"></script>
	<script src="../../ui/jquery.ui.droppable.js"></script>
	<style>
	.droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px;display:inline; }
	.draggable, #draggable-nonvalid { width: auto; height: auto; float: left; margin: 10px 10px 10px 0;display: block; }
	</style>
	<script>
	var l=[];
	var odabrani=[];
	$(function() {
		$( ".draggable" ).draggable();
		$( ".droppable" ).droppable({
			accept: ".draggable",
			activeClass: "ui-state-hover",
			hoverClass: "ui-state-active",
			drop: function( event, ui ) {
				var id = ui.draggable.attr("id");
				
				var idUcenika=ids[$("#"+id).html()];
				
				var id2=$( this ).attr('id');
				if(id2=="droppable2"){
					var index = l.indexOf($("#"+id).html());
					var index2=odabrani.indexOf(idUcenika);
					if (index >= 0) {
						l.splice( index, 1 );
					}
					if (index2 >= 0) {
						odabrani.splice( index, 1 );
					}
				}
				else{
					var index = l.indexOf($("#"+id).html());
					var index2=odabrani.indexOf(idUcenika);
					if (index == -1) {
						l.push($("#"+id).html());
					}	
					if (index2 == -1) {
						odabrani.push(idUcenika);
					}	
					
				}
				$("#idKor").val("|"+odabrani.join("|")+"|");
				$("#uceniciUGrupi").html(l.join(", "));
				console.log(odabrani);
			}
		});
	});
	</script>
	</head>
	<body onload = "pokreni()">
		<script>
			//Pokreće zadane funkcije onload
			function pokreni(){
				startTime();
			}
		</script>
		<?php include 'navigacija.php';?>
		
		<article>
			<!-- Tekst stranice -->
			<h2 style='font-size: 35px;margin-top: -20px;'>Grupe</h2>
		
			<?php
				if(profesor()){
					
					echo "<form method='post' class='grupaForm' action='dodajGrupu.php'>" ;
					echo "<input type='text' name='imeGrupe' placeholder='Ime Grupe' required>";
					echo "<br>";
					echo "<input type='radio' name='opcija' value='svi' onclick='sakrijDodavanje()'>Dodaj sve u grupu<br>";
					echo "<input type='radio' name='opcija' value='odaberi' onclick='prikaziDodavanje()'>Odabir<br>";
					echo "<div class='odabirGrupe2' id='dodavanje' style='display:none'>";
					echo '<div id="droppable2" class="ui-widget-header droppable">
						<p>Izbaci</p>
					</div>';
					echo '<div id="droppable" class="ui-widget-header droppable">
						<p>Ubaci</p>
					</div>';
					echo '<div style="display:block;">';
					echo dohvatiUcenike();
					echo '</div>';
					echo "</div>";
					echo "<p>Učenici u grupi:</p>";
					echo '<p id="uceniciUGrupi"></p>';
					echo "<input style='margin-top:10px;' type='submit' value='Napravi grupu' >";
					echo "<input type='hidden' name='odabrano' id='idKor' value=''>";
					echo "</form>";
					echo "<br>Grupe:<br>";
					
					
				}
				echo mojeGrupe();
			?>
			<script>
				function prikaziDodavanje(){
					document.getElementById("dodavanje").style.display="block";
					$("#uceniciUGrupi").html("");
				}
				function sakrijDodavanje(){
					document.getElementById("dodavanje").style.display="none";
					$("#uceniciUGrupi").html("Svi");
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
			function profesor(){
				$servername = "82.132.7.168";
				$username = "admin";
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
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function noMentor(){
				$servername = "82.132.7.168";
				$username = "admin";
				$password = "124578";
				$dbname = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				if(isset($_GET["nick"])){
					$nick=$_GET["nick"];
				}
				else{
					$nick=$_SESSION["nick"];
				}
				$sql="select mentorid from korisnici where nick='".$_SESSION['korisnickoIme']."' and mentorid is null";
				$rez=$conn->query($sql);
				if($rez->num_rows==0){
					$sql="select mentorid from korisnici where nick='".$_SESSION['korisnickoIme']."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					
					if($row["mentorid"]==getId($_GET["nick"])){
						return "mojMentor";
					}
					return False;
				}
				else{
					return True;
				}
			}
			function getId($nick){
				$servername = "82.132.7.168";
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
			function dohvatiUcenike(){
				$servername = "82.132.7.168";
				$username = "admin";
				$password = "124578";
				$dbname = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql="select id,ime,prezime from korisnici where mentorid=".getId($_SESSION["korisnickoIme"]);
				$rez=$conn->query($sql);
				$ret="";
				$i=0;
				$lid=array();
				$lim=array();
				if($rez->num_rows!=0){
					while($row=$rez->fetch_assoc()){
						$i++;
						$ret.='<div id="draggable'.$i.'" class="ui-widget-content draggable">'.$row['ime'].' '.$row['prezime'].'</div>';
						array_push($lid,$row["id"]);
						$im=$row['ime'].' '.$row['prezime'];
						array_push($lim,$im);
					}
				}
				$ret.="<script>ids=[];";
				for($j=0;$j<$i;$j++){
					$ret.= "ids['".$lim[$j]."']=".$lid[$j].";";
				}
				$ret.="</script>";
				$conn->close();
				return $ret;
			}
			function mojeGrupe(){
				$servername = "82.132.7.168";
				$username = "admin";
				$password = "124578";
				$dbname = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				if(!profesor()){
					$sql="select mentorid from korisnici where mentorid is not null and id=".getId($_SESSION["korisnickoIme"]);
					$rez=$conn->query($sql);
					if($rez->num_rows==0){
						echo "Nemate mentora";
					}
					else{
						$row=$rez->fetch_assoc();
						$id=getId($_SESSION["korisnickoIme"]);
						$sql="select * from grupe where (idkor like '|$id|%' or idkor like '%|$id|%' or idkor like '|$id|' or idkor like '%|$id|' or idkor='-1') and mentorid=".$row["mentorid"];
						$rezultat=$conn->query($sql);
						if($rezultat->num_rows>0){
							while($row=$rezultat->fetch_assoc()){
								echo "<a class='grupa' href='http://localhost/Grupa.php?id=".$row["id"]."'>".$row['ime']."</a><br>";
							}
						}
					}
				}
				else{
					$sql="select * from grupe where  mentorid=".getId($_SESSION["korisnickoIme"]);
					$rezultat=$conn->query($sql);
					if($rezultat->num_rows>0){
						while($row=$rezultat->fetch_assoc()){
							echo "<a class='grupa' href='http://localhost/Grupa.php?id=".$row["id"]."'>".$row['ime']."</a><br>";
						}
					}
				}
			}
		?>
	</body>
</html>