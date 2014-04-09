<?php 
	$attributes = array('class' => 'login');
	echo form_open(base_url().'Auth/Register',$attributes);
?>
	<label for='Username'>Uporabniško ime <span class='required'>*</span><span class='small'>(up. ime naj bo dolgo od 3 do 25 znakov)</span></label>
	<input name="Username" type="text" id='Username' value="<?php echo set_value('Username'); ?>" required><br>
    
    <label for='Password'>Geslo <span class='required'>*</span> <span class='small'>(geslo naj bo dolgo od 3 do 16 znakov)</span></label>
    <input name="Password" type="password" id='Password' required><br>
    
    <label for='PasswordConfirm'>Ponovi geslo <span class='required'>*</span></label>
    <input name="PasswordConfirm" type="password" id='PasswordConfirm' required><br>
    
    <label for='Name'>Ime <span class='required'>*</span></label>
    <input name="Name" type="text" id='Name' value='<?php echo set_value('Name'); ?>' required><br>
    
    <label for='Email'>e-naslov <span class='required'>*</span></label>
    <input name="Email" type="email" id='Email' value='<?php echo set_value('Email'); ?>' required><br>

    <input type='hidden' name='Register' value='1' />
    <input class='button' type="submit" value="Registracija" style="margin-top:15px; ">
    
    <br><br>
    
    <div style="text-align:right; width:95%;">
    <a href="<?php echo base_url()."Prijava"; ?>">Prijava</a> | <a href="<?php echo base_url()."Auth/LostPass"; ?>">Pozabljeno geslo</a>
    </div>

</form>
<br>
<div style="text-align:center; color:red;">
	<?php echo validation_errors(); ?>
</div>





   