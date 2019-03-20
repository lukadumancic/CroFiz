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
		
		
		<article id="art">
		
			<div id="extraNavigation">
				<a class='extraNavLink' id='extraNavForum' href="?br=Forum">Forum</a>
				<a class='extraNavLink' id='extraNavForumZadataka' href="?br=ForumZadataka">Forum zadataka</a>
			</div>
			
			<?php
				if(isset($_GET["br"])){
					$br=$_GET["br"];
					if($br=="Forum"){
						include "forumForum.php";
					}
					else{
						include "forumForumZadataka.php";
					}
				}
				else{
					include "forumOsnovno.php";
				}
			?>
			
			
			
			<script>
				a="<?php if(isset($_GET["br"])){echo $_GET["br"];}?>";
				if(a!=""){
					document.getElementById("extraNav"+a).className+=" extraNavSelected";
				}
			</script>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php	
		?>
	</body>
</html>