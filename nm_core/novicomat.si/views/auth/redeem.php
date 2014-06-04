<?php
$attributes = array('class' => 'login');
echo form_open(base_url().'Auth/Reedem',$attributes);
?>

<label for = 'password'><?php echo form_error('password'); ?></label></br>
<label for='password'>Novo geslo</label><br/>
<input name="password" type="password" id='password' value="" required><br><br/>

<label for='rep_password'>Ponovi geslo</label><br/>
<input name="rep_password" type="password" id='rep_password' value="" required><br><br/>

<input type='hidden' name='hidden_pass' value='1' />
<input class='button' style="margin-top:30px; min-width:auto;" type="submit" value="Spremeni">
<br><br><br>
</form>
<br>