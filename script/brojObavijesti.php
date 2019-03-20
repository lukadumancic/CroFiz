<?php 
	include 'Funkcije.php';
	session_start();

	echo brojObavijesti();

	function brojObavijesti(){
		if(prijavljen()=="True"){
			$conn=conn();
			$sql="select obavijest from obavijesti where `idkorisnik`='".$_SESSION["userId"]."' and pogledano='0'";
			$rezultat=$conn->query($sql);
			$x=$rezultat->num_rows;
			if($x>=10){
				$x=9;
			}
			$conn->close();
			return $x;
		}
	}
?>