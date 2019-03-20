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
		<?php include 'head.php';?>
		<script src="../../jquery-1.10.2.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="../../ui/jquery.ui.core.js"></script>
		<script src="../../ui/jquery.ui.widget.js"></script>
		<script src="../../ui/jquery.ui.mouse.js"></script>
		<script src="../../ui/jquery.ui.draggable.js"></script>
		<script src="../../ui/jquery.ui.droppable.js"></script>
		<style>
		.droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px;display:inline; }
		.draggable, #draggable-nonvalid { width: auto; height: auto; float: left; margin: 10px 10px 10px 0;display: block; }
		</style>
		<script>
		var l=[];
		var odabrani=[];
		$(function() {
			$( ".draggable" ).draggable();
			$( ".droppable" ).droppable({
				accept: ".draggable",
				activeClass: "ui-state-hover",
				hoverClass: "ui-state-active",
				drop: function( event, ui ) {
					var id = ui.draggable.attr("id");
					
					var idUcenika=ids[$("#"+id).html()];
					
					var id2=$( this ).attr('id');
					if(id2=="droppable2"){
						var index = l.indexOf($("#"+id).html());
						var index2=odabrani.indexOf(idUcenika);
						if (index >= 0) {
							l.splice( index, 1 );
						}
						if (index2 >= 0) {
							odabrani.splice( index, 1 );
						}
					}
					else{
						var index = l.indexOf($("#"+id).html());
						var index2=odabrani.indexOf(idUcenika);
						if (index == -1) {
							l.push($("#"+id).html());
						}	
						if (index2 == -1) {
							odabrani.push(idUcenika);
						}	
						
					}
					$("#idKor").val("|"+odabrani.join("|")+"|");
					$("#uceniciUGrupi").html(l.join(", "));
					console.log(odabrani);
				}
			});
		});
	</script>
	</head>
	<body>
		<?php include 'navigacija.php';?>
		
		<article id="art">
		
			<div class='opis2' style="background: url('Slicice/grupa-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Grupe</strong>
			</div>
			
		
			<?php
				if(profesor()){
					echo "<form method='post' class='grupaForm' action='dodajGrupu.php'>" ;
					echo "<p class='tamnije' style='padding-top: 15px;margin-top: 0px;'>Pravljenje grupe</p>";
					echo "<input style='width:250px;' type='text' name='imeGrupe' placeholder='Ime Grupe' required>";
					echo "<br>";
					echo "<input type='radio' name='opcija' value='svi' onclick='sakrijDodavanje()'>Dodaj sve u grupu<br>";
					echo "<input type='radio' name='opcija' value='odaberi' onclick='prikaziDodavanje()'>Odabir<br>";
					
					echo "<div class='odabirGrupe2' id='dodavanje' style='display:none'>";
					echo '<div id="droppable2" class="ui-widget-header droppable">
						<p>Izbaci</p>
					</div>';
					echo '<div id="droppable" class="ui-widget-header droppable">
						<p>Ubaci</p>
					</div>';
					echo '<div style="display:block;">';
					echo dohvatiUcenike();
					echo '</div>';
					echo "</div>";
					
					echo "<div id='dodavanje2' style='display:none'>";
					echo '<div style="display:block;">';
					echo dohvatiUcenike2();
					echo '</div>';
					echo "</div>";
					
					echo "<div class='tabDisplayNone'>";
					echo "<p>Učenici u grupi:</p>";
					echo '<p id="uceniciUGrupi"></p>';
					echo "</div>";
					
					echo "<input class='napraviGrupu' type='submit' value='Napravi grupu' >";
					echo "<input type='hidden' name='odabrano' id='idKor' value=''>";
					echo "</form>";
					
					
				}
				else{
					//echo "<div class='opis2'>Povežite se s profesorom, prijateljima ili kolegama</div>";
					echo mojeGrupe();
				}
			?>
			
			<div>
				<div class='paralelna3' style="background: url('Slicice/komunikacija.jpg');background-size: cover;background-position: center; ">
					<p>Komunikacija</p>
				</div>
				<div class='paralelna3' style="background: url('Slicice/challenge.jpg');background-size: cover;background-position: center; ">
					<p><a href="Zadaci.php?br=Mentorski">Izazov</a></p>
				</div>
				<div class='paralelna3' style="background: url('Slicice/skripte.jpg');background-size: cover;background-position: center; ">
					<p><a href="Skripte.php?br=MentorskeSkripte">Skripte</a></p>
				</div>
			</div>
			
			
			<?php 
				if(profesor()){
					echo '<div class="opis2">
						<strong>Grupe</strong>
					</div>';
					echo mojeGrupe();
				}
			?>
			
			
			
			<script>
				function prikaziDodavanje(){
					document.getElementById("dodavanje").style.display="";
					document.getElementById("dodavanje2").style.display="";
					$("#uceniciUGrupi").html(l.join(", "));
				}
				function sakrijDodavanje(){
					document.getElementById("dodavanje").style.display="none";
					document.getElementById("dodavanje2").style.display="none";
					$("#uceniciUGrupi").html("Svi");
				}
				
				function ubaci(id){
					var l=document.getElementById("idKor").value;
					l=l.split("|");
					var index = l.indexOf(id.toString());
					l.splice(index, 1);
					l.push(id);
					if(l.length==1){
						l="|"+l.join("|")+"|";
					}
					else{
						l=l.join("|")+"|";
					}
					document.getElementById("idKor").value=l;
				}
			</script>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
		
		<?php

			function profesor(){
				$conn=conn();
				$nick=$_SESSION["korisnickoIme"];
				$sql="select obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				
				$conn->close();
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function noMentor(){
				$conn=conn();
				if(isset($_GET["nick"])){
					$nick=$_GET["nick"];
				}
				else{
					$nick=$_SESSION["nick"];
				}
				$sql="select mentorid from korisnici where nick='".$_SESSION['korisnickoIme']."' and mentorid is null";
				$rez=$conn->query($sql);
				if($rez->num_rows==0){
					$sql="select mentorid from korisnici where nick='".$_SESSION['korisnickoIme']."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					
					$conn->close();
					if($row["mentorid"]==getId($_GET["nick"])){
						return "mojMentor";
					}
					return False;
				}
				else{
					$conn->close();
					return True;
				}
			}

			function dohvatiUcenike(){
				$conn=conn();
				$sql="select id,ime,prezime from korisnici where mentorid=".getId($_SESSION["korisnickoIme"]);
				$rez=$conn->query($sql);
				$ret="";
				$i=0;
				$lid=array();
				$lim=array();
				if($rez->num_rows!=0){
					while($row=$rez->fetch_assoc()){
						$i++;
						$ret.='<div id="draggable'.$i.'" class="ui-widget-content draggable">'.$row['ime'].' '.$row['prezime'].'</div>';
						array_push($lid,$row["id"]);
						$im=$row['ime'].' '.$row['prezime'];
						array_push($lim,$im);
					}
				}
				$ret.="<script>ids=[];";
				for($j=0;$j<$i;$j++){
					$ret.= "ids['".$lim[$j]."']=".$lid[$j].";";
				}
				$ret.="</script>";
				$conn->close();
				return $ret;
			}
			function dohvatiUcenike2(){
				$conn=conn();
				$sql="select id,ime,prezime from korisnici where mentorid=".getId($_SESSION["korisnickoIme"]);
				$rez=$conn->query($sql);
				$ret="";
				if($rez->num_rows!=0){
					$ret.='<p style="background-color: #696969;padding: 1px;"></p>';
					while($row=$rez->fetch_assoc()){
						$ret.='<input onchange="ubaci('.$row['id'].')" type="checkbox">'.$row['ime'].' '.$row['prezime']."<br>";
					}
					$ret.='<p style="background-color: #696969;padding: 1px;"></p>';
				}
				else{
					$ret.='<p style="background-color: #696969;padding: 1px;"></p>';
					$ret.= "<p class='tamnije'>Nemate učenike!</p>";
					$ret.='<p style="background-color: #696969;padding: 1px;"></p>';
				}
				$conn->close();
				return $ret;
			}
			function mojeGrupe(){
				$conn=conn();
				if(!profesor()){
					$sql="select mentorid from korisnici where mentorid is not null and id='".$_SESSION["userId"]."'";
					$rez=$conn->query($sql);
					if($rez->num_rows==0){
						//echo "Nemate mentora";
					}
					else{
						$row=$rez->fetch_assoc();
						$id=getId($_SESSION["korisnickoIme"]);
						$sql="select * from grupe where (idkor like '|$id|%' or idkor like '%|$id|%' or idkor like '|$id|' or idkor like '%|$id|' or idkor='-1') and mentorid=".$row["mentorid"];
						$rezultat=$conn->query($sql);
						if($rezultat->num_rows>0){
							$i=0;
							while($row=$rezultat->fetch_assoc()){
								$i++;
								echo "<div class='grupaDiv'>";
								echo "<a class='grupa' style='color: #444343;' href='http://82.132.7.168/Grupa.php?id=".$row["id"]."'>".$row['ime']."</a><br>";
								echo slikaGrupa($row['id']);echo "<div class='tamnije'>";
								
								echo "Broj članova:";
								echo "</div>";
								echo infoGrupa($row["id"]);
								
								echo "<br><div class='tamnije'>";
								echo "Opis";
								echo "</div>";
								echo tekstGrupe($row["id"]);
								echo "</div>";
							}
						}
						else{
							echo "<div class='opis2'><strong>Nemate grupa</strong><br><p class='tamnije'>Javite svome mentoru da napravi jednu!</p></div>";
						}
						
				
					}
				}
				else{
					$sql="select * from grupe where  mentorid='".$_SESSION["userId"]."'";
					$rezultat=$conn->query($sql);
					if($rezultat->num_rows>0){
						$i=0;
						while($row=$rezultat->fetch_assoc()){
							$i++;
							echo "<div class='grupaDiv'>";
							echo "<a class='grupa' style='color: #444343;' href='http://82.132.7.168/Grupa.php?id=".$row["id"]."'>".$row['ime']."</a><br>";
							echo slikaGrupa($row['id']);
							
							echo "<div class='tamnije'>";
							echo "Broj članova";
							echo "</div>";
							echo infoGrupa($row["id"]);
							
							
							echo "<br><div class='tamnije'>";
							echo "Opis";
							echo "</div>";
							echo tekstGrupe($row["id"]);
							echo "</div>";
								
						}
					}
					else{
						echo "<div class='bijeli'><strong>Nemate grupa</strong><br>Napravite jednu</div>";
					}
					
				}
				$conn->close();
			}
			
			function infoGrupa($id){
				$conn=conn();
				$sql="select idkor from grupe where id='".$id."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$kor=$row["idkor"];
				$l=explode("|",$kor);
				$dict=array_count_values($l);
				$conn->close();
				return count($l)-$dict[""];
			}
			function tekstGrupe($id){
				$conn=conn();
				$sql="select opis from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["opis"];
			}
		?>
	</body>
</html>