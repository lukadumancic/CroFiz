<?php
	session_start();
	include 'Funkcije.php';
	$conn=conn();

	$sql="select * from poruke where primatelj='".$_SESSION["userId"]."' order by id desc limit 10";
	$rez=$conn->query($sql);
	$conn->close();
	$i=0;
	echo "<strong>Poruke</strong>";
	if($rez->num_rows!=0){
		while($row=$rez->fetch_assoc()){
			$i++;
			if($i===11){
				break;
			}
			echo "<div class='obavijest'>";
			echo "<form method='post'>
			<input type='hidden' name='id' value='".$row["id"]."'>
			<input type='hidden' name='posiljatelj' value='".getNick($row["posiljatelj"])."'>
			<input type='hidden' name='naslov' value='".$row["naslov"]."'>
			<input type='hidden' name='poruka' value='".$row["poruka"]."'>
			<input
			style='";
			if($row["pogledano"]==0){
				echo "background-color: #D6D6D6;";
			}
			echo 
			"background-image: url(\"".slika2($row["posiljatelj"])."\");background-position: 0px 0px;background-repeat: no-repeat;background-size: 40px 40px;'
			class='porukaObavijest' type='submit' value='".getName($row["posiljatelj"]).': '.$row["naslov"]."'>
			</form>";
			echo '<div class="tamnije" style="font-size:10px;">'.obradiDatum($row["datum"]).'</div>';
			echo "</div>";
		}
	}
	else{
		echo "<br>Nema poruka";
		}
		
	
	
					
?>