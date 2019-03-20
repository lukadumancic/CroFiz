<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://82.132.7.168/Main.php");
		die();
	}
?>

<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php echo promjena(); ?>
		<?php include 'head.php';?>
	</head>
	<body>
		<?php include 'navigacija.php';?>
		
		
		<article>
			<div class='opis2' style="background: url('Slicice/lozinka-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Promjena lozinke</strong>
			</div>
			
			<div class='opis2'>
				Ako se ne osjećate sigurni, slobodno promjenite lozinku
			</div>
			
			<div class='paralelna1' style="background: url('Slicice/lozinka.jpg');background-size: cover;background-position: center; ">
				<form method='post'>
					<input type='password' name='old' placeholder='Stara lozinka' required>
					<p>Minimalna duljina lozinke: 6 znakova</p>
					<input type='password' id='pass' name='new1' onchange='provjeriPass()' placeholder='Nova lozinka' required>
					<input type='password' id='pass2' name='new2' onchange='provjeriPass()' placeholder='Ponovite lozinku' required>
					<br><input type='submit' class='promjenaLozinke' value='Promjena lozinke' name='sum'>
				</form>
			</div>
			
			<script type='text/javascript'>
				function provjeriPass(){
					if(document.getElementById("pass2").value==document.getElementById("pass").value){
						document.getElementById("pass2").style.border="2px solid #06DE26";
						document.getElementById("pass").style.border="2px solid #06DE26";
					}
					else{
						document.getElementById("pass2").style.border="2px solid #DE0606";
						document.getElementById("pass").style.border="2px solid #DE0606";
					}
				}
			</script>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php

			function dohvatiStaru(){
				$conn=conn();
				
				$sql="select pass from korisnici where id='".getId($_SESSION["korisnickoIme"])."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["pass"];
			}
			function promjena(){
				if(prijavljen()==="True"){
					if(isset($_POST["sum"])){
						if(isset($_POST["old"]) and isset($_POST["new1"]) and isset($_POST["new2"])){
							//HESH
							$_POST["old"]=hash("md5",$_POST["old"]);
							if($_POST["new1"]===$_POST["new2"]){
								if(strlen($_POST["new1"])>5){
									if($_POST["old"]===dohvatiStaru()){
										
										$conn=conn();
										
										$pass=hash("md5",$_POST["new1"]);
										
										$sql="UPDATE `korisnici` SET `pass`='$pass' WHERE `id`='".$_SESSION['userId']."'";
										$conn->query($sql);
										$conn->close();
										$_SESSION["poruka"]="Lozinka promjenjena";
										$_SESSION["zaporka"]=$pass;
									}
									else{
										$_SESSION["poruka"]="Netočna stara lozinka";
									}
								}
								else{
									$_SESSION["poruka"]="Lozinka prekratka";
								}
							}
							else{
								$_SESSION["poruka"]="Lozinke se ne poklapaju";
							}
						}
						else{
							$_SESSION["poruka"]="Morate unjeti sva polja";
						}
					}
				}
 			}
			
		?>
	</body>
</html>