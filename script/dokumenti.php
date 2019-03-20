<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://82.132.7.168/Main.php");
		die();
	}
	if(!isset($_GET["id"])){
		header("Location: http://82.132.7.168/Grupe.php");
		die();
	}
	else if(prijavljen()=="True"){
		if(!mojaGrupa()){
			header("Location: http://82.132.7.168/Grupe.php");
			die();
		}
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
			if ($(this).prop('href') == 'http://82.132.7.168/Grupe.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		<article id="art">
			<div class='opis2' style="background: url('Slicice/dokumenti-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Dokumenti</strong>
				<p><a class='grupa' href='http://82.132.7.168/Grupa.php?id=<?php echo $_GET["id"]; ?>' ><?php echo imeGrupe(); ?></a></p>
			</div>
			
			<div class='opis2'>
				Ovdje možete vidjeti sve uploadane dokumente i skripte koje profesor postavlja
			</div>
			
			<?php 
			if(profesor2()){
				$_SESSION['idGrupeDokumenit']=$_GET["id"];
				echo "<div class='paralelna1' style='background: url(\"Slicice/dokumenti.jpg\");background-size: cover;background-position: center;'>";
				echo "<p>Upload dokumenta</p>";
				echo '<form method="post" enctype="multipart/form-data" action="uploadSkripta.php"><br>
					<input style="margin:5px;" type="text" name="ime" placeholder="Naziv" required>
					<input type="hidden" name="MAX_FILE_SIZE" value="20000000"><br>
					<div style="margin:5px;" class="fileUpload btn btn-primary">
						<img id="ikonaOdabir" src="Slicice/dodajSkriptu.jpg" style="height:50px;width:50px;">
						<input onchange="prikaziSliku()" class="upload" name="userfile" type="file" id="userfile" required>
					</div>
					<br><input class="noviDokument" name="upload" type="submit" id="upload" value="Upload"><br>
					</form>';
				echo "</div>";
				echo '<script>function prikaziSliku(){
					document.getElementById("ikonaOdabir").src="Slicice/dodajSkriptuOdabrano.jpg";
				}</script>';
			}
							
			?>
			<div class='dokumenti'>
				<?php
					$conn=conn();
					$sql="select * from skripte where (x='2' or x='3') and grupa='".$_GET["id"]."'";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						echo "Nema nikakvih dokumanta";
					}
					while($row=$rez->fetch_assoc()){
						if(strpos($row["type"],"mage")){
							$vrsta=".jpg";
						}
						else if(strpos($row["type"],"pdf")){
							$vrsta=".pdf";
						}
						else if(strpos($row["type"],"ext")){
							$vrsta=".docx";
						}
						else if(strpos($row["type"],"kset")){
							$vrsta=".xls";
						}
						else if(strpos($row["type"],"pplication")){
							$vrsta=".docx";
						}
						echo "<p style='background-color: #696969;padding: 1px;'></p>";
						
						if($vrsta!=".jpg"){
							echo "<div class='skripte'><a href='Dokumenti/".$row['name'].$row['id'].$vrsta."'>".$row["name"]."</a>
							<p class='tamnije' style='font-size:10px;'>".obradiDatum($row['datum'])."</p></div>";
						}
						else{
							echo "<div class='skripte'><a href='Slike/".$row['name'].$row['id'].$vrsta."'>".$row["name"]."</a>
							<p class='tamnije' style='font-size:10px;'>".obradiDatum($row['datum'])."</p></div>";
							
						}
						if ($vrsta==".pdf"){
							echo '
							<iframe src="http://82.132.7.168/Dokumenti/'.$row['name'].$row['id'].$vrsta.'" style="width:600px; height:500px;" frameborder="0"></iframe>
							';
						}
					}
					$conn->close();
				
				?>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php'; ?>
		</footer>
		
		<?php
			function glava(){
				$conn=conn();
				$id=$_GET["id"];
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select * from grupe where mentorid='$mojId' and id='$id'";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===0){
					return False;
				}
				else{
					return True;
				}
			}
			function mojaGrupa(){
				$conn=conn();
				$id=$_GET["id"];
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select mentorid from korisnici where id=$mojId";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$mentorId=$row["mentorid"];
				$sql="select * from grupe where mentorid='$mentorId' and idkor='-1' or id='$id' and (idkor like '|$mojId|' or idkor like '%|$mojId|' or idkor like '|$mojId|%' or idkor like '%|$mojId|%' or mentorid='$mojId')";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===0){
					return False;
				}
				else{
					return True;
				}
			}
			function imeGrupe(){
				$conn=conn();
				$id=$_GET["id"];
				$sql="select ime from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["ime"];
			}
		?>
	</body>
</html>