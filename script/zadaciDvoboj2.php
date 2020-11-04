<?php
	if(prijavljen()=="True"){
		header("Location: http://localhost/Main.php");
		die();
	}
?>
<div id="dvoboj" style='margin-top: 5px;'>
	<div class='opis2' style="background: url('Slicice/challenge2.jpg');background-size: cover;background-position: center; ">
		<strong class='naslovStranice'>Dvoboj</strong>
	</div>
	
	<div class='opis2'>
		Na stranicama <strong>Dvoboja</strong> se možete boriti s drugim igračima ili svojim prijateljima u rješavanju zadataka
	</div>
	<?php
		include "prijaviteSe.php";
	?>
</div>