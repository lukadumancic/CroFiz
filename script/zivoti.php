<?php
	include 'Funkcije.php';
	include 'session.php';
	
	if(prijavljen()=="True"){
		echo "<div class='zivoti'  style='display: inline-block;margin-top:5px;'>";
		for($i=0;$i<zivoti();$i++){
			echo "<img class='zivotMali' src='Slicice/zivot2+.png'>";
		}
		for($i;$i<3;$i++){
			echo "<img class='zivotMali' src='Slicice/zivot2-.png'>";
		}
		echo "</div>";
	}
?>