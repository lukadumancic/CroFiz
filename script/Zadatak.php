<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php 
	if(!isset($_GET['id'])){
		header("Location: http://localhost/Zadaci.php");
		die();
	}
	else if(!postoji()){
		header("Location: http://localhost/Zadaci.php");
		die();
	}
?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php include 'ocjeniZadatak.php'; ?>
		<?php include 'head.php';?>
	</head>
	<body>
		<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
		<?php include 'navigacija.php';?>
		
		<script>
			//Dodatak navigaciji
			$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == 'http://localhost/Zadaci.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		
		<article id="art">	
			
			<div id="extraNavigation">
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavDnevni' href="Zadaci.php?br=Dnevni">Dnevni</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavTjedni' href="Zadaci.php?br=Tjedni">Tjedni</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavMentorski' href="Zadaci.php?br=Mentorski">Mentorski</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavDvoboj' href="Zadaci.php?br=Dvoboj">Dvoboj</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavArhiva' href="Zadaci.php?br=Arhiva">Arhiva</a>
			</div>
		
		
			<div class='divZadaci' style='margin-top:4px;'>
				<?php
				if(dnevni()){
					echo "<div class='opis2' style='background: url(\"Slicice/kalkulator.jpg\");background-size: cover;background-position: center; '>
						<strong style='font-size:50px;'><a href='Zadaci.php?br=Dnevni'>Dnevni zadatak</a></strong>
					</div>";
					echo '<script>
					document.getElementById("extraNavDnevni").className+=" extraNavSelected";
					</script>';
				}
				else if(tjedni()){
					echo "<div class='opis2' style='background: url(\"Slicice/month.jpg\");background-size: cover;background-position: center; '>
						<strong style='font-size:50px;'><a href='Zadaci.php?br=Tjedni'>Tjedni zadatak</a></strong>
					</div>";
					echo '<script>
					document.getElementById("extraNavTjedni").className+=" extraNavSelected";
					</script>';
				}
				else{
					echo "<div class='opis2' style='background: url(\"Slicice/arhiva.jpg\");background-size: cover;background-position: center; '>
						<strong style='font-size:50px;'><a href='Zadaci.php?br=Arhiva'>Arhiva</a></strong>
					</div>";
					echo '<script>
					document.getElementById("extraNavArhiva").className+=" extraNavSelected";
					</script>';
				}
			?>
				<div class='opis2' style='background:white;'>
					<strong>Pokušaj rješiti zadatak na papiru i onda unesi rješenje!</strong>
				</div>
				<div style='margin-bottom: 15px;margin-top: 5px;font-size: 17px;'>
					<h2 style="display: inline;font-size:35px;"><?php echo imeZadatka(); ?></h2>
					<a title='Forum' href='Tema.php?id=<?php echo $_GET["id"] ?>'><img src='Slicice/upitnik.jpg' style='width: 30px;;display: inline;margin: 10px;position: relative;bottom: -15px;'></a>
					<p><?php echo zadatakInfo(); ?></p>
				</div>
				<div class="tamnije" style="font-size: 20px;">
					<?php echo zadatak(); ?>
					<?php if(prijavljen()){
						if(unosPokusaja()){
							echo "<p style=''>".dohvatiPosljednjiPokusaj()."</p>";
						}
					}?>
					<form style='display: inline-block;margin-bottom: 20px;margin-top: 10px;' method='post' action='ProvjeriRjesenje.php'>
						<input type='text' name='unesenoRjesenje' placeholder='Rješenje' required>
						<?php $_SESSION['idZadatak']=$_GET["id"]; ?>
						<?php if(prijavljen()=="True"){
							if(zadatakDana()){$_SESSION['zadatakDana']='1';}
							else if(tjedniIzazov()){$_SESSION['zadatakDana']='2';}
							else{$_SESSION['zadatakDana']="0";}}
							?>
						<input class='provjeri' type='submit' value='Provjeri!'>
					</form>
				</div>
				
				<?php include 'ocjenaZadatka.php'; ?>
				
			</div>
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php
			
			function imeZadatka(){
				$conn=conn();
				$sql="select ime from zadaci where id='".$_GET['id']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["ime"];
				
			}
			function zadatak(){
				$conn=conn();
				$sql="select * from zadaci where id='".$_GET['id']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				$ret="";
				$ret.="<div class='opis2 tekst'>".$row["tekst"]."</div><br>";
				if($row["slika"]=='1'){
					$ret.="<img style='width:200px;' src='Slike/Zadatak".$_GET['id'].".jpg'><br>";
				}
				$ret.="Mjernja jedinica: <strong style='color:white;'>".$row["jedinica"]."</strong><br>";
				return $ret;
			}

			function zadatakDana(){
				$conn=conn();
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
					$conn->close();
					return False;
				}
			}
			function tjedniIzazov(){
				$conn=conn();
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
					$conn->close();
					return False;
				}
			}
			function dohvatiPosljednjiPokusaj(){
				$conn=conn();
				$sql="SELECT * from pokusaji where idzadatak='".$_GET["id"]."' and idkorisnik='".getId($_SESSION["korisnickoIme"])."'";
				$rezultat=$conn->query($sql);
				$conn->close();
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
			}
			function unosPokusaja(){
				$conn=conn();
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
			function dnevni(){
				$conn=conn();
				$sql="select id from zadaci where br=1";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows>0){
					while($row=$rez->fetch_assoc()){
						if($row["id"]==$_GET["id"]){
							return True;
						}
					}
				}
				return False;
			}
			function tjedni(){
				$conn=conn();
				$sql="select id from zadaci where br=2";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows>0){
					while($row=$rez->fetch_assoc()){
						if($row["id"]==$_GET["id"]){
							return True;
						}
					}
				}
				return False;
			}
			function prosjek(){
				$conn=conn();
				
				$sql="select * from ocjene where idzadatak='".$_GET["id"]."'";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					
					$ocjene=$row["ocjene"];
					$l=explode("|",$ocjene);
					$br=$l[1]*1+$l[2]*2+$l[3]*3+$l[4]*4+$l[5]*5;
					$x=$l[1]+$l[2]+$l[3]+$l[4]+$l[5];
					if ($x==0){
						return "<p style='margin-top: -10px;display: inline-block;width: 70px;padding: 5px;border-radius: 100%;color:white;background-color:#0B581E;'>0</p>";
					}
					$pros=round($br/$x,2);
					if($pros<=1.5){
						$cl="#08A22E";
					}
					else if($pros<=2){
						$cl="#0B581E";
					}
					else if($pros<=2.5){
						$cl="#019A98";
					}
					else if($pros<=3){
						$cl="#01329A";
					}
					else if($pros<=3.5){
						$cl="#33019A";
					}
					else if($pros<=4){
						$cl="#4E124D";
					}
					else if($pros<=4.5){
						$cl="#E00041";
					}
					else if($pros<=5){
						$cl="#FF0000";
					}
					return "<p style='margin-top: 0px;display: inline-block;width: 70px;padding: 5px;border-radius: 100%;color:white;background-color:$cl;'>".$pros."</p>";
				}
				return "<p style='margin-top: -5px;display: inline-block;width: 70px;padding: 5px;border-radius: 100%;color:white;background-color:#0B581E;'>0</p>";
			}
			
			function zadatakInfo(){
				$conn=conn();
				$sql="select * from zadaci where id='".$_GET['id']."'";
				$rez=$conn->query($sql);
				$conn->close();
				$row=$rez->fetch_assoc();
				echo "<p class='tamnije' style='display:inline;'>Objavljen: </p>".objavljenZadatak();
				echo "<br><p class='tamnije' style='display:inline;'>Riješenost: </p>".rijesenostZadatka($_GET['id']);
				echo "<br><p class='tamnije' style='display:inline;'>Razred: </p>".$row["razred"];
				echo "<br><p class='tamnije' style='display:inline;'>Gradivo: </p>".$row["podrucje"];
				echo "<br><p class='tamnije' style='display:inline;'>Ocjena zadatka</p><br><br>".prosjek()."<br>";
				
			}
			
			function objavljenZadatak(){
				$id=$_GET["id"];
				$conn=conn();
				$sql="select datum from zadaci where id='".$id."'";
				$rez=$conn->query($sql);
				$conn->close();
				$row=$rez->fetch_assoc();
				return obradiDatum($row["datum"]);
			}
			function postoji(){
				$id=$_GET["id"];
				$conn=conn();
				$sql="select * from zadaci where id='".$id."'";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===0){
					return False;
				}
				return True;
			}
		?>
	</body>
</html>