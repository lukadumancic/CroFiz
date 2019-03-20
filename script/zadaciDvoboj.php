<?php
	if(prijavljen()=="False"){
		header("Location: http://82.132.7.168/Main.php");
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

	<div class='povijestIgre opis2' style="background: url('Slicice/pobjedePorazi.jpg');background-size: cover;background-position: center; ">
		<p>Pobjede Porazi</p>
		<p id="winLose">
		</p>
	</div>
	<div class='opis2' style="background: url('Slicice/novaIgra.jpg');background-size: cover;background-position: center; ">
		<p class='tamnije'>Životi</p>
		<p>
			<?php
				for($i=0;$i<zivoti();$i++){
					echo "<img class='zivot' style='opacity: 0.9;' src='Slicice/zivot+.png'>";
				}
				for($i;$i<3;$i++){
					echo "<img class='zivot' style='opacity: 0.9;' src='Slicice/zivot-.png'>";
				}
			?>
		</p>
		<br>
		<?php
			if(zivoti()>0){
				echo "<p><a href='igra.php' class='novaIgra' target='_blank'>Nova igra</a></p>";
			}
			else{
				echo "<p><a href='igra.php' class='novaIgra' target='_blank'>Nova igra</a></p>";
				echo "<p>Nemate dovoljno života<br>Pričekajte</p>";
				echo "<p><span id='timer'></span></p>";
				echo "
				<script>
					var count=".odbrojavanje().";

					var counter=setInterval(timer, 1000);

					function timer()
					{
					  count=count-1;
					  if (count <= 0)
					  {
						 location.reload();
						 clearInterval(counter);
						 return;
					  }
						document.getElementById('timer').innerHTML=count + ' sekundi';
					}
				</script>
				";
			}
		?>
	</div>
	<?php include 'povijestIgre.php' ?>
	<br>
	<br>
	<br>
	
		
		<?php
		
		$conn=conn();
		$sql="SELECT * FROM dvoboj where idkorisnik1='".$_SESSION['userId']."' or idkorisnik2='".$_SESSION['userId']."' order by datum desc";
		$rez=$conn->query($sql);
		
		$win=0;
		$lose=0;
		$draw=0;
		
		if($rez->num_rows==0){
			//
		}
		else{
			while($row=$rez->fetch_assoc()){
					
					$l1=explode('|',$row["tocno1"]);
					$l2=explode('|',$row["tocno2"]);
					if(count($l1)!=count($l2)){
						//
					}
					else{
						$x1=0;
						$x2=0;
						for($i=0;$i<count($l1);$i++){
							if($l1[$i]=='-1'){
								$x1+=600;
							}
							else{
								$x1+=$l1[$i];
							}
							if($l2[$i]=='-1'){
								$x2+=600;
							}
							else{
								$x2+=$l2[$i];
							}
						}
						if($_SESSION["userId"]==$row["idkorisnik1"]){
							if($x1<$x2){
								$win++;
							}
							else if($x2>$x1){
								$lose++;
							}
							else{
								$draw++;
							}
						}
						else{
							if($x1>$x2){
								$win++;
							}
							else if($x2<$x1){
								$lose++;
							}
							else{
								$draw++;
							}
						}
					}
					
					
				
				}
					
						$l1=explode('|',$row["tocno1"]);
						$l2=explode('|',$row["tocno2"]);
						$x1=0;
						$x2=0;
						for($i=0;$i<count($l1);$i++){
							if($l1[$i]=='-1'){
								$x1+=600;
							}
							else{
								$x1+=$l1[$i];
							}
							if($l2[$i]=='-1'){
								$x2+=600;
							}
							else{
								$x2+=$l2[$i];
							}
						}
						if($_SESSION["userId"]==$row["idkorisnik1"]){
							if($x1<$x2){
								$win++;
							}
							else if($x2>$x1){
								$lose++;
							}
							else{
								$draw++;
							}
						}
						else{
							if($x1>$x2){
								$win++;
							}
							else if($x2<$x1){
								$lose++;
							}
							else{
								$draw++;
							}
						}
		}
		$WLD='<span style="color:#00FF00">'.$win.'</span><span style="color:#FF0000"> '.$lose.'</span>';
		
		echo "<script>
			var WLD='".$WLD."';
			document.getElementById('winLose').innerHTML+=WLD;
		
		
		</script>";
		?>
	
</div>



<?php

	
	
	function odbrojavanje(){
		$conn=conn();
		$sql="select zivoti from informacije where idkorisnik='".$_SESSION["userId"]."'";
		$rez=$conn->query($sql);
		if($rez->num_rows==0){
			$conn->close();
			return false;
		}
		$row=$rez->fetch_assoc();
		$t=time();
		$l=$row["zivoti"];
		$l=explode("|",$l);
		$t2=$l[2];
		$conn->close();
		return 12*3600-($t-$t2);
		
	}
?>