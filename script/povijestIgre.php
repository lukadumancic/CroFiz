 <meta charset="utf-8">
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
			<?php
		
				$conn=conn();
				$sql="SELECT * FROM dvoboj where idkorisnik1='".$_SESSION['userId']."' or idkorisnik2='".$_SESSION['userId']."' order by datum desc limit 10";
				$rez=$conn->query($sql);
				
				$win=0;
				$lose=0;
				$draw=0;
				
				if($rez->num_rows==0){
					echo '<div class="swiper-slide">';
					echo "<p class='tamnije'>Nemate odigranih igara</p>";
					echo "</div>";
				}
				else{
					while($row=$rez->fetch_assoc()){
						
						echo '<div class="swiper-slide">';
							
							$l1=explode('|',$row["tocno1"]);
							$l2=explode('|',$row["tocno2"]);
							$zad=explode('|',$row["idzadaci"]);
							if(count($l2)!=count($zad) or count($l1)!=count($zad)){
								echo "<p class='nijeZavrseno'>U tijeku</p>";
								if($_SESSION["userId"]==$row["idkorisnik1"]){
									if(count($zad)!=count($l1)){
										echo "<form method='post' action='igra.php'><input type='hidden' name='id' value='".$row['id']."'><input class='odigraj' type='submit' value='Odigraj'></form><br>";
									}
								}
								else{
									if(count($zad)!=count($l2)){
										echo "<form method='post' action='igra.php'><input type='hidden' name='id' value='".$row['id']."'><input class='odigraj' type='submit' value='Odigraj'></form><br>";
									}
								}
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
										echo "<p class='pobjeda'>Pobjeda</p>";
										$win++;
									}
									else if($x2>$x1){
										echo "<p class='poraz'>Poraz</p>";
										$lose++;
									}
									else{
										echo "Nerješeno";
										$draw++;
									}
								}
								else{
									if($x1>$x2){
										echo "<p class='pobjeda'>Pobjeda</p>";
										$win++;
									}
									else if($x2<$x1){
										echo "<p class='poraz'>Poraz</p>";
										$lose++;
									}
									else{
										echo "Nerješeno";
										$draw++;
									}
								}
								echo "<p style='font-size:15px;'>".obradiDatum($row["datum"])."</p>";
							}
							
							//Prvi
							echo "<div class='igrac'>
							<a href='Profil.php?nick=".getNick($row['idkorisnik1'])."'>
							".vecaSlika($row['idkorisnik1'])."<br>
							".imePrezime($row['idkorisnik1'])."
							</a>
							</div>";
							
							//Drugi
							if($row['idkorisnik2']!=""){
								echo "<div class='igrac'>
								<a href='Profil.php?nick=".getNick($row['idkorisnik2'])."'>
								".vecaSlika($row['idkorisnik2'])."<br>
								".imePrezime($row['idkorisnik2'])."
								</a>
								</div>";
							}
							else{
								echo "<div class='igrac'>
								".vecaSlika('0')."<br>
								??? ???
								
								</div>";
							}
							
							echo "</div>";
					}
				}
				
				
				?>
            
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Swiper JS -->
    <script src="../dist/js/swiper.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
    </script>