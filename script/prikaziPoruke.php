<?php

	if(isset($_POST["poruka"]) and isset($_POST["naslov"])){
		echo $html=$_POST["naslov"]."<br>".$_POST["poruka"];
		echo "<script>";
		echo 'document.getElementById("poruka").style.display="block";';
		echo "</script>";
	}


?>