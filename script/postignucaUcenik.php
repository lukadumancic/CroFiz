<?php 
	if(!profesor2()){
		
		$conn=conn();
		$sql="select * from postignuca where id='".$_SESSION["userId"]."'";
		$rez=$conn->query($sql);
		
		$row=$rez->fetch_assoc();
		
		$dvoboj=$row["dvoboj"];
		$zadatak=$row["zadatak"];
		
		if($dvoboj>100){
			$dvobojTekst="1000 dvoboja";
		}
		
		if($dvoboj<100){
			$dvobojTekst="100 dvoboja";
		}
		
		if($dvoboj<20){
			$dvobojTekst="20 dvoboja";
		}
		
		if($dvoboj<5){
			$dvobojTekst="5 dvoboja";
		}
		
		if($dvoboj<1){
			$dvobojTekst="Prvi dvoboj";
		}
		
		
		
		
		if($zadatak>100){
			$zadatakTekst="1000 zadataka";
		}
		
		if($zadatak<100){
			$zadatakTekst="100 zadataka";
		}
		
		if($zadatak<20){
			$zadatakTekst="20 zadataka";
		}
		
		if($zadatak<5){
			$zadatakTekst="5 zadataka";
		}
		
		if($zadatak<1){
			$zadatakTekst="Prvi zadatak";
		}
		
		echo '<div style="text-align: -webkit-center;">
			<div class="paralelna2" style="background: url(\'Slicice/challenge.jpg\');background-size: cover;">
				<p>'.$dvobojTekst.'<br>Trenutno '.$dvoboj.'</p>
			</div>
						
			<div class="paralelna2" style="background: url(\'Slicice/learning.jpeg\');background-size: cover;">
				<p>'.$zadatakTekst.'<br>Trenutno '.$zadatak.'</p>
			</div>
					
		</div>';
		
		echo "<h1>Dodatna postignuća</h1>";
		
		echo "<div class='postignuce'>";
		if($row["objava"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Objavi nešto na naslovnoj stranici";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["odgovor"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Odgovori na neku temu";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["tema"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Otvori novu temu na forumu";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["ocjena"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Ocjeni bilo koji zadatak";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["mentor"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Pronađi svog mentora";
		echo "</div>";
		
	}
?>