<?php
    $attributes = array('class' => 'login');
    echo form_open(current_url(),$attributes);
?>

<label for = 'chg_pass' ><?php echo form_error('chg_pass');?></label></br>
<label for='chg_pass'>Novo geslo</label><br/>
<input name="chg_pass" type="password" id='chg_pass' value="" required><br><br/>

<label for='rep_chg_pass'>Ponovi geslo</label><br/>
<input name="rep_chg_pass" type="password" id='rep_chg_pass' value="" required><br><br/>

<input type='hidden' name='hidden_pass' value='1' />
<input class='button' style="margin-top:30px; min-width:auto;" type="submit" value="Spremeni">
<br><br><br>
</form>
<br>
<div style="text-align:right; width:95%;">
    <a href="<?php echo base_url()."Prijava"; ?>">Prijava</a>
</div>
<br>