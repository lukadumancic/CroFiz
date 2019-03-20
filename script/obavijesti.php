<?php
	session_start();
	include 'Funkcije.php';
	if(prijavljen()=="True"){
		$conn=conn();

		$sql="select obavijest,pogledano,datum from obavijesti where idkorisnik='".$_SESSION["userId"]."' order by id desc";
		$rez=$conn->query($sql);
		$i=0;
		echo "<strong>Obavijesti</strong>";
		if($rez->num_rows!=0){
			while($row=$rez->fetch_assoc()){
				$i++;
				if($_GET["x"]==0 and $i==10){
					break;
				}
				if($row["pogledano"]==0){
					echo "<div class='obavijest' style='background-color: #868686;'>";
				}
				else{
					echo "<div class='obavijest'>";
				}
				echo $row["obavijest"];
				echo '<p class="tamnije" style="font-size:10px;">'.obradiDatum($row["datum"]).'</p>';
				echo "</div>";
			}
		}
		else{
			echo "<br>Nema obavijesti";
			}
			
		$sql="UPDATE `obavijesti` SET `pogledano`='1' WHERE `idkorisnik`='".$_SESSION["userId"]."';";
		$conn->query($sql);
		$conn->close();
	}			
?>