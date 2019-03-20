<?php 
	ubaciPocetno();
	dnevnaPrijava();
?>

<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link rel="shortcut icon" href="/Slicice/logo.png" />

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title>CroFiz</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<div id='poruka' class='overlay' style='display:block;' onclick='makniPoruku()'>
	<div id='porukaTekst' class='fixed2' onmouseover='notok()' onmouseleave='ok()'>
		<?php
			if(isset($_SESSION["poruka"])){
				if(isset($_POST["poruka"]) and isset($_POST["naslov"])){
					pogledano($_POST["id"]);
					echo "<p class='tamnije' style='display:inline;'>Pošiljatelj: </p>".$_POST["posiljatelj"]."<br>";
					echo "<p class='tamnije' style='display:inline;'>Naslov: </p>".$_POST["naslov"]."<br>";
					echo "<p class='tamnije' style='display:inline;'>Poruka:</p><br>".$_POST["poruka"];
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
	//Script, Jquery
	function makniPoruku(){
		document.getElementById("poruka").style.display="none";
		document.getElementById("porukaTekst").innerHTML="";
	}
	function notok(){
		document.getElementById("poruka").onclick=function(){return;}
	}
	function ok(){
		document.getElementById("poruka").onclick=function(){makniPoruku();}
	}
</script>


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$('textarea').autoResize();
</script>

<?php
	function pogledano($id){
		$conn=conn();
		
		$sql="UPDATE `poruke` SET `pogledano`='1' WHERE `id`='$id';";
		$conn->query($sql);
		$conn->close();
	}
	
	
	
	//Funkcije nužne kako se nebi nešto "srušilo"
	if(prijavljen()=="True"){
		cp();
		postignuca();
	}
?>

