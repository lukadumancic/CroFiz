<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://localhost/Main.php");
		die();
	}
	if(prijavljen()=="True"){
		if(!mojaGrupa()){
			header("Location: http://localhost/Grupe.php");
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
			if ($(this).prop('href') == 'http://localhost/Grupe.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		<article id="art">
			
			<div class='opis2' style="background: url('Slicice/grupa-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'><a href='Grupe.php'>Grupa</a></strong>
				<?php echo imeGrupe(); ?>
			</div>
			
			
			<div class='opis2' style='padding-top:10px;background-color: #444343;;color: white;'>
				<?php 
					if(glava()){
						echo "<a title='Postavke' href='postavkeGrupe.php?id=".$_GET["id"]."'><img style='width:50px;height:50px;' src='Slicice/tools.jpg'></a>";
					} 
				?>
				<a title='Dokumenti' href='dokumenti.php?id=<?php echo $_GET["id"]; ?>'><img style='width:50px;height:50px;' src='Slicice/dokument.jpg'></a>
				<?php echo "<p class='tamnije'>Opis</p>".tekstGrupe(); ?>
				<?php 
					echo "<p class='tamnije'>Članovi</p>";
					clanovi(); 
				?>
			</div>
			
			
			
			<form class='unosObjave' method="post" action="objavaTekstaGrupa.php" enctype="multipart/form-data">
				<input style="margin-top:5px;width:250px;" type="text" placeholder="Objavite nešto u grupu" name="objavaTekst" required><br>
				<div class="fileUpload btn btn-primary">
					<img id="ikonaOdabir" src='Slicice/dodajSliku.gif' style='height:50px;width:50px;'>
					<input onchange="prikaziSliku()" class="upload" name="userfile" type="file" id="userfile">
					<?php $_SESSION["idGrupa"]=$_GET["id"]; ?>
				</div>
				<input class="postaviObjavu" type="submit" value="Objavi">
			</form>
			<br>
			<script>
				function prikaziSliku(){
					document.getElementById("ikonaOdabir").src="Slicice/dodajSlikuOdabrano.gif";
				}
			</script>
			<div style="display:block;" id="objave">
				<script>
					var x=<?php echo brojObjava(); ?>+10;
					function dodajObjave()
					{
						x-=10;
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
							document.getElementById("art").removeChild(document.getElementById("josObjava"));
						}
						else{
							document.getElementById("objave").innerHTML+=xmlhttp.responseText;
						}
						}
					  }
					xmlhttp.open("GET","dohvatiObjaveGrupa.php?limit="+x+"&id=<?php echo $_GET["id"]; ?>",true);
					xmlhttp.send();
					}
					//Dodavanje objava prilikom otvaranja stranice
					dodajObjave();
					
					function profil(nick){
						window.location="http://localhost/Profil.php?nick="+nick;
					}
					window.onscroll = function(ev) {
						if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
							dodajObjave();
						}
					}
				</script>
			</div>
			<br>
			<button style='display:none;' type='button' id="josObjava" onclick="dodajObjave()">Prikaži još objava</button>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php
			function brojObjava(){
				$conn=conn();
				$sql="SELECT COUNT(*) from objavegrupa";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["COUNT(*)"];
			}
			function imeGrupe(){
				$conn=conn();
				$id=$_GET["id"];
				$sql="select ime from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<p style='margin-top: 0px;margin-top: 0px;font-size: 30px;color: white;'>".$row["ime"]."</p>";
			}
			function mojaGrupa(){
				if(isset($_GET["id"])){
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
				return False;
			}
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
			function tekstGrupe(){
				$conn=conn();
				$id=$_GET["id"];
				$sql="select opis from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["opis"];
			}
			function clanovi(){
					$conn=conn();
					$sql="select idkor,mentorid from grupe where `id`='".$_GET["id"]."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$clanovi=$row["idkor"];
					$mentorid=$row["mentorid"];
					if($clanovi=="-1"){
						$conn->close();
						return null;
					}
					else{
						$sql="select id from korisnici where mentorid='".$mentorid."'";
						$rez=$conn->query($sql);
						$conn->close();
						if($rez->num_rows>0){
							while($row=$rez->fetch_assoc()){
								if(strpos($clanovi,$row["id"])>0){
									echo "<a class='nick3' href='Profil.php?nick=".getNick($row["id"])."'>".getName($row["id"]).' '.getSurName($row["id"])."</a>";
								}
							}
						}
						else{
							echo "Nema učenika";
						}
					}
				}
		?>
	</body>
</html>