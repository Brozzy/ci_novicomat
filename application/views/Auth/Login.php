<header>
	<p>CodeIgniter Novicomat</p>
</header>

<div id="loginForm">
	<?php 
		echo validation_errors();
		$formAtr = array('class' => 'login', 'name' => 'Login');
		$data1 = array(
	              	'name'        => 'Username',
		            'id'          => 'username',
		            'placeholder' => 'Uporabnik',
		            'class'       => 'loginInput',
            	);

		$data2 = array(
	              	'name'        => 'Password',
		            'id'          => 'password',
		            'placeholder' => 'Geslo',
		            'class'       => 'loginInput',
            	);

		$login1 = 'class="loginInput"';
		$login2 = 'class="loginButton"';

		echo form_open('auth/login', $formAtr);
		echo "<br>";
		echo form_input($data1);
		echo "<br>";
		echo form_password($data2);
		echo "<br>";
		echo "<br>";
		echo form_button('forgetButton','Pozabil sem geslo', $login2, 'id="loginButton"');
		echo form_submit('submitButton', 'Prijava', $login2, 'id="regButton"');
		echo "<br>";
		echo form_button('regButton','Registracija', $login2, 'id="forgetButton"');
		echo "<br>";
		echo form_button('faceButton','Facebook prijava', $login2, 'id="facebookButton"');

		echo form_close();
	?>
</div>

<footer>
	<p>Copyrights Zelnik.net 2014</p>
</footer>
