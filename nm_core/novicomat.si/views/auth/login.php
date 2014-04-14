<?php 
	$attributes = array('class' => 'login');
	echo form_open(base_url().'auth/Login',$attributes);
?>
	<label for='username'>Uporabniško ime</label><br/>
	<input name="username" type="text" id='username' value="<?php echo set_value('username'); ?>" required><br><br/>
    
    <label for='password'>Geslo</label><br/>
    <input name="password" type="password" id='password' required><br>

    <input type='hidden' name='login' value='1' />
    <input class='button' style="margin-top:30px; min-width:auto;" type="submit" value="Prijava">
    <br><br><br>
    
    <div style="text-align:right; width:100%; color:#222;">
    	<a href="<?php echo base_url()."auth/Register"; ?>" style='margin-right:25px;'>Registracija</a> <a href="<?php echo base_url()."auth/LostPass"; ?>">Pozabljeno geslo</a>
    </div>

</form>
<br>
<div style="text-align:center; color:red;">
	<?php echo validation_errors(); ?>
</div>