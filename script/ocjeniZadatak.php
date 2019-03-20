<?php
if(prijavljen()=="True"){
		if(isset($_POST["ocjena"])){
			$conn=conn();
			
			$sql="select * from ocjene where idzadatak='".$_GET["id"]."'";
			$rez=$conn->query($sql);
			if($rez->num_rows===1){
				$row=$rez->fetch_assoc();
				
				$kor=$row["kor"];
				$ocjene=$row["ocjene"];
				
				$korisnici=explode("|",$kor);
				$l=explode("|",$ocjene);
				
				if(!in_array($_SESSION["userId"],$korisnici)){
					$l[$_POST["ocjena"]]++;
					$ocjene=implode("|", $l);
					$kor.=$_SESSION["userId"]."|";
					$sql="UPDATE `ocjene` SET `kor`='$kor', `ocjene`='$ocjene' WHERE `id`='".$row['id']."'";
					$conn->query($sql);
				}
				dodatnaPostignuca("ocjena",$_SESSION["userId"]);
			}
		$conn->close();
	}
}
?>