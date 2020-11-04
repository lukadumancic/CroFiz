<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://crofiz.com/Main.php");
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
		
		<article id="art">
		
		
			<div class='opis2' style="background: url('Slicice/banner-naslovna.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Naslovna stranica</strong>
			</div>
			
			
			<form class='unosObjave' method="post" action="objavaTeksta.php" enctype="multipart/form-data">
				<input style="margin-top:5px;width:250px;" type="text" placeholder="Recite nešto o sebi" name="objavaTekst" required><br>
				<div class="fileUpload btn btn-primary">
					<img id="ikonaOdabir" src='Slicice/dodajSliku.gif' style='height:50px;width:50px;'>
					<input onchange="prikaziSliku()" class="upload" name="userfile" type="file" id="userfile">
				</div>
				<input class="postaviObjavu" type="submit" value="Objavi">
			</form>
			<br>
			<script>
				function prikaziSliku(){
					document.getElementById("ikonaOdabir").src="Slicice/dodajSlikuOdabrano.gif";
				}
			</script>
			<div id="objave">
				<script>
					var x=<?php echo brojObjava(); ?>+56;
					function dodajObjave()
					{
						x-=10;
					var xmlhttp;    
					if (window.XMLHttpRequest){
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else{
						// code for IE6, IE5
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
							console.log("1");
							document.getElementById("objave").innerHTML+=xmlhttp.responseText;
						}
						}
					  }
					xmlhttp.open("GET","dohvatiObjave.php?limit="+x,true);
					xmlhttp.send();
					}
					//Dodavanje objava prilikom otvaranja stranice
					dodajObjave();
					
					function profil(nick){
						window.location="http://crofiz.com/Profil.php?nick="+nick;
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
				$sql="SELECT COUNT(*) from objave";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["COUNT(*)"];
			}
		?>
	</body>
</html>