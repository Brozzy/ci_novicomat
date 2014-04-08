<?php 
	$attributes = array('class' => 'login');
	echo form_open(base_url().'auth/Login',$attributes);
?>
	<label for='Username'>Uporabniško ime</label>
	<input name="Username" type="text" id='Username' value="<?php echo set_value('Username'); ?>" required><br>
    
    <label for='Password'>Geslo</label>
    <input name="Password" type="password" id='Password' required><br>

    <input type='hidden' name='Login' value='1' />
    <input class='button' type="submit" value="Prijava">
    <br><br><br>
    
    <div style="text-align:right; width:100%;">
    <a href="<?php echo base_url()."Auth/Register"; ?>">Registracija</a> | <a href="<?php echo base_url()."Auth/LostPass"; ?>">Pozabljeno geslo</a>
    </div>

</form>
<br>
<div style="text-align:center; color:red;">
	<?php echo validation_errors(); ?>
</div>