<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://82.132.7.168/Main.php");
		die();
	}
	if(!isset($_GET["nick"])){
		$_GET["nick"]=$_SESSION["korisnickoIme"];
	}
?>

<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php include 'head.php';?>
	</head>
	<body>
		<?php include 'navigacija.php';?>
		<?php include 'uredivanje.php'; ?>
		
		
		<article id="art">
		
			<div class='opis2' style="background: url('Slicice/banner-profil.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Profil</strong>
				<?php echo dohvatiImePrezime(); ?>
			</div>
		
		
			
			<img class="slika" src="Slike/Korisnik<?php if(isset($_GET["nick"])){ echo getId($_GET["nick"]);}else{echo getId($_SESSION["korisnickoIme"]); } ?>.jpg">
			<form method="post" action='Poruke.php'>
				<input type='hidden' name='primatelj2' value='<?php if(isset($_GET["nick"])){ echo $_GET["nick"];}else{echo $_SESSION["korisnickoIme"]; } ?>'>
				<input class='slanjePoruke' type='submit' value='Pošalji poruku'>
			</form>
			
			<?php
			
				if(!mojProfil()){
					if(!prijatelj(getId($_GET["nick"]))){
						$_SESSION["idPrijatelj"]=getId($_GET["nick"]);
						echo "<form method='post' action='DodavanjePrijatelja.php'>
						<input class='dodajPrijatelja' type='submit' value='Dodaj na listu prijatelja'>
						</form>";
					}
					else{
						echo "<p class='tamnije'>Prijatelji</p>";
					}
					
				}
				
			?>
			
			<?php
				if(!mojProfil() and profesor() and !profesor2()){
				
				if(noMentor()==="mojMentor"){
					echo "<p class='tamnije' style='margin-top: 0px;font-size:20px;'><strong>Moj mentor</strong></p><br>";
				}
				else if(noMentor()){
					echo "<p style='margin-top: 0px;font-size:20px;'>";
					echo "<form method='post' action='dodajMentora.php'>";
					$_SESSION["idMentor"]=getId($_GET["nick"]);
					echo "<input class='mentor' type='submit' value='Dodaj Mentora'>";
					echo "</form>";
					echo "<br></p>";
				}
				else if(!noMentor()){
					echo "<p style='margin-top: 0px;font-size:20px;'>";
					echo "<form method='post' action='dodajMentora.php'>";
					$_SESSION["idMentor"]=getId($_GET["nick"]);
					echo "<input class='mentor' type='submit' value='Promijeni mentora'>";
					echo "</form>";
					echo "</p>";
				}
			}
			?>
			
			<?php 
				echo "<p style='margin:0;background-color: #696969;padding: 1px;'></p>";
				echo dohvatiOpce();
				echo "<p style='margin:0;background-color: #696969;padding: 1px;'></p>";
			?>
			<?php if(!mojProfil()){
					if(aktivan(getId($_GET["nick"]))===1){
						echo "<p>Trenutno Aktivan</p><br>";
					}
					else{
						echo "<p class='tamnije'>Trenutno Neaktivan</p>";
					}
					echo "<p style='background-color: #696969;padding: 1px;'></p>";
				} 
			?>
			
			
			
			<?php
				if(mojProfil()){
					echo '
					<form style="margin-bottom: -60px;" class="unosObjave"  method="post" action="objavaTeksta.php" enctype="multipart/form-data">
						<input style="margin-top:5px;width:250px;" type="text" placeholder="Recite nešto o sebi" name="objavaTekst" required><br>
						<div class="fileUpload btn btn-primary">
							<img id="ikonaOdabir" src="Slicice/dodajSliku.gif" style="height:50px;width:50px;">
							<input onchange="prikaziSliku()" class="upload" name="userfile" type="file" id="userfile">
						</div>
						<input class="postaviObjavu" style="margin-bottom: 15px;" type="submit" value="Objavi">
					</form><br>';
					echo '<p style="background-color: #696969;padding: 1px;"></p>';
				}
			?>
			<script>
				function prikaziSliku(){
					document.getElementById("ikonaOdabir").src="Slicice/dodajSlikuOdabrano.gif";
				}
			</script>
			<div style="display:block;" id="objave">
				<script>
					var x=0;
					var id=<?php if(isset($_GET["nick"])){echo getId($_GET["nick"]);}
						else{echo getId($_SESSION["korisnickoIme"]);} ?>;
					function dodajObjave()
					{
						x+=10;
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
							console.log(0);
						}
						else{
							document.getElementById("objave").innerHTML+=xmlhttp.responseText;
						}
						}
					  }
					xmlhttp.open("GET","dohvatiObjaveProfil.php?limit="+x+"&id="+id,true);
					xmlhttp.send();
					}
					//Dodavanje objava prilikom otvaranja stranice
					dodajObjave();
					
					function profil(nick){
						window.location="http://82.132.7.168/Profil.php?nick="+nick;
					}
					
					window.onscroll = function(ev) {
						if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
							dodajObjave();
						}
					}
				</script>
			</div>
			<br>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
		
		<?php
			function brojObjava(){
				$conn=conn();
				
				$sql="SELECT COUNT(*) from objave where id='".getId($_SESSION["korisnickoIme"])."'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["COUNT(*)"];
			}
			function mojProfil(){
				if(isset($_GET["nick"])){
					if($_GET["nick"]==$_SESSION["korisnickoIme"]){
						return True;
					}
					else{
						return False;
					}
				}
				else{
					return True;
				}
			}
			function dohvatiOpce(){
				$conn=conn();
				if(isset($_GET["nick"])){
					$nick=$_GET["nick"];
				}
				else{
					$nick=$_SESSION["korisnickoIme"];
				}

				$sql="select ime,prezime,obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Ostalo"){
					$row["obrazovanje"].=". razred";
				}
				return "<p style='margin-top: 0px;font-size: 20px;padding: 15px;'>".$row["ime"]." ".$row["prezime"]."<br>".level1(getId($_GET["nick"]))."<br>".$row["obrazovanje"]."</p>";
			}
			function dohvatiImePrezime(){
				$conn=conn();
				if(isset($_GET["nick"])){
					$nick=$_GET["nick"];
				}
				else{
					$nick=$_SESSION["korisnickoIme"];
				}

				$sql="select ime,prezime from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return "<p style='margin-top: 0px;margin-top: 0px;font-size: 30px;color: white;'>".$row["ime"]." ".$row["prezime"]."</p>";
			}
			function profesor(){
				$conn=conn();
				if(isset($_GET["nick"])){
					$nick=$_GET["nick"];
				}
				else{
					$nick=$_SESSION["nick"];
				}
				$sql="select obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$conn->close();
				$row=$rez->fetch_assoc();
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function noMentor(){
				$conn=conn();
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
					
					$conn->close();
					if($row["mentorid"]==getId($_GET["nick"])){
						return "mojMentor";
					}
					return False;
				}
				else{
					$conn->close();
					return True;
				}
			}
		?>
	</body>
</html>