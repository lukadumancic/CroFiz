<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<script>
	a="<?php
		if(prijavljen()=="True"){
			echo "1";
		}
	?>"
	if(a==1){
		window.location="http://34.121.205.40/Naslovna.php";
	}
</script>

<html>
	<head>
		<?php include 'head2.php';?>
	</head>
	<body  onload = "pokreni()">
		<script>
			function pokreni(){
				startTime();
			}
		</script>
		
		<?php include 'regBoxes2.php';?>
		<?php include 'navigacija2.php';?>
		
		
		
		
		
		
	</body>
</html>