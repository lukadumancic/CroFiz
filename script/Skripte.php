<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<head>
			<?php include 'head.php';?>
		</head>
		<body>
			
			<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
			<?php include 'navigacija.php';?>
			<script>
				//Dodatak navigaciji
				$(function(){
			  $('a').each(function() {
				if ($(this).prop('href') == 'http://82.132.7.168/Ucenje.php') {
				  $(this).addClass('current');
				}
			  });
			});
			</script>
			
			<article id="art">
			
			<div id="extraNavigation">
				<a class='extraNavLink' id='extraNavSkripte' href="?br=Skripte">Skripte</a>
				<a class='extraNavLink' id='extraNavMentorskeSkripte' href="?br=MentorskeSkripte">Mentorske skripte</a>
			</div>
			
			<?php
				if(isset($_GET["br"])){
					$br=$_GET["br"];
					if($br=="Skripte"){
						include "SkripteSve.php";
					}
					else{
						include "SkripteMentorske.php";
					}
				}
				else{
					include "SkripteOsnovno.php";
				}
			?>

			
			<script>
				a="<?php if(isset($_GET["br"])){echo $_GET["br"];}?>";
				if(a!=""){
					document.getElementById("extraNav"+a).className+=" extraNavSelected";
				}
			</script>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php

			/*function dohvatiSveSkripte(){
				$conn=conn();
				$sql="select id,name,type from skripte where x='1'";
				$rezultat=$conn->query($sql);
				$ret="";
				while($row=$rezultat->fetch_assoc()){
					$ret.= "<form method='post'>
					<input type='hidden' name='id' value='".$row['id']."'><input type='submit' value='".$row["name"]."'></form>";
				}
				$conn->close();
				return $ret;
			}*/
			function dohvatiSveSkripte(){
				$conn=conn();
				$sql="select id,name,type,datum from skripte where x='1'";
				$rezultat=$conn->query($sql);
				$ret="";
				
				while($row=$rezultat->fetch_assoc()){
					if(strpos($row["type"],"mage")){
						$vrsta=".jpg";
					}
					else if(strpos($row["type"],"pdf")){
						$vrsta=".pdf";
					}
					else if(strpos($row["type"],"ext")){
						$vrsta=".docx";
					}
					else if(strpos($row["type"],"pplication")){
						$vrsta=".docx";
					}
					
					if($vrsta!=".jpg"){
						$ret.= "<div class='skripte'><a href='Dokumenti/".$row['name'].$row['id'].$vrsta."'>".$row["name"]."</a>
						<p class='tamnije' style='font-size:10px;'>".obradiDatum($row['datum'])."</p></div>";
					}
					else{
						$ret.= "<div class='skripte'><a href='Slike/".$row['name'].$row['id'].$vrsta."'>".$row["name"]."</a>
						<p class='tamnije' style='font-size:10px;'>".obradiDatum($row['datum'])."</p></div>";
					}
				}
				$conn->close();
				return $ret;
			}
			function ispisSkripte(){
				if(isset($_POST["id"])){

					$conn=conn();
					$sql="select type from skripte where id='".$_POST["id"]."'";
					$rezultat=$conn->query($sql);
					$row=$rezultat->fetch_assoc();
					//Ako je slika
					if(strpos($row["type"],"mage")){
						echo "<textarea class='slika' style='display: block;background-image:url(http://82.132.7.168/Slike/".$_POST["id"].".jpg);' ></textarea>";
					}
					else if(strpos($row["type"],"/pdf")){
						echo "<script>";
						echo 'window.open("http://82.132.7.168/Dokumenti/'.$_POST["id"].'.pdf");';
						echo "</script>";
					}
					else{
						echo "<script>";
						echo 'window.open("http://82.132.7.168/Dokumenti/'.$_POST["id"].'.docx");';
						echo "</script>";
					}
				}
			}		
			function profesor(){
				$conn=conn();
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
			function idMentor(){
				$conn=conn();
				$sql="select mentorid from korisnici where id='".getId($_SESSION['korisnickoIme'])."'";
				$rezultat=$conn->query($sql);
				while($row=$rezultat->fetch_assoc()){
					return $row["mentorid"];
				}
				return getId($_SESSION['korisnickoIme']);
				
			}
			function dohvatiGrupe(){
				$conn=conn();
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select id,ime from grupe where mentorid=$mojId";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					$conn->close();
					return "Nemate grupa za odabir";
				}
				else{
					$ret="<select name='odabrano' required>";
					while($row=$rez->fetch_assoc()){
						$ret.='<option value="'.$row['id'].'">'.$row['ime'].'<br>';
					}
					$ret.="</select>";
					$conn->close();
					return $ret;
				}
			}
			function ispisiMentorskeSkripte(){
				if(prijavljen()=="True"){
					$conn=conn();
					$mojId=getId($_SESSION["korisnickoIme"]);
					$sql="select mentorid from korisnici where id=$mojId and (mentorid is not null or obrazovanje='Profesor')";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						$conn->close();
						return "<div class='opis2'>Nemate mentora</div>";
					}
					else{
						$ret="";
						$row=$rez->fetch_assoc();
						$mentorId=$row["mentorid"];
						if($mentorId==""){
							$mentorId=$mojId;
						}
						if(profesor()){
							$sql="select * from grupe where mentorid=$mentorId";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								
								$ret.="<div class='opis2'>Nemate grupe<br>Napravite jednu <a class='black' href='Grupe.php'>Grupu</div></div>";
							}
							else{
								while($row=$rez->fetch_assoc()){
									$ret.="<div class='grupaDiv'>"
									.$row['ime']
									.slikaGrupa($row["id"])."<br>";
									
									$sql="select id,name,type,datum from skripte where x='2' and grupa=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows===0){
										$ret.="<p class='tamnije'>Nema skripti</p>";
									}
									else{
										while($row2=$rez2->fetch_assoc()){
											if(strpos($row2["type"],"mage")){
												$vrsta=".jpg";
											}
											else if(strpos($row2["type"],"pdf")){
												$vrsta=".pdf";
											}
											else if(strpos($row2["type"],"ext")){
												$vrsta=".docx";
											}
											else if(strpos($row2["type"],"pplication")){
												$vrsta=".docx";
											}
											
											if($vrsta!=".jpg"){
												$ret.= "<div class='skripte'><a class='black' href='Dokumenti/".$row2['name'].$row2['id'].$vrsta."'>".$row2["name"]."</a>";
												$ret.="<form method='post'><input type='submit' value='Obriši'>";
												$ret.="<input type='hidden' name='delete' value='".$row2['id']."'></form>";
												$ret.="<p class='tamnije' style='font-size:10px;'>".obradiDatum($row2['datum'])."</p></div>";
												
											}
											else{
												$ret.= "<div class='skripte'><a class='black' href='Slike/".$row2['name'].$row2['id'].$vrsta."'>".$row2["name"]."</a>
												<p class='tamnije' style='font-size:10px;'>".obradiDatum($row2['datum'])."</p></div>";
											}
										}
									}
									$ret.="</div>";
								}
							}
						}
						if(!profesor()){
							$sql="select * from grupe where mentorid=$mentorId";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								$ret.="<div class='opis2'>Nemate grupe<br>Javite svome mentoru</div>";
							}
							else{
								while($row=$rez->fetch_assoc()){
									$ret.="<div class='grupaDiv'>"
									.$row['ime']
									.slikaGrupa($row["id"])."<br>";
									
									$sql="select id,name,type,datum from skripte where x='2' and grupa=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows===0){
										$ret.="<p class='tamnije'>Nema skripti</p>";
									}
									else{
										while($row2=$rez2->fetch_assoc()){
											if(strpos($row2["type"],"mage")){
												$vrsta=".jpg";
											}
											else if(strpos($row2["type"],"pdf")){
												$vrsta=".pdf";
											}
											else if(strpos($row2["type"],"ext")){
												$vrsta=".docx";
											}
											else if(strpos($row2["type"],"pplication")){
												$vrsta=".docx";
											}
											
											if($vrsta!=".jpg"){
												$ret.= "<div class='skripte'><a class='black' href='Dokumenti/".$row2['name'].$row2['id'].$vrsta."'>".$row2["name"]."</a>
												<p class='tamnije' style='font-size:10px;'>".obradiDatum($row2['datum'])."</p></div>";
											}
											else{
												$ret.= "<div class='skripte'><a class='black' href='Slike/".$row2['name'].$row2['id'].$vrsta."'>".$row2["name"]."</a>
												<p class='tamnije' style='font-size:10px;'>".obradiDatum($row2['datum'])."</p></div>";
											}
										}
									}
									$ret.="</div>";
								}
							}
						}
						$conn->close();
						return $ret;
						
					}
				}
			}
			function obrisiSkriptu(){
				if(isset($_POST["delete"])){
					$conn=conn();
					$sql="UPDATE `skripte` SET `x`='0' WHERE `id`='".$_POST['delete']."' and idkorisnik='".$_SESSION['userId']."'";
					$conn->query($sql);
					$conn->close();
				}
			}
		?>
	</body>
</html>