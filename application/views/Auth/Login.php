<header>
	<p>CodeIgniter Novicomat</p>
</header>

<section id="loginForm">
	<?php 
		echo validation_errors();
		$formAtr = array('class' => 'login', 'name' => 'Login');
		$userAtr = array(
	              	'name'        => 'Username',
		            'id'          => 'username',
		            'placeholder' => 'Uporabnik',
		            'class'       => 'loginInput',
		            'required'	  => 'required'
            	);

		$passAtr = array(
	              	'name'        => 'Password',
		            'id'          => 'password',
		            'placeholder' => 'Geslo',
		            'class'       => 'loginInput',
		            'required'	  => 'required'
            	);

		$login1 = 'class="loginInput"';
		$login2 = 'class="loginButton"';

		echo form_open('auth/login', $formAtr);
		echo "<br>";
		echo form_input($userAtr);
		echo "<br>";
		echo form_password($passAtr);
		echo "<br>";
		echo "<br>";
		echo form_button('forgetButton','Pozabil sem geslo', $login2, 'id="forgetButton"');
		echo form_submit('submitButton', 'Prijava', $login2, 'id="loginButton"');
		echo "<br>";
		echo form_button('faceButton','Facebook prijava', $login2, 'id="facebookButton"');
		echo "<br>";
		echo '<div id="regDiv">'.form_button('regButton','Nov uporabnik', $login2, 'id="regButton"').'</div>';

		echo form_close();
	?>

	<div id="regForm">
		<?php 
			$formAtr = array('class' => 'login', 'name' => 'Registration');
			$nameAtr = array(
	              	'name'        => 'Name',
		            'id'          => 'name',
		            'placeholder' => 'Ime',
		            'class'       => 'loginInput',
		            'required'	  => 'required'
            	);
			$lastAtr = array(
	              	'name'        => 'Lastname',
		            'id'          => 'lastname',
		            'placeholder' => 'Priimek',
		            'class'       => 'loginInput',
		            'required'	  => 'required'
            	);
			$emailAtr = array(
	              	'name'        => 'Email',
		            'id'          => 'email',
		            'placeholder' => 'Email',
		            'class'       => 'loginInput',
		            'required'	  => 'required',
		            'type'		  => 'email'
            	);
			$rpass1Atr = array(
	              	'name'        => 'Password1',
		            'id'          => 'password1',
		            'placeholder' => 'Geslo',
		            'class'       => 'loginInput',
		            'required'	  => 'required'
            	);
			$rpass2Atr = array(
	              	'name'        => 'Password2',
		            'id'          => 'password2',
		            'placeholder' => 'Potrdi geslo',
		            'class'       => 'loginInput',
		            'required'	  => 'required'
            	);
			echo form_open('auth/login', $formAtr);
			echo form_input($nameAtr);
			echo "<br>";
			echo form_input($lastAtr);
			echo "<br>";
			echo form_input($emailAtr);
			echo "<br>";
			echo form_password($rpass1Atr);
			echo "<br>";
			echo form_password($rpass2Atr);
			echo "<br>";
			echo form_submit('submitButton', 'Registracija', $login2, 'id="finalRegButton"');
			echo form_close();
		?>
	</div>
</section>
<?php if(isset($Error)) echo "<small style='color:red;'>".$Error."</small>"; ?>



<footer>
	<p>Copyrights Zelnik.net 2014</p>
</footer>
