<div class='paralelna1' style="background: url('Slicice/dokumenti.jpg');background-size: cover;background-position: center; ">
	<p>Slanje poruke</p>
	<form method='post' action='slanjePoruke.php'>
		<div class="ui-widget" style="display:inline;">
			<label for="primatelji"></label>
			<input name="primatelji" id="primatelji" placeholder="Primatelj" value="<?php if(isset($_POST['primatelj2'])){echo $_POST['primatelj2'];} ?>" required>
		</div>
		<br>
		<input style='width: 230px;' type='text' name='naslov' value="<?php if(isset($_POST['naslov2'])){echo $_POST['naslov2'];} ?>" placeholder="Naslov" required>
		<textarea class="poruka" name="poruka" cols="40" rows="5" placeholder="Poruka" required><?php if(isset($_POST['poruka2'])){echo $_POST['poruka2'];}else{echo $_SESSION["korisnickoIme"].": ";} ?></textarea>
		<br>
		<input style='font-size: 25px;width: auto;height: auto;' type='submit' value='Pošalji'>
	</form>
	</p>
</div>