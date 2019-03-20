<?php 
	include 'Funkcije.php';
	session_start();

	echo brojPoruka();

	function brojPoruka(){
		if(prijavljen()=="True"){
			$conn=conn();
			$sql="select id from poruke where `primatelj`='".$_SESSION["userId"]."' and pogledano='0'";
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