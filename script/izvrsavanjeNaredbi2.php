<?php 
	
	include 'Funkcije.php';
	$conn=conn();
	$rez=$conn->query("SELECT * FROM `izvrsavanje`");
	if($rez->num_rows>0){
		echo "1";
		$row=$rez->fetch_assoc();
		$izvrsi=exec($row["naredba"]);
		echo $izvrsi;
	}
	else{
		echo "0";
	}
	$conn->close();
?>
<script>

function refresh(){
	window.location.reload(true);
}

setTimeout(refresh, 60000);
</script>