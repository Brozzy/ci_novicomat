<?php 
	$attributes = array('class' => 'login');
	echo form_open(base_url().'Auth/Register',$attributes);
?>
    <label><?php echo form_error('username'); ?></label></br>
    <label for='username'>Uporabnisko ime</label><br/>
    <input name="username" type="text" id='username' required><br><br/>

    <label for = 'name'l><?php echo form_error('name'); ?></label></br>
    <label for='name'>Ime in Priimek</label><br/>
    <input name="name" type="text" id='name' required><br><br/>

    <label for = 'password'><?php echo form_error('password'); ?></label></br>
    <label for='password'>Geslo</label><br/>
    <input name="password" type="password" id='password' pattern="[a-zA-Z0-9]+" required><br><br/>

    <label for = 'rep_password'><?php echo form_error('rep_password'); ?></label></br>
    <label for='rep_password'>Ponovi Geslo</label><br/>
    <input name="rep_password" type="password" id='rep_password' pattern="[a-zA-Z0-9]+" required>

    <br><br/>
    <label for="email"><?php echo form_error('email'); ?></label></br>
    <label for='email'>E-POSTA</label><br/>
    <input name="email" type="email" id='email' required><br><br/>

    <input type='hidden' name='register' value='1' />
    <input class='button' style="margin-top:30px; min-width:auto;" type="submit" value="Registriraj sel">
    <br><br><br>

    <div style="text-align:right; width:95%;">
        <a href="<?php echo base_url()."Prijava"; ?>">Prijava</a> | <a href="<?php echo base_url()."Auth/Lost_Password"; ?>">Pozabljeno geslo</a>
    </div>

</form>
<br>
<!-- REPLACED WITH form_error()
<div style="text-align:center; color:red;">
	<?php echo validation_errors(); ?>
</div>
-->




   