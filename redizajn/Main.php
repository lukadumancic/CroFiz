<html>
	<head>
		<title>
			Gabric photography
		</title>
		
		<style>
			body{
				background-color:black;
			}
			.logo{
				width: 150px;
				padding-left: 20px;
				display:inline;
			}
			.navigacija{
				background-color: #000;
				width:100%
			}
			.linkovi{
				display: inline;
				right: 2px;
				position: absolute;
			}
			.linkovi > a{
				text-decoration:none;
				padding: 10px;
				color: white;
				font-weight: bold;
				font-size: 18px;
				margin-left: 10px;
			}
			.linkovi > a:hover{
				text-decoration:none;
				color:#b10c0c;
			}
			article{
				background-color: black;
				color:white;
			}
			nav{
				position: fixed;
				width:100%;
			}
			.slika{
				width: 60%;
				margin-left: 10%;
				margin-bottom: 5%;
			}
			.slikanavigacija{
				width: 10%;
				margin-bottom: 3%;
				display:block;
				margin-left: 83%;
			}
			#slike{
				display:inline;
			}
			#slikenavigacija{
				display:inline;
				position:fixed;
				top: 10%;
				width: 100%;
				right: 1px;
			}
		</style>
		
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	
	</head>
	
	<body>
		<nav>
			<div class='navigacija'>
				<img class='logo' src='slike/logo2.png'>
				<div class='linkovi'>
					<a href='Main.php'>Home</a>
					<a href='Portfolio.php'>Portfolio</a>
					<a href='Contact.php'>Contact</a>
				</div>
			</div>
		</nav>
		<article>
			<div id="slike">
			</div>
			
			<div id="slikenavigacija">
			</div>
			
			<script>
				for(i=1;i<9;i++){
					document.getElementById("slike").innerHTML+="<img class='slika' id='"+i.toString()+"' draggable='false' src='slike2/"+i.toString()+".jpg'>";
					document.getElementById("slikenavigacija").innerHTML+="<a href='#"+i+"'><img id='nav"+i+"' class='slikanavigacija' draggable='false' src='slike2/"+i+".jpg'></a>";
				}
			</script>
		</article>
	</body>


</html>