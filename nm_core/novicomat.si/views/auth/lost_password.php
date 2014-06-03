<?php
$attributes = array('class' => 'login');
echo form_open(base_url().'Auth/Lost_Password',$attributes);
?>

<label for='email'>E-MAIL</label><br/>
<input name="email" type="email" id='email' value="" required><br><br/>

<input type='hidden' name='lost_pass' value='1' />
<input class='button' style="margin-top:30px; min-width:auto;" type="submit" value="Poslji email">
<br><br><br>

<div style="text-align:right; width:100%; color:#222;">
    <a href="<?php echo base_url()."auth/Login"; ?>" style='margin-right:25px;'>Prijava</a> <a href="<?php echo base_url()."auth/Register"; ?>">Registracija</a>
</div>

</form>
<br>
<div style="text-align:center; color:red;">
    <?php echo validation_errors(); ?>
</div>