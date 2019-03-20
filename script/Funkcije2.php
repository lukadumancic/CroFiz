<?php
	//Funkcije za koje je potreban session
	
	function glavaGrupe($id){
		$conn=conn();

		$mojId=$_SESSION["userId"];
		$sql="select * from grupe where mentorid='$mojId' and id='$id'";
		$rez=$conn->query($sql);
		$conn->close();
		if($rez->num_rows===0){
			return False;
		}
		else{
			return True;
		}
	}
?>