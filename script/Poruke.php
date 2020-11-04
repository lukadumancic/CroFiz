<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://34.121.205.40/Main.php");
		die();
	}
?>

<html>

	<head>
		<?php include 'head.php';?>
		<script src="../../jquery-1.10.2.js"></script>
		<script src="../../ui/jquery.ui.core.js"></script>
		<script src="../../ui/jquery.ui.widget.js"></script>
		<script src="../../ui/jquery.ui.accordion.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<style>
			.ui-widget{
				font-size: 0.8em;
			}
			.ui-state-default{
				background: initial;
			}
		</style>
		<script>
		$(function() {
			$( "#primljenePoruke" ).accordion({
				active: false,
				collapsible: true,
			});
			$( "#poslanePoruke" ).accordion({
				active: false,
				collapsible: true,
			});
		});
		
		  $(function() {
			var availableTags = [
			  <?php 
				$l=prijatelji();
				for($i=0;$i<count($l);$i++){
					echo '"'.getNick($l[$i]).'",';
				}
			  
			  ?>
			];
			$( "#primatelji" ).autocomplete({
			  source: availableTags
			});
		  });
		</script>
		<?php include 'uredivanje.php'; ?>
	</head>
	
	<body>
		<?php include 'navigacija.php';?>
		
		<article id="art">
		
			<div id="extraNavigation">
				<a class='extraNavLink' id='extraNavSlanje' href="?br=Slanje">Slanje poruke</a>
				<a class='extraNavLink' id='extraNavPrimljeno' href="?br=Primljeno">Primljeno</a>
				<a class='extraNavLink' id='extraNavPoslano' href="?br=Poslano">Poslano</a>
			</div>
			
			<div class='opis2' style="background: url('Slicice/slanje-banner.jpg');background-size: cover;background-position: center;margin-top:4px; ">
				<strong class='naslovStranice'>Poruke</strong>
			</div>
			<div class='opis2'>
				Komunikacija između članova zajednice <strong>CroFiz</strong>
			</div>
			<?php
				if(isset($_GET["br"])){
					$br=$_GET["br"];
					if($br=="Primljeno"){
						include "PrimljenePoruke.php";
					}
					else if($br=="Slanje"){
						include "SlanjePoruke2.php";
					}
					else{
						include "PoslanePoruke.php";
					}
				}
				else{
					include "SlanjePoruke2.php";
					$_GET["br"]="Slanje";
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
			
			function primljenePoruke(){
				$conn=conn();
				
				$sql="select * from poruke where primatelj='".$_SESSION['userId']."' order by id desc";
				$rez=$conn->query($sql);
				if($rez->num_rows>0){
					while($row=$rez->fetch_assoc()){
						$sql="UPDATE `poruke` SET `pogledano`='1' WHERE `id`='".$row["id"]."'";
						$conn->query($sql);
						echo '<h3>'.getNick($row["posiljatelj"]).': '.$row["naslov"].'<p style="display: inline;font-size: 10px;"> '.obradiDatum($row['datum']).'</p></h3>';
						echo '<div class="tab">'.$row["poruka"];
						echo '<form method="post" action="Poruke.php?br=Slanje">';
						echo '<input type="hidden" name="primatelj2" value="'.getNick($row["posiljatelj"]).'">';
						echo '<input type="hidden" name="naslov2" value="Re:'.$row["naslov"].'">';
						echo '<input type="hidden" name="poruka2" value="'.$row["poruka"].'&#10;'.$_SESSION['korisnickoIme'].': '.'">';
						echo '<input class="odgovori" type="submit" value="Odgovori">';
						echo '</form>';
						echo '</div>';
					}
				}
				$conn->close();
			}
			function poslanePoruke(){
				$conn=conn();
				
				$sql="select * from poruke where posiljatelj='".$_SESSION['userId']."' order by id desc";
				$rez=$conn->query($sql);
				if($rez->num_rows>0){
					while($row=$rez->fetch_assoc()){
						echo '<h3>'.getNick($row["primatelj"]).': '.$row["naslov"].'<p style="display: inline;font-size: 10px;"> '.obradiDatum($row['datum']).'</p></h3>';
						echo '<div class="tab">'.$row["poruka"].'</div>';
					}
				}
				$conn->close();
			}

		?>
	</body>
</html>