<section>
    <div id='login-container'>

        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>
        <div id="wrapper">
            <div id="login" class="animate form">
                <form  action="<?php echo base_url().'auth/Login'; ?>" method="post" autocomplete="on">
                    <h1>novicomat.si</h1>
                    <p>
                        <label for="username" class="uname" data-icon="u" > Vaš email ali uporabniško ime </label>
                        <input id="username" name="username" required="required" type="text" value="<?php echo set_value('username'); ?>" placeholder="uporabniškoime ali vas@email-naslov.com"/>
                    </p>
                    <p>
                        <label for="password" class="youpasswd" data-icon="p"> Vaše geslo </label>
                        <input id="password" name="password" required="required" type="password" placeholder="npr. X8df!90EO" />
                    </p>
                    <p class="keeplogin">
                        <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" />
                        <label for="loginkeeping">Ostani prijavljen</label>
                    </p>
                    <div style="text-align:center; color:red;">
                        <?php echo validation_errors(); ?>
                    </div>
                    <p class="login button">
                        <input type='hidden' name='login' value='1' />
                        <input type="submit" value="Login" />
                    </p>
                    <p class="change_link">
                        Še niste član ?
                        <a href="#toregister" class="to_register">Registrirajte se</a>
                    </p>
                </form>
            </div>

            <div id="register" class="animate form">
                <form  action="<?php echo base_url().'Auth/Register'; ?>" method="post" autocomplete="on">
                    <h1> Registracija </h1>
                    <p>
                        <label for = 'name'l><?php echo form_error('name'); ?></label>
                        <label for="namesignup" class="uname" data-icon="u">Vaše ime</label>
                        <input id="namesignup" name="name" required="required" type="text" placeholder="Janez Novak" />
                    </p>
                    <p>
                        <label><?php echo form_error('username'); ?></label>
                        <label for="usernamesignup" class="uname" data-icon="u">Vaše uporabniško ime</label>
                        <input id="usernamesignup" name="username" required="required" type="text" placeholder="mojesuperuporabniskoime69" />
                    </p>
                    <p>
                        <label for="email"><?php echo form_error('email'); ?></label>
                        <label for="emailsignup" class="youmail" data-icon="e" > Vaš email</label>
                        <input id="emailsignup" name="email" required="required" type="email" placeholder="mojsuperemail@mail.com"/>
                    </p>
                    <p>
                        <label for = 'password'><?php echo form_error('password'); ?></label>
                        <label for="passwordsignup" class="youpasswd" data-icon="p">Vaše geslo </label>
                        <input id="passwordsignup" name="password" required="required" type="password" placeholder="npr. X8df!90EO"/>
                    </p>
                    <p>
                        <label for = 'rep_password'><?php echo form_error('rep_password'); ?></label>
                        <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Prosim potrdite vaše geslo </label>
                        <input id="passwordsignup_confirm" name="rep_password" required="required" type="password" placeholder="npr. X8df!90EO"/>
                    </p>
                    <p class="signin button">
                        <input type='hidden' name='register' value='1' />
                        <input type="submit" value="Registiraj se"/>
                    </p>
                    <p class="change_link">
                        Ste že član ?
                        <a href="#tologin" class="to_register"> Nazaj na prijavo </a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</section>
