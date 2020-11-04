<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://crofiz.com/Main.php");
		die();
	}
	else if(prijavljen()=="True"){
		if(!mojaGrupa()){
			header("Location: http://crofiz.com/Grupe.php");
			die();
		}
		if(!glava()){
			header("Location: http://crofiz.com/Grupa.php?id=".$_GET["id"]);
			die();
		}
	}
?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php include 'head.php';?>
	</head>
	<body>
		<?php include 'navigacija.php';?>
		<script>
			//Dodatak navigaciji
			$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == 'http://crofiz.com/Grupe.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		<article id="art">
			<?php promjenaImena(); ?>
			<?php promjenaOpisa(); ?>
			<?php dodavanjeUcenika(); ?>
			<?php izbaci(); ?>
			<?php echo slikaPost(); ?>
			<?php echo brisanje(); ?>
			
			
			<div class='opis2' style="background: url('Slicice/postavke-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Postavke grupe</strong>
				<p><a class='grupa' href='http://crofiz.com/Grupa.php?id=<?php echo $_GET["id"]; ?>' ><?php echo imeGrupe(); ?></a></p>
			</div>
			
			<div style='background-color:#333333;padding: 1px;'>
				<form method='post'>
					<p class='tamnije2'>Ime grupe</p> 
					<input type='text' name='ime' value='<?php echo imeGrupe(); ?>' required><br>
					<input type='submit' class='postavi' value='Postavi ime'>
				</form>
				<p style='background-color: #696969;padding: 1px;'></p>
				
				<form method='post'>
					<p class='tamnije2'>Opis</p> 
					<textarea style='width: 500px;height: 50px;' name='tekst'><?php echo tekstGrupe(); ?></textarea><br>
					<input type='submit' class='postavi' value='Postavi opis'>
				</form>
				<p style='background-color: #696969;padding: 1px;'></p>
				
				<form method='post' enctype="multipart/form-data">
					<p class='tamnije2'>Slika</p>
					<input style='color: white' type='file' name='image' value='1'><br>
					<input type='submit' class='postavi' value='Postavi sliku'>
				</form>
				<p style='background-color: #696969;padding: 1px;'></p>
				
				<?php echo dohvatiTkoNijeClanGrupe(); ?>
				<p style='background-color: #696969;padding: 1px;'></p>
				<?php echo izbaciClanaGrupe(); ?>
				<p style='background-color: #696969;padding: 1px;'></p>
				
				
				<form method='post' style='padding:50px;'>
					<input type='hidden' name='brisanje' value='1'>
					<input type='submit' class='postavi' value='Obirši grupu'>
				</form>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php'; ?>
		</footer>
		
		<?php
			function imeGrupe(){
				$conn=conn();
				$id=$_GET["id"];
				$sql="select ime from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["ime"];
			}
			function tekstGrupe(){
				$conn=conn();
				$id=$_GET["id"];
				$sql="select opis from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["opis"];
			}
			function slikaPost(){
					if(isset($_FILES['image'])) {
						$conn=conn();
						
						$image= addslashes($_FILES['image']['tmp_name']);
						$name= addslashes($_FILES['image']['name']);
						$image= file_get_contents($image);
						$image= base64_encode($image);
						$sql="UPDATE `grupe` SET `br`='0' WHERE `id`='".$_GET['id']."';";
						$conn->query($sql);
						saveimage($name,$image);
						$conn->close(); 
					}
			}
			function saveimage($name,$image){
               $conn=conn();
                $sql="UPDATE `grupe` SET `slika`='$image' WHERE `id`='".$_GET['id']."';";
                $conn->query($sql);
				$conn->close(); 
            }
			function glava(){
				$conn=conn();
				$id=$_GET["id"];
				$mojId=getId($_SESSION["korisnickoIme"]);
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
			function mojaGrupa(){
				$conn=conn();
				$id=$_GET["id"];
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select mentorid from korisnici where id=$mojId";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$mentorId=$row["mentorid"];
				$sql="select * from grupe where mentorid='$mentorId' and idkor='-1' or id='$id' and (idkor like '|$mojId|' or idkor like '%|$mojId|' or idkor like '|$mojId|%' or idkor like '%|$mojId|%' or mentorid='$mojId')";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===0){
					return False;
				}
				else{
					return True;
				}
			}
			function promjenaImena(){
				if(isset($_POST["ime"])){
					$conn=conn();
					$sql="UPDATE `grupe` SET `ime`='".$_POST["ime"]."' WHERE `id`='".$_GET["id"]."'";
					$conn->query($sql);
					$conn->close();
				}
			}
			function promjenaOpisa(){
				if(isset($_POST["tekst"])){
					$conn=conn();
					$sql="UPDATE `grupe` SET `opis`='".$_POST["tekst"]."' WHERE `id`='".$_GET["id"]."'";
					$conn->query($sql);
					$conn->close();
				}
			}
			function dohvatiTkoNijeClanGrupe(){
					$conn=conn();
					$sql="select idkor from grupe where `id`='".$_GET["id"]."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$clanovi=$row["idkor"];
					echo "<p class='tamnije2'>Dodavanje učenika u grupu:</p>";
					if($clanovi=="-1"){
						$conn->close();
						return "Svi učenici su u grupi";
					}
					else{
						$sql="select id from korisnici where mentorid=".getId($_SESSION["korisnickoIme"]);
						$rez=$conn->query($sql);
						if($rez->num_rows>0){
							echo "<form method='post'>";
							echo "<select name='dodajClana'>";
							while($row=$rez->fetch_assoc()){
								if(!strpos($clanovi,$row["id"])>0){
									echo "<option value=".$row["id"].">".getNick($row["id"])."</option>";
								}
							}
							echo "</select>";
							echo "<br><input type='submit' class='postavi' value='Dodaj'>";
							echo "</form>";
						}
						else{
							echo "Svi učenici su već u grupi";
						}
					}
					$conn->close();
				}
			
			function dodavanjeUcenika(){
				if(isset($_POST["dodajClana"])){
					$conn=conn();
					$sql="select idkor from grupe where `id`='".$_GET["id"]."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$clanovi=$row["idkor"];
					$clanovi.=$_POST["dodajClana"]."|";
					$sql="UPDATE `grupe` SET `idkor`='$clanovi' WHERE `id`='".$_GET["id"]."'";
					$conn->query($sql);
					$conn->close();
				}
			}
		function izbaciClanaGrupe(){
					$conn=conn();
					$sql="select idkor from grupe where `id`='".$_GET["id"]."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$clanovi=$row["idkor"];
					echo "<p class='tamnije2'>Izbacivanje učenika u grupu:</p>";
					if($clanovi=="-1"){
						$conn->close();
						return "Nije moguće izbaciti učenika iz grupe";
					}
					else{
						$sql="select id from korisnici where mentorid=".getId($_SESSION["korisnickoIme"]);
						$rez=$conn->query($sql);
						if($rez->num_rows>0){
							echo "<form method='post'>";
							echo "<select name='izbaciClana'>";
							while($row=$rez->fetch_assoc()){
								if(strpos($clanovi,$row["id"])>0){
									echo "<option value=".$row["id"].">".getNick($row["id"])."</option>";
								}
							}
							echo "</select>";
							echo "<br><input type='submit' class='postavi' value='Izbaci'>";
							echo "</form>";
						}
						else{
							echo "Nemate učenike";
						}
					}
					$conn->close();
				}
		function izbaci(){
				if(isset($_POST["izbaciClana"])){
					$conn=conn();
					$sql="select idkor from grupe where `id`='".$_GET["id"]."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$clanovi=$row["idkor"];
					$clan="|".$_POST["izbaciClana"];
					$clanovi=str_replace($clan, "", $clanovi);
					$sql="UPDATE `grupe` SET `idkor`='$clanovi' WHERE `id`='".$_GET["id"]."'";
					$conn->query($sql);
					$conn->close();
				}
			}
		function brisanje(){
			if(isset($_POST["brisanje"])){
				$conn=conn();
					$sql="UPDATE `grupe` SET `mentorid`='0', `idkor`='' WHERE `id`='".$_GET["id"]."'";
					$conn->query($sql);
					$conn->close();
					return "<script>window.location='http://crofiz.com/Grupe.php';</script>";
			}
		}
		?>
	</body>
</html>