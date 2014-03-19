<header>
	<p>CodeIgniter Novicomat</p>
</header>

<div id="loginForm">
	<?php 
		$attributes = array('class' => 'login', 'name' => 'Login');
		echo form_open('auth/login', $attributes);
	?>
		<p>Prijava</p>
		<input class="login" name="Username" type="text" placeholder="Username"><br>
		<input class="login" name="Password" type="text" placeholder="Password"><br>
		<input class="login" id="loginButton" type="submit" value="Prijava">
		<a href="www.google.si"><input class="login" id="regButton" type="button" value="Registracija"></a><br>
		<a href="www.google.si"><input class="login" id="forgetButton" type="button" value="Pozabil sem geslo"></a><br>
	<?php echo form_close(); ?>
</div>
<?php if(isset($Error)) echo "<small style='color:red;'>".$Error."</small>"; ?>

<footer>
	<p>Copyrights Zelnik.net 2014</p>
</footer>
