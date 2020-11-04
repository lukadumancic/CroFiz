<?php
	//Pokretanje sessiona
	session_start();
	//Ako nisu postavljene session varijable tada ih treba postaviti
	if(!isset($_SESSION["nick"])){$_SESSION["nick"]="*%test%*";}
	if(!isset($_SESSION["pass"])){$_SESSION["pass"]="*%test%*";}
?>
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
						<a class='main' href='http://34.121.205.40/Connectihno.php'>Chat</a>
						<?php if(!loged())echo"<p style='font-size:25px;display:inline;'>/</p>
						<a class='reg' href='http://34.121.205.40/Registration.php'>Registration</a>
						<p style='font-size:25px;display:inline;'>/</p>
						<a class='log' href='http://34.121.205.40/LogIn.php'>LogIn</a>";
						else{
							echo "
							<p style='font-size:25px;display:inline;'>/</p>
							<a class='main' href='http://34.121.205.40/Profile.php'>Profile</a>
							<p style='font-size:25px;display:inline;'>/</p>
							<a class='main' style='color:red;' href='http://34.121.205.40/LogOut.php'>LogOut</a>";
						}?>

					</div>
				</nav>
			</div>
			<article>
				<h2 style='color:black;font-size:35px;margin-top: -35px;'>Connectihno registration</h2><br>
				
				<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.0.0/annyang.min.js"></script>
				<script>
					if (annyang) {
					  var commands = {
						'go to *term':function(term){
							if(term=='chat'){term='Connectihno';}
							window.location='http://34.121.205.40/'+term+'.php';
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
				
				<script>
					function checkPass(){
						if(document.getElementById("pass2").value==document.getElementById("pass").value){
							document.getElementById("pass2").style.border="4px solid #06DE26";
							document.getElementById("pass").style.border="4px solid #06DE26";
						}
						else{
							document.getElementById("pass2").style.border="4px solid #DE0606";
							document.getElementById("pass").style.border="4px solid #DE0606";
						}
					}
				</script>
				
				<?php echo reg(); ?>
				
				<form method='post'>
					<input type='text' name='nick' placeholder='Nickname' required><br>
					<input type="password" id="pass" placeholder="Password" name="pass" onchange="checkPass()" required>
					<input type="password" id="pass2" placeholder="Password*" name="pass2" onchange="checkPass()" required><br>
					<input type="submit" value="Register">
				</form>
				
		
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
			function reg(){
				if(isset($_POST["nick"]) and isset($_POST["pass"]) and isset($_POST["pass2"])){
					if($_POST["pass"]===$_POST["pass2"]){
						if(strlen($_POST["pass"])>5){
							$servername = "35.238.67.22";
							$username = "root";
							$password = "124578";
							$dbname = "crofiz";

							$conn = new mysqli($servername, $username, $password, $dbname);
							
							$sql="select * from users where nick='".$_POST["nick"]."'";
							$rez=$conn->query($sql);
							if($rez->num_rows===0){
								$sql="INSERT INTO `users` (`nick`, `pass`) VALUES ('".$_POST["nick"]."', '".$_POST["pass"]."')";
								$conn->query($sql);
								$conn->close();
								return "Registration completed<br>Please procede to the LogIn page";
							}
							else{
								$conn->close();
								return "Nickname already exists";
							}
						}
						else{
							return "Password is too short";
						}
					}
					else{
						return "Passwords DO NOT match!";
					}
				}
				else{
					return "Please fill all fields";
				}
			}
		?>
</html>