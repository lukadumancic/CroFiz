<?php include 'session.php'; ?>
<html>
		<head>
			<link rel="stylesheet" type="text/css" href="Style.css">
			<title>Connectihno</title>
		</head>
		<body>
			<div class="fixed">
				<header>
					<h1 style="display:inline;color:white;">Connectihno</h1>
					<br>
				</header>
				<nav>
					<div id="nav">
						<a class='main' href='http://localhost/Connectihno.php'>Chat</a>
						<?php if(!loged())echo"<p style='font-size:25px;display:inline;'>/</p>
						<a class='reg' href='http://localhost/Registration.php'>Registration</a>
						<p style='font-size:25px;display:inline;'>/</p>
						<a class='log' href='http://localhost/LogIn.php'>LogIn</a>";
						else{
							echo "
							<p style='font-size:25px;display:inline;'>/</p>
							<a class='main' href='http://localhost/Profile.php'>Profile</a>
							<p style='font-size:25px;display:inline;'>/</p>
							<a class='main' style='color:red;' href='http://localhost/LogOut.php'>LogOut</a>";
						}?>

					</div>
				</nav>
			</div>
			<article>
				<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.0.0/annyang.min.js"></script>
				<script>
					if (annyang) {
					  var commands = {
						'go to *term':function(term){
							if(term=='chat'){term='Connectihno';}
							window.location='http://localhost/'+term+'.php';
						}
					  };
					
					  annyang.addCommands(commands);
					  // Start listening. You can call this here, or attach this call to an event, button, etc.
					  annyang.start();
					}
					function Note(x){
						document.getElementById("note").innerHTML=x;
					}
				</script>
			<?php
			if(!loged()){
				echo login();
				echo "
				<h2 style='color:black;font-size:35px;margin-top: -35px;'>Connectihno LogIn</h2><br>
				
				
				<form method='post'>
					<input type='text' name='nick' placeholder='Nickname' required>
					<input type='password' id='pass' placeholder='Password' name='pass' required>
					<input type='submit' value='LogIn'>
				</form>";
				
			}
			else{
				echo "<script>window.location='http://localhost/Connectihno.php';</script>";
			}
			?>
			</article>
			<footer>
				<strong>Connectihno © 2015. - All rights reserved</strong>
			</footer>
		</body>
		<?php
			function loged(){
				if($_SESSION["nick"]=="*%test%*" and $_SESSION["pass"]=="*%test%*"){
					return False;
				}
				else{
					return True;
				}
			}
			function login(){
				if(isset($_POST["nick"]) and isset($_POST["pass"])){
					$servername = "82.132.7.168";
					$username = "admin";
					$password = "124578";
					$dbname = "crofiz";

					$conn = new mysqli($servername, $username, $password, $dbname);
							
					$sql="select * from users where nick='".$_POST["nick"]."' and pass='".$_POST["pass"]."'";
					$rez=$conn->query($sql);
					$conn->close();
					if($rez->num_rows===1){
						$_SESSION["nick"]=$_POST["nick"];
						$_SESSION["pass"]=$_POST["pass"];
						return "<script>window.location='http://localhost/Connectihno.php';</script>";

					}
					else{
						return "Wrong password or nickname!";
					}
				}
			}
		?>
</html>