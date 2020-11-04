<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<head>
			<?php include 'head.php';?>
		</head>
		<body>
		
		<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
		<?php include 'navigacija.php';?>
		<script>
			//Dodatak navigaciji
			$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == 'http://34.121.205.40/Zadaci.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		<article>
		
			<div class='opis2' style="background: url('Slicice/banner-naslovna.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Ranklista</strong>
			</div>
			
			<div class='opis2'>
				Pratite one koji najbolje i najbrže rješavaju zadatke na <strong>CroFiz</strong>-u
			</div>
			
			<div>
				<?php
					for($i=1;$i<5;$i++){
						echo "<div class='paralelna2' style='background: url(\"Slicice/razred$i.jpg\");background-size: cover;'>";
						echo "<p>$i. razred";
						echo ranking($i);
						echo "</div>";
					}
				?>
			</div>
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php
			function ranking($razred){
				$conn=conn();
					$sql="select * from ranklista where razred=$razred order by bodovi desc limit 10";
					$rez=$conn->query($sql);
					$conn->close();
					if($rez->num_rows===0){
						return "<p><strong>Nema rezultata</strong></p>";
					}
					else{
						$ret="";
						$rank=0;
						$ret.="<table>";
						$ret.="<td>Rank</td>";
						$ret.="<td>Korisnik</td>";
						$ret.="<td>Bodovi</td>";
						while($row=$rez->fetch_assoc()){
							$rank+=1;
							if($rank==1){
								$ret.="<tr class='gold'>";
								$gold=$row["idkorisnik"];
							}
							else if($rank==2){
								$ret.="<tr class='silver'>";
								$silver=$row["idkorisnik"];
							}
							else if($rank==3){
								$ret.="<tr class='bronze'>";
								$bronze=$row["idkorisnik"];
							}
							else{
								$ret.="<tr>";
							}
							$ret.="<td>".$rank."</td>";
							$ret.="<td>".infoKorisnik($row["idkorisnik"])."</td>";
							$ret.="<td>".$row["bodovi"]."</td>";
							$ret.="</tr>";
						}
						$ret.="</table>";
						return $ret;
					}
					
			}
			function infoKorisnik($id){
				$conn=conn();
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://34.121.205.40/Profil.php?nick=".$row["nick"]."'>".$row["ime"]." ".$row["prezime"]."</a>";
				
			}
		?>
	</body>
</html>