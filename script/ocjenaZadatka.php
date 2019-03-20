
<?php
	
	if(prijavljen()=="True"){
		$conn=conn();
		
		$sql="select * from ocjene where idzadatak='".$_GET["id"]."'";
		$rez=$conn->query($sql);
		if($rez->num_rows===0){
			$sql="INSERT INTO `ocjene` (`idzadatak`, `kor`, `ocjene`) VALUES ('".$_GET["id"]."', '|', '|0|0|0|0|0|')";
			$conn->query($sql);
		}
		$sql="select * from ocjene where idzadatak='".$_GET["id"]."'";
		$rez=$conn->query($sql);
		if($rez->num_rows===1){
			$row=$rez->fetch_assoc();
			
			$ocjene=$row["ocjene"];
			$kor=$row["kor"];
			
			$korisnici=explode("|",$kor);
			$l=explode("|",$ocjene);
			if(!in_array($_SESSION["userId"],$korisnici)){
				echo "<div class='ocjeniZadatak'>";
				echo "<br>";
				echo "<form method='post' >";
				echo "<p style='font-weight: bold;background-color: white;padding: 25px;color: #383838;'>Koliko ti se čini težak zadatak?</p>";
				echo "1<input type='radio' name='ocjena' value='1'>";
				echo " | 2<input type='radio' name='ocjena' value='2'>";
				echo " | 3<input type='radio' name='ocjena' value='3'>";
				echo " | 4<input type='radio' name='ocjena' value='4'>";
				echo " | 5<input type='radio' name='ocjena' value='5'>";
				echo "<br><input class='ocjeniZadatak' style='font-weight:bold;font-size:16px;' type='submit' value='Ocjeni zadatak'>";
				echo "</form>";
				echo "</div>";
			}
			else{
				echo "<p style='font-weight: bold;background-color: white;padding: 25px;color: #383838;'>Ocjena zadatka</p>";
			}
		}
		else{
			echo "Greška";
		}
		$conn->close();
	}
	else{
		echo "<p style='font-weight: bold;background-color: white;padding: 25px;color: #383838;'>Ocjena zadatka</p>Prijavite se kako biste mogli glasati!";
	}
	function ocjena($br){
		$conn=conn();
		
		$sql="select * from ocjene where idzadatak='".$_GET["id"]."'";
		$rez=$conn->query($sql);
		$conn->close();
		if($rez->num_rows===1){
			$row=$rez->fetch_assoc();
			
			$ocjene=$row["ocjene"];
			$l=explode("|",$ocjene);
			$x=$l[1]+$l[2]+$l[3]+$l[4]+$l[5];
			if($x===0){
				return "0%";
			}
			return round($l[$br]/$x*100, 2)."%";
		}
	}
	
?>
<div class="container">
  <div class="progress">
   <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ocjena(1); ?>">
      <?php echo "1: ".ocjena(1); ?>
    </div>
  </div>
  <div class="progress">
   <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ocjena(2); ?>">
      <?php echo "2: ".ocjena(2); ?>
    </div>
  </div>
  <div class="progress">
	<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ocjena(3); ?>">
      <?php echo "3: ".ocjena(3); ?>
    </div>
  </div>
  <div class="progress">
    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ocjena(4); ?>">
      <?php echo "4: ".ocjena(4); ?>
    </div>
  </div>
  <div class="progress">
	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ocjena(5); ?>">
      <?php echo "5: ".ocjena(5); ?>
    </div>
  </div>
  <br>
  <?php echo prosjek(); ?>
</div>
</div>