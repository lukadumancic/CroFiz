<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>
<?php

	if(prijavljen()=="False"){
		header("Location: http://82.132.7.168/Main.php");
		die();
	}
	if(!isset($_GET['id'])){
		header("Location: http://82.132.7.168/Zadaci.php");
		die();
	}
	else if(!mojIzazov()){
		header("Location: http://82.132.7.168/Zadaci.php?br=Mentorski");
		die();
	}
?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php include 'head.php';?>
	</head>
	<body>
		
		<?php include 'navigacija.php';?>
		
		<script>
			//Dodatak navigaciji
			$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == 'http://82.132.7.168/Zadaci.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		
		<article id="art">
		
			<div id="extraNavigation">
				<a class='extraNavLink' id='extraNavDnevni' href="Zadaci.php?br=Dnevni">Dnevni</a>
				<a class='extraNavLink' id='extraNavTjedni'href="Zadaci.php?br=Tjedni">Tjedni</a>
				<a class='extraNavLink extraNavSelected' id='extraNavMentorski' href="Zadaci.php?br=Mentorski">Mentorski</a>
				<a class='extraNavLink' id='extraNavDvoboj' href="Zadaci.php?br=Dvoboj">Dvoboj</a>
				<a class='extraNavLink' id='extraNavArhiva' href="Zadaci.php?br=Arhiva">Arhiva</a>
			</div>
			
			<div class='divIzazov' style='margin-top: 5px;'>
				<div class='opis2' style="background: url('Slicice/mentorski-izazov-banner.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>
						<a href='Zadaci.php?br=Mentorski'>Mentorski Izazov</a>
					</strong>
				</div>
			
			<?php if(trajanje()){
				echo "<br>";
				if(profesor()){
					echo "<img src='Slicice/opcije.png' class='urediIzazov' onClick='uredi()'><br>";
				}
				echo "<br>";
				echo imeIzazova();
				echo info();
				echo ispisiZadatke();
			}
			else{
				echo "<br>";
				if(profesor()){
					echo "<img src='Slicice/opcije.png' class='urediIzazov' onClick='uredi()'><br>";
				}
				echo "<br>";
				echo imeIzazova();
				echo info();
				echo ispisiZadatke2();
			}
			?>
			
			</div>
			
			<?php
				if(profesor() or !trajanje()){
					echo "<p style='color: #383838;font-weight: bold;'>Rezultati</p>";
					echo ispisiRezultateUcenika();
				}
			?>
			<script>
				var j=1;
				function prikazi(i){
					document.getElementById("zad"+j).style.display='none';
					document.getElementById("navButton"+j).style.color="";
					document.getElementById("zad"+i).style.display='block';
					document.getElementById("navButton"+i).style.color="#929292";
					j=i;
				}
				<?php
				if(profesor()){
					echo "
				function uredi(){
					document.getElementById('zadUredi'+j).style.display='block';
				}
				";
				}
				?>
				prikazi(1);
			</script>
		</article>
		
		<footer id="fut">
			<?php include 'footer.php'; ?>
			
		</footer>
		
		<?php
			function mojIzazov(){
				$conn=conn();
				
				if(isset($_GET["id"])){
					$id=$_GET["id"];
					$sql="select idgrupe from izazovi where id='$id'";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						$conn->close();
						return False;
					}
					else{
						$row=$rez->fetch_assoc();
						$idgrupa=$row["idgrupe"];
						$mojId=getId($_SESSION["korisnickoIme"]);
						if(!profesor()){
							$sql="select idkor from grupe where id='$idgrupa' and (idkor like '%|$mojId|%' or idkor like '%|$mojId|' or idkor like '|$mojId|' or idkor like '|$mojId|%' or idkor like '-1' and mentorid='".mentorid()."')";
							$rezultat=$conn->query($sql);
							$conn->close();
							if($rezultat->num_rows===0){
								return False;
							}
							else{
								return True;
							}
						}
						else{
							$sql="select idkor from grupe where id='$idgrupa' and  mentorid='$mojId'";
							$rezultat=$conn->query($sql);
							$conn->close();
							if($rezultat->num_rows===0){
								return False;
							}
							else{
								return True;
							}
						}
					}
				}
				else{
					$conn->close();
					return False;
				}
			}
			function imeIzazova(){
				$conn=conn();
				$sql="select ime from izazovi where id=".$_GET["id"];
				$rez=$conn->query($sql);
				$conn->close();
				$row=$rez->fetch_assoc();
				return $row["ime"];
				
			}
			function ispisiZadatke(){
				$conn=conn();
				$ret="";
				$ret2="<form method='post' action='rijesiIzazov.php'>";
				$ret3="";
				if(isset($_GET["id"])){
					$sql="select ime,idzadaci,slike from izazovi where id=".$_GET["id"];
					$rez=$conn->query($sql);
					if($rez->num_rows!=0){
						$sql="select rjesenje from izazovtocnost where idizazov=".$_GET["id"]." and idkorisnik=".$_SESSION["userId"];
						$rez2=$conn->query($sql);
						if($rez2->num_rows===0){
							$k=0;
						}
						else{
							$k=1;
							$row2=$rez2->fetch_assoc();
							$li=explode("|",$row2["rjesenje"]);
						}
						$row=$rez->fetch_assoc();
						$x=$row["idzadaci"];
						$l=explode("|",$x);
						$y=$row["slike"];
						$ly=explode("|",$y);
						$br=0;
						$ret.="<div class='navIzazov'><p class='tamnije'>Zadaci</p>";
						for($i=0;$i<sizeof($l);$i++){
							$idZad=$l[$i];
							if($idZad==""){
								continue;
							}
							$slika=$ly[$i];
							
							$sql="select * from izazovizadaci where id=$idZad";
							$rez2=$conn->query($sql);
							$row2=$rez2->fetch_assoc();
							$ret.="<button class='navIzazovButton' id='navButton$i' style='width:auto;margin:10px;' onClick='prikazi($i)'>".$row2["ime"]."</button>";
							
							$br++;
						}
						$ret.="</div>";
						$br=0;
						for($i=0;$i<sizeof($l);$i++){
							$idZad=$l[$i];
							if($idZad==""){
								continue;
							}
							$slika=$ly[$i];
							
							$sql="select * from izazovizadaci where id=$idZad";
							$rez2=$conn->query($sql);
							$row2=$rez2->fetch_assoc();
							
							$ret2.="<div class='divIzazov' id='zad$i' style='display:none;'>";
							$ret2.="<p class='tekst' style='margin-top:0px;padding-top:20px;padding-bottom:20px;'>".$row2["tekst"]."</p>";
							
							$ret3.="<div class='divIzazov' id='zadUredi$i' style='padding-bottom: 50px;display:none;margin-left:10%;margin-right:10%;'><strong>Uređivanje zadatka</strong><br>";
							$ret3.="<form action='spremiZadatak.php' method='post' enctype='multipart/form-data'>";
							$ret3.="<textarea placeholder='Tekst zadatka' class='izazovUnos' name='tekst' style='width:90%' cols='10' rows='10'>".$row2["tekst"]."</textarea>";
							
							if($slika==="1"){
								$ret2.="<img src='Slike/Izazov$idZad.jpg' class='slikaIzazov'>";
							}
							$ret2.="<div style='padding-top: 25px;padding-bottom: 25px;'><p class='tamnije' style='display:inline;'>Mjerna jedinica: </p><p style='display:inline;'>".$row2['mjernaJedinica']."</p></div>";
							
							$ret3.="<input placeholder='Rješenje' name='rjesenje' style='width:50%' type='tekst' class='izazovUnos' value='".$row2['rjesenje']."'>";
							$ret3.="<input placeholder='Mjerna Jedinica' name='mjernaJedinica' style='width:50%' type='tekst' class='izazovUnos' value='".$row2['mjernaJedinica']."'>";
							$ret3.='<input type="file" name="slika" class="izazovUnos" style="display: block; border: none; width: 40%;">';
							
							if($k==0){
								$ret2.="<input style='margin-bottom: 10px;' type='text' name='rjesenje$i' placeholder='Rješenje'>";
							}
							else{
								$ret2.="<input style='margin-bottom: 10px;' type='text' name='rjesenje$i' value='".$li[$i]."'>";
							
							}
							$ret2.="<input type='hidden' name='id$i' value='$idZad'>";
							
							$ret3.="<input type='hidden' name='id' value='$idZad'>";
							$ret3.="<input type='hidden' name='idGL' value='".$_GET['id']."'>";
							
							$ret2.="</div>";
							
							$ret3.="<input type='submit' class='spremiZadatak' value='Spremi zadatak'>";
							$ret3.="</form>";
							$ret3.="</div>";
							
							$br++;
						}
							
						$ret2.="<input type='hidden' name='id' value='".$_GET["id"]."'>";
						$ret2.="<input type='hidden' name='n' value='$br'>";
						$ret2.="<p style='background-color: white;padding: 5px;'><input class='rijesiIzazov' type='submit' value='Riješi izazov'></p>";
						$ret2.="</form>";
						if(profesor()){
							$ret2.=$ret3;
						}
						
						$conn->close();
						return $ret.$ret2;
					}
				}
			}
			function mentorid(){
				if(profesor()){
					return $_SESSION["userId"];
				}
				$conn=conn();
				$sql="select mentorid from korisnici where id='".$_SESSION['userId']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["mentorid"];
			}
			function profesor(){
				$conn=conn();
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
			function ispisiRezultateUcenika(){
				$conn=conn();
				$sql="select * from izazovtocnost where idizazov=".$_GET["id"];
				$rez=$conn->query($sql);
				
				$ret="";
				if($rez->num_rows!=0){
					$l=array();
					$l2=array();
					while($row=$rez->fetch_assoc()){
						$l[$row["idkorisnik"]]=$row["tocnost"];
						$l3[$row["idkorisnik"]]=$row["rjesenje"];
						$l2[$row["idkorisnik"]]=substr_count($row["tocnost"], '1');
					}
					arsort($l2);
					$keys=array_keys($l2);
					$rjesenje=1;
					for($i=0;$i<sizeof($keys);$i++){
						$ret.=infoKorisnik($keys[$i]);
						$sql="select datum from izazovtocnost where idkorisnik='".$keys[$i]."' and idizazov='".$_GET["id"]."'";
						$rez=$conn->query($sql);
						$row=$rez->fetch_assoc();
						$ret.="<p style='font-size:10px;'>".obradiDatum($row['datum'])."</p>";
						$s=explode('|',$l[$keys[$i]]);
						$x=explode('|',$l3[$keys[$i]]);
						$br=0;
						$ret.="<div>";
						for($j=0;$j<sizeof($s);$j++){
							if($s[$j]==""){
								continue;
							}
							$rj=$x[$j];
							$br++;
							if(trajanje()===True){
								if($s[$j]=="1"){
									$ret.="<button onclick='prikazi($j)' style='color: white;background-color: green;border: 1px solid green;margin-left: 5px;font-size: 20px;border-radius: 100%;'><a title='Točno'>$rj</a></button>";
								}
								else{
									$ret.="<button onclick='prikazi($j)' style='color: white;background-color: red;border: 1px solid red;margin-left: 5px;font-size: 20px;border-radius: 100%;'><a title='Netočno'>$rj</a></button>";
								}
							}
							else{
								if($s[$j]=="1"){
									$ret.="<button style='color: white;background-color: green;border: 1px solid green;margin-left: 5px;font-size: 20px;border-radius: 100%;'><a title='Točno'>$rj</a></button>";
								}
								else{
									$ret.="<button style='color: white;background-color: red;border: 1px solid red;margin-left: 5px;font-size: 20px;border-radius: 100%;'><a title='Netočno'>$rj</a></button>";
								}
							}
						}
						$ret.="</div>";
						$ret.="<br>";
					}
					$conn->close();
					return $ret;
				}
				else{
					$conn->close();
					return "<p class='tamnije'>Nitko još nije riješio izazov</p>";
				}
			}
			
			function infoKorisnik($id){
				$conn=conn();
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick' style='margin-left:0px;' href='http://82.132.7.168/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]."</a>";
				
			}
			function infoKorisnik2($id){
				$conn=conn();
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' style='margin-left:0px;' href='http://82.132.7.168/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]."</a>";
				
			}
			function trajanje(){
				$conn=conn();
				$sql="select trajanje from izazovi where id='".$_GET['id']."'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				if($row["trajanje"]==1){
					return True;
				}
				else{
					return False;
				}
			}
			function info(){
				/*$conn=conn();
				$sql="select idgrupe from izazovi where id='".$_GET['id']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$sql="select ime,id from grupe where id='".$row['idgrupe']."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();*/
				
				$ret="";
				$ret.="<p class='tamnije' style='margin-bottom: -15px;'>".infoKorisnik2(mentorid()).'<br>'.objavljenIzazov()."</p>";
				$ret.="<p style='background-color: #696969;padding: 1px;'></p>";
				
				//$conn->close();
				return $ret;
			}
			function objavljenIzazov(){
				$id=$_GET["id"];
				$conn=conn();
				$sql="select datum from izazovi where id='".$id."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return obradiDatum($row["datum"]);
			}
			function ispisiZadatke2(){
				$conn=conn();
				$ret="";
				$ret2="<form>";
				$ret3="";
				if(isset($_GET["id"])){
					$sql="select ime,idzadaci,slike from izazovi where id=".$_GET["id"];
					$rez=$conn->query($sql);
					if($rez->num_rows!=0){
						$sql="select rjesenje from izazovtocnost where idizazov=".$_GET["id"]." and idkorisnik=".$_SESSION["userId"];
						$rez2=$conn->query($sql);
						if($rez2->num_rows===0){
							$k=0;
						}
						else{
							$k=1;
							$row2=$rez2->fetch_assoc();
							$li=explode("|",$row2["rjesenje"]);
						}
						$row=$rez->fetch_assoc();
						$x=$row["idzadaci"];
						$l=explode("|",$x);
						$y=$row["slike"];
						$ly=explode("|",$y);
						$br=0;
						$ret.="<div class='navIzazov'><p class='tamnije'>Zadaci</p>";
						for($i=0;$i<sizeof($l);$i++){
							$idZad=$l[$i];
							if($idZad==""){
								continue;
							}
							$slika=$ly[$i];
							
							$sql="select * from izazovizadaci where id=$idZad";
							$rez2=$conn->query($sql);
							$row2=$rez2->fetch_assoc();
							$ret.="<button class='navIzazovButton' id='navButton$i' style='width:auto;margin:10px;' onClick='prikazi($i)'>".$row2["ime"]."</button>";
							
							$br++;
						}
						$ret.="</div>";
						$br=0;
						for($i=0;$i<sizeof($l);$i++){
							$idZad=$l[$i];
							if($idZad==""){
								continue;
							}
							$slika=$ly[$i];
							
							$sql="select * from izazovizadaci where id=$idZad";
							$rez2=$conn->query($sql);
							$row2=$rez2->fetch_assoc();
							
							$ret2.="<div class='divIzazov' id='zad$i' style='display:none;'>";
							$ret2.="<p class='tekst' style='margin-top:0px;padding-top:20px;padding-bottom:20px;'>".$row2["tekst"]."</p>";
							
							$ret3.="<div class='divIzazov' id='zadUredi$i' style='padding-bottom: 50px;display:none;margin-left:10%;margin-right:10%;'><strong>Uređivanje zadatka</strong><br>";
							$ret3.="<form action='spremiZadatak.php' method='post' enctype='multipart/form-data'>";
							$ret3.="<textarea placeholder='Tekst zadatka' class='izazovUnos' name='tekst' style='width:90%' cols='10' rows='10'>".$row2["tekst"]."</textarea>";
							
							if($slika==="1"){
								$ret2.="<img src='Slike/Izazov$idZad.jpg' class='slikaIzazov'>";
							}
							$ret2.="<div style='padding-top: 25px;padding-bottom: 25px;'><p class='tamnije' style='display:inline;'>Mjerna jedinica: </p><p style='display:inline;'>".$row2['mjernaJedinica']."</p></div>";
							
							$ret3.="<input placeholder='Rješenje' name='rjesenje' style='width:50%' type='tekst' class='izazovUnos' value='".$row2['rjesenje']."'>";
							$ret3.="<input placeholder='Mjerna Jedinica' name='mjernaJedinica' style='width:50%' type='tekst' class='izazovUnos' value='".$row2['mjernaJedinica']."'>";
							$ret3.='<input type="file" name="slika" class="izazovUnos" style="display: block; border: none; width: 40%;">';
							
							if($k==0){
								$ret2.="<input style='margin-bottom: 10px;' type='text' name='rjesenje$i' placeholder='Rješenje'>";
							}
							else{
								$ret2.="<input style='margin-bottom: 10px;' type='text' name='rjesenje$i' value='".$li[$i]."'>";
							
							}
							$ret2.="<input type='hidden' name='id$i' value='$idZad'>";
							
							$ret3.="<input type='hidden' name='id' value='$idZad'>";
							$ret3.="<input type='hidden' name='idGL' value='".$_GET['id']."'>";
							
							$ret2.="</div>";
							
							$ret3.="<input type='submit' class='spremiZadatak' value='Spremi zadatak'>";
							$ret3.="</form>";
							$ret3.="</div>";
							
							$br++;
						}
							
						$ret2.="</form>";
						if(profesor()){
							$ret2.=$ret3;
						}
						
						$conn->close();
						return $ret.$ret2;
					}
				}
			}

?>
	</body>
</html>