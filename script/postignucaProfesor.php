<?php 
	if(profesor2()){
		
		$conn=conn();
		$sql="select * from postignuca where id='".$_SESSION["userId"]."'";
		$rez=$conn->query($sql);
		
		$row=$rez->fetch_assoc();
		
		$slanje=$row["slanje"];
		$izazov=$row["izazov"];
		$ucenici=$row["ucenici"];
		
		if($slanje>100){
			$slanjeTekst="1000 poslanih zadataka";
		}
		
		if($slanje<100){
			$slanjeTekst="100 poslanih zadataka";
		}
		
		if($slanje<20){
			$slanjeTekst="20 poslanih zadataka";
		}
		
		if($slanje<5){
			$slanjeTekst="5 poslanih zadataka";
		}
		
		if($slanje<1){
			$slanjeTekst="Prvi poslani zadatak";
		}
		
		
		
		
		if($izazov>100){
			$izazovTekst="1000 izazova";
		}
		
		if($izazov<100){
			$izazovTekst="100 izazova";
		}
		
		if($izazov<20){
			$izazovTekst="20 izazova";
		}
		
		if($izazov<5){
			$izazovTekst="5 izazova";
		}
		
		if($izazov<1){
			$izazovTekst="Prvi izazov";
		}
		
		
		
		
		if($ucenici>100){
			$uceniciTekst="1000 učenika";
		}
		
		if($ucenici<100){
			$uceniciTekst="100 učenika";
		}
		
		if($ucenici<20){
			$uceniciTekst="20 učenika";
		}
		
		if($ucenici<5){
			$uceniciTekst="5 učenika";
		}
		
		if($ucenici<1){
			$uceniciTekst="Prvi učenik";
		}
		
		echo '<div style="text-align: -webkit-center;">
			<div class="paralelna3" style="background: url(\'Slicice/kalkulator.jpg\');background-size: cover;">
				<p>'.$slanjeTekst.'<br>Trenutno '.$slanje.'</p>
			</div>
						
			<div class="paralelna3" style="background: url(\'Slicice/challenge.jpg\');background-size: cover;">
				<p>'.$izazovTekst.'<br>Trenutno '.$izazov.'</p>
			</div>
			
			<div class="paralelna3" style="background: url(\'Slicice/student.jpg\');background-size: cover;">
				<p>'.$uceniciTekst.'<br>Trenutno '.$ucenici.'</p>
			</div>
					
		</div>';
		
		
		echo "<h1>Dodatna postignuća</h1>";
		
		echo "<div class='postignuce'>";
		if($row["objava"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Objavavite nešto na naslovnoj stranici";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["odgovor"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Odgovorite na neku temu";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["tema"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Otvorite novu temu na forumu";
		echo "</div>";
		
		echo "<div class='postignuce'>";
		if($row["ocjena"]=='1'){
			echo "<img style='width:30px;height:30px;' src='Slicice/check.png'>";
		}
		echo " Ocjenite bilo koji zadatak";
		echo "</div>";
		
		
		
		
	}
?>