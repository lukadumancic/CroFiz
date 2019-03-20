<?php
	
	
	
	$conn=conn();
	
	$sql="select idkorisnik,xp from informacije order by xp desc";
	$rez=$conn->query($sql);
	echo "<table>";
	echo "<tr>";
	echo "<td>Rank</td>";
	echo "<td>Korisnik</td>";
	echo "<td>XP</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "</tr>";
	$i=0;
	while($row=$rez->fetch_assoc()){
		$i++;
		if($i>10){
			if($row["idkorisnik"]==$_SESSION["userId"]){
				echo "<tr>";
				echo "<td>...</td>";
				echo "<td>...</td>";
				echo "<td>...</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".finiIspis($row["idkorisnik"], $i)."</td>";
				echo "<td>".$row["xp"]."</td>";
				echo "</tr>";
			}
		}
		else{
			echo "<tr>";
			echo "<td>".$i."</td>";
			echo "<td>".finiIspis($row["idkorisnik"], $i)."</td>";
			echo "<td>".$row["xp"]."</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	$conn->close();
	
	function finiIspis($id, $i){
		$conn=conn();

		if($i==1){
			$klasa="gold";
		}
		else if($i==2){
			$klasa="silver";
		}
		else if($i==3){
			$klasa="bronze";
		}
		else{
			$klasa="poredak";
		}
		$sql="select ime,prezime,nick from korisnici where id='$id'";
		$rezultat=$conn->query($sql);
		$row=$rezultat->fetch_assoc();
		$conn->close();
		return "<a class='".$klasa."' href='Profil.php?nick=".$row["nick"]."'>".$row["ime"]." ".$row["prezime"]."</a>";
	}
?>