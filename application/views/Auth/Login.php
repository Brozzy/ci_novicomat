<header>
	<p>CodeIgniter Novicomat</p>
</header>

<div id="loginForm">
	<?php echo form_open('auth/login'); ?>
		<p>Prijava</p>
		<input class="login" name="username" type="text" placeholder="Username"><br>
		<input class="login" name="password" type="text" placeholder="Password"><br>
		<input class="login" id="loginButton" type="submit" value="Prijava">
		<a href="www.google.si"><input class="login" id="regButton" type="button" value="Registracija"></a><br>
		<a href="www.google.si"><input class="login" id="forgetButton" type="button" value="Pozabil sem geslo"></a><br>
	<?php echo form_close(); ?>
</div>

<footer>
	<p>Copyrights Zelnik.net 2014</p>
</footer>