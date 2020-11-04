<?php
	include 'Funkcije.php';
	include 'session.php';
	if(isset($_POST["rjesenje"]) and isset($_POST["tekst"]) and isset($_POST["mjernaJedinica"]) and isset($_POST["id"])){
		$conn=conn();
		if(mojZadatak()){
			$sql="UPDATE `izazovizadaci` SET `tekst`='".$_POST["tekst"]."', `rjesenje`='".$_POST["rjesenje"]."', `mjernaJedinica`='".$_POST["mjernaJedinica"]."' WHERE `id`='".$_POST["id"]."'";
			$conn->query($sql);
			if($_FILES['slika']['size'] > 0){
						
				$fileType = $_FILES['slika']['type'];
					
				$data= addslashes($_FILES['slika']['tmp_name']);
				$name= addslashes($_FILES['slika']['name']);
				$data= file_get_contents($data);
				$data= base64_encode($data);
				$sql="INSERT INTO `slike` (`type` ,`data` ,`idzadatak`) VALUES ('$fileType' ,'$data', '".$_POST["id"]."')";
				$conn->query($sql);
				unesiBrojJedan();
			}
			$conn->close();
		}
	}
	function mojZadatak(){
		$conn=conn();
		$sql="select idgrupe from izazovizadaci where `id`='".$_POST["id"]."'";
		$rez=$conn->query($sql);
		if($rez->num_rows===0){
			return False;
		}
		else{
			$row=$rez->fetch_assoc();
			$conn->close();
			$idGrupe=$row["idgrupe"];
			return glavaGrupe($idGrupe);
		}
	}
	function unesiBrojJedan(){
		$conn=conn();
		$sql="select idzadaci,slike from izazovi WHERE `id`='".$_POST["idGL"]."'";
		$rez=$conn->query($sql);
		if($rez->num_rows>0){
			$row=$rez->fetch_assoc();
			$sl=$row["slike"];
			$zad=$row["idzadaci"];
			$slike=explode('|',$sl);
			$zadaci=explode('|',$zad);
			$slk="|";
			for($i=0;$i<sizeof($zadaci);$i++){
				$id=$zadaci[$i];
				$slika=$slike[$i];
				if($id==""){
					continue;
				}
				if($id==$_POST["id"]){
					$slk.="1|";
				}
				else{
					$slk.=$slika."|";
				}
			}
			$sql="UPDATE `izazovi` SET `slike`='".$slk."' WHERE `id`='".$_POST["idGL"]."'";
			$conn->query($sql);
		}
		$conn->close();
	}
?>
<script>
	window.location="http://34.121.205.40/Izazov.php?id=<?php echo $_POST["idGL"]; ?>";
</script>