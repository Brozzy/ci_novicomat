

<?php 
	$attributes = array('class' => 'login');
	echo form_open(base_url().'Auth/Register',$attributes);
?>
	<label for='Username'>Uporabniško ime <span class='requiered'>*</span> <small>(up. ime naj bo dolgo od 3 do 25 znakov)</small></label>
	<input name="Username" type="text" id='Username' value="<?php echo set_value('Username'); ?>" required><br>
    
    <label for='Password'>Geslo <span class='requiered'>*</span> <small>(geslo naj bo dolgo od 3 do 16 znakov)</small></label>
    <input name="Password" type="password" id='Password' required><br>
    
    <label for='PasswordConfirm'>Ponovi geslo <span class='requiered'>*</span></label>
    <input name="PasswordConfirm" type="password" id='PasswordConfirm' required><br>
    
    <label for='Name'>Ime <span class='requiered'>*</span></label>
    <input name="Name" type="text" id='Name' value='<?php echo set_value('Name'); ?>' required><br>
    
    <label for='Email'>e-naslov <span class='requiered'>*</span></label>
    <input name="Email" type="email" id='Email' value='<?php echo set_value('Email'); ?>' required><br>

    <input type='hidden' name='Register' value='1' />
    <input class='button' type="submit" value="Registriraj se" style="margin-top:15px; "><hr>
    <div style="text-align:right; width:95%;">
    <a href="<?php echo base_url()."Auth/Register"; ?>">Registracija</a> | <a href="<?php echo base_url()."Auth/LostPass"; ?>">Pozabljeno geslo</a>
    </div>

</form>
<br>
<div style="text-align:center; color:red;">
	<?php echo validation_errors(); ?>
</div>





   