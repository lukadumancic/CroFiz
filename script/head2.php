<link rel="stylesheet" type="text/css" href="Style.css">
<link rel="stylesheet" type="text/css" href="stylesheet2.css">
<title>CROFIZ</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<div id='poruka' class='overlay' style='display:block;' onclick='makniPoruku()'>
	<div id='porukaTekst' class='fixed2' onmouseover='notok()' onmouseleave='ok()'>
		<?php
			if(isset($_SESSION["poruka"])){
				if(isset($_POST["poruka"]) and isset($_POST["naslov"])){
					pogledano($_POST["id"]);
					echo "Pošiljatelj: ".$_POST["posiljatelj"]."<br>";
					echo "Naslov: ".$_POST["naslov"]."<br>";
					echo $_POST["poruka"];
					echo '<form method="post" action="Poruke.php">';
					echo '<input type="hidden" name="primatelj2" value="'.$_POST["posiljatelj"].'">';
					echo '<input type="hidden" name="naslov2" value="Re:'.$_POST["naslov"].'">';
					echo '<input type="hidden" name="poruka2" value="'.$_POST["poruka"].'&#10;'.$_SESSION['korisnickoIme'].': '.'">';
					echo '<input class="odgovori" type="submit" value="Odgovori">';
					echo '</form>';
				}
				else if($_SESSION["poruka"]!=""){
					echo $_SESSION["poruka"];
				}
				else{
					echo '<script>document.getElementById("poruka").style.display="none";</script>';
				}
			}
			else{
				echo '<script>document.getElementById("poruka").style.display="none";</script>';
			}
			$_SESSION["poruka"]="";
		?>
	</div>
</div>

<script>
	function makniPoruku(){
		document.getElementById("poruka").style.display="none";
		document.getElementById("porukaTekst").innerHTML="";
	}
	function notok(){
		document.getElementById("poruka").onclick=function(){return;}
	}
	function ok(){
		document.getElementById("poruka").onclick=function(){makniPoruku();
		}
	}
</script>

<?php
	function pogledano($id){
		$servername = "82.132.7.168";
				$username = "admin";
				$password = "124578";
				$dbname = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
		
		$sql="UPDATE `poruke` SET `pogledano`='1' WHERE `id`='$id';";
		$conn->query($sql);
	}
?>

