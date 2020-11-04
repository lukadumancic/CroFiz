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
		
		
		<article>
			<div class='opis2' style="background: url('Slicice/postavke-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Postavke</strong>
			</div>
			
			<div class='opis2'>
				Postavite sve podatke koje želite podijeliti s <strong>CroFiz</strong> zajednicom!
			</div>
			
			
			
			<?php
				if(isset($_POST['Postavi'])){
					$conn=conn();
					
					if(!isset($_POST["rodendan"])){
						$_POST["rodendan"]="";
					}
					if(!isset($_POST["spol"])){
						$_POST["spol"]="";
					}
					if(!isset($_POST["skola"])){
						$_POST["skola"]="";
					}
					if(!isset($_POST["adresa"])){
						$_POST["adresa"]="";
					}
					
					if($_POST["rodendan"]==''){
						$_POST["rodendan"]="0000-00-00";
					}
					if($_FILES['image']['size'] > 0) {
						if(getimagesize($_FILES['image']['tmp_name'])==FALSE){
							$sql="UPDATE `korisnici` SET `ime`='".$_POST["ime"]."', `prezime`='".$_POST["prezime"]."' WHERE `id`='".$_SESSION["userId"]."'";
							$sql2="UPDATE `informacije` SET `rodendan`='".$_POST["rodendan"]."', `spol`='".$_POST["spol"]."', `skola`='".$_POST["skola"]."', `adresa`='".$_POST["adresa"]."' WHERE `idkorisnik`='".$_SESSION["userId"]."'";
						}
						else{
							$image= addslashes($_FILES['image']['tmp_name']);
							$name= addslashes($_FILES['image']['name']);
							$image= file_get_contents($image);
							$image= base64_encode($image);
							saveimage($name,$image);
							$sql="UPDATE `korisnici` SET `ime`='".$_POST["ime"]."', `prezime`='".$_POST["prezime"]."', `br`='0' WHERE `id`='".$_SESSION["userId"]."'";
							$sql2="UPDATE `informacije` SET `rodendan`='".$_POST["rodendan"]."', `spol`='".$_POST["spol"]."', `skola`='".$_POST["skola"]."', `adresa`='".$_POST["adresa"]."' WHERE `idkorisnik`='".$_SESSION["userId"]."'";
						}
					}
					else{
						$sql="UPDATE `korisnici` SET `ime`='".$_POST["ime"]."', `prezime`='".$_POST["prezime"]."' WHERE `id`='".$_SESSION["userId"]."'";
						$sql2="UPDATE `informacije` SET `rodendan`='".$_POST["rodendan"]."', `spol`='".$_POST["spol"]."', `skola`='".$_POST["skola"]."', `adresa`='".$_POST["adresa"]."' WHERE `idkorisnik`='".$_SESSION["userId"]."'";
					}
					if(!profesor()){
						$sql3="select obrazovanje from korisnici WHERE `id`='".$_SESSION["userId"]."'";
						$rez=$conn->query($sql3);
						$row=$rez->fetch_assoc();
						if($row["obrazovanje"]!=$_POST["obrazovanje"]){
							$sql3="DELETE FROM `ranklista` WHERE `idkorisnik`='".$_SESSION["userId"]."'";
							$conn->query($sql3);
							$sql3="DELETE FROM `ranklista2` WHERE `idkorisnik`='".$_SESSION["userId"]."'";
							$conn->query($sql3);
							$sql3="UPDATE `korisnici` SET `obrazovanje`='".$_POST["obrazovanje"]."' WHERE `id`='".$_SESSION["userId"]."'";
							$conn->query($sql3);
						}
					}
					$conn->query($sql);
					$conn->query($sql2);
					$conn->close();
				}
				
				
			?>
			
			<div class='paralelna1' style="background: url('Slicice/postavke.jpg');background-size: cover;background-position: center; ">
			<?php
			
				$conn=conn();
				
				$sql="select * from korisnici where id='".getId($_SESSION["korisnickoIme"])."'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				echo "<form method='post' enctype='multipart/form-data'>
				Ime <input type='text' name='ime' value=".$row["ime"]."><br>
				Prezime <input type='text' name='prezime' value=".$row["prezime"].">".
				"<br>";
				echo "Slika <input type='file' id='slikaFile' name='image'><br>";
				echo '<img id="slikaIspis" src="" width="200" style="display:none;" /><br>';
				if(!profesor()){
					echo "Razred <input id='rng' type='range' name='obrazovanje' min='1' max='4' value='".$row["obrazovanje"]."' onchange='promjenaRazreda()'><br>
					<p style='display:inline;' id='raz'> ".$row["obrazovanje"]."</p><br><br>";
				}
				
				$sql="select * from informacije where idkorisnik='".getId($_SESSION["korisnickoIme"])."'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				
				$m="";
				$z="";
				if($row['spol']==='M'){$m="checked";}
				if($row['spol']==='Ž'){$z="checked";}
				
				echo "Datum rođenja <input type='date' name='rodendan' value=".$row["rodendan"]."><br>
				M<input type='radio' name='spol' value='M' ".$m.">
				Ž<input type='radio' name='spol' value='Ž' ".$z."><br>
				Škola <input type='text' name='skola' value='".$row["skola"]."'><br>
				Adresa <input type='text' name='adresa' value='".$row["adresa"]."'><br>";
				echo "<input type='submit' name='Postavi' value='sumit'></form>";
				$conn->close();
			
				?>
				
			</div>
			<script>
				function promjenaRazreda(){
					document.getElementById("raz").innerHTML=document.getElementById("rng").value+"<br><strong>Vaši bodovi na ranklisti će nestati ako promjenite razred!</strong>";
				}

				$('#slikaFile').change( function(event) {
					var tmppath = URL.createObjectURL(event.target.files[0]);
					$("#slikaIspis").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
				});
			</script>
			
			<!-- <a href='http://crofiz.com/PromjenaLozinke.php' title='Promjena lozinke'><img src='Slicice/pass.png' style='width:75px;height:75px;' ></a> -->
		
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>	
		</footer>
		
		<?php
			function getIdZadatak($zadatak){
				$conn=conn();
				$sql="select idzadaci from zadaci where ime='".$zadatak."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["idzadaci"];
			}
			function getRazred(){
				$id=$_SESSION['userId'];
				$conn=conn();
				$sql="select `obrazovanje` from korisnici where id='".$id."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["obrazovanje"];
			}
			function saveimage($name,$image){
                $conn=conn();
                $sql="UPDATE `korisnici` SET `slika`='$image' WHERE `id`='".$_SESSION["userId"]."';";
                $result=$conn->query($sql);
				$conn->close(); 
            }
			function profesor(){
				$conn=conn();
				
				$nick=$_SESSION["korisnickoIme"];
				$sql="select obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				if($row["obrazovanje"]=="Profesor" or $row["obrazovanje"]=="Ostalo"){
					return True;
				}
				else{
					return False;
				}
			}
		?>
	</body>
</html>