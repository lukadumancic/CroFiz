<!doctype html>
<?php include 'session.php';?>
<?php include 'prijavaScript.php'; ?>



<html>
	<head>
		<?php include 'head.php';?>
	</head>
	<body onload = "pokreni()">
		<script>
			//Pokreće zadane funkcije onload
			function pokreni(){
				startTime();
			}
		</script>
		<?php include 'regBoxes.php';?>
		<?php include 'navigacija.php';?>
		
		
		<article id="art">
			<div class='opisPosla'>
				<div class='naslov'>
					Forum zadataka
					<a href="Forum.php" title="Forum"><img style='width: 30px;' src="Slicice/change.jpg"></a>
				</div>
				<div class='opis' >
					Ovdje možeš potražiti pomoć u slućaju da ne znaš riješiti neki zadatak. Ukoliko znaš riješiti zadatak, pomozi drugima!
				</div>
				<?php include 'opisPosla.php'; ?>
			</div>
			
			<p>
				<strong>Teme</strong><br>
				<table style='display: inline-block;border-spacing: 10px;' id="teme">
					<tr>
						<td>Ime zadatka</td>
						<td>Broj objava</td>
					</tr>
				</table>
			</p>
			<script>
					var x=0;
					function dodajTeme()
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
						document.getElementById("teme").innerHTML+=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","dohvatiTeme.php?limit="+x,true);
					xmlhttp.send();
					}
					//Dodavanje objava prilikom otvaranja stranice
					dodajTeme();
					
					window.onscroll = function(ev) {
						if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
							dodajTeme();
						}
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
			
		?>
	</body>
</html>