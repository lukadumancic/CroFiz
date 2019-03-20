			<div id="arhiva" style='margin-top:5px'>
				<div class='opis2' style="background: url('Slicice/arhiva-banner.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Arhiva zadataka</strong>
				</div>
				
				<div class='opis2'>
					Arhiva je mjesto gdje možete pronaći sve zadatke!
				</div>
				
				<div>
					<?php 
						$conn=conn();
						for($i=1;$i<5;$i++){
							$sql="select * from zadaci where razred=$i";
							$rez=$conn->query($sql);
							echo "<div class='paralelna4' style='background: url(\"Slicice/razred$i.jpg\");background-size: cover;'>";
							echo "<p>$i. Razred</p><br>";
							while($row=$rez->fetch_assoc()){
								echo "<p><a href='Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</p>";
							}
							echo "</div>";
						}
					?>
				</div>
					
					
				</script>
				
			</div>