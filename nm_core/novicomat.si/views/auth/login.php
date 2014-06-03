<section style="position:relative; width:100%; padding-left:10px; padding-top:15px;">
    <?php
        $attributes = array('class' => 'login');
        echo form_open(base_url().'auth/Login',$attributes);
    ?>
    <label for='username'>Uporabniško ime</label><br/>
    <input class="text_input" name="username" type="text" id='username' value="<?php echo set_value('username'); ?>" required><br><br/>

    <label for='password'>Geslo</label><br/>
    <input class="text_input" name="password" type="password" id='password' required><br>

    <input type='hidden' name='login' value='1' />
    <input class='button' style="margin-top:30px; border:none; border-left:thin solid #888; font-size:1.3em;" type="submit" value="prijava">

    </form>
    <br><br><br>
    <div style="text-align:left; width:100%; font-size:1.1em; position:absolute; top:15px; left:50%; padding-left:6%; padding-bottom:100px; border-left:thin solid #BBB;">
        <a class="button" href="<?php echo base_url()."auth/Register"; ?>" style='margin-bottom:10px; font-size:1.4em;'>registracija</a><br>
        <a class="button" href="<?php echo base_url()."auth/Lost_Password"; ?>">pozabljeno geslo</a>
    </div>
    <br>
    <div style="text-align:center; color:red;">
        <?php echo validation_errors(); ?>
    </div>
</section>
