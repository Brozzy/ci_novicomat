<section>

    <div id='login-container'>
        <div id="wrapper">
            <div id="login" class="animate form">
                <form id = "tokenForm" action="<?php echo current_url(); ?>" method="post">
                    <h1>novicomat.si</h1>
                    <p>
                        <label for="password" class="uname" data-icon="u" >Novo geslo</label>
                        <input id="password" name="password" required="required" type="password" value=""/>
                    </p>
                    <p>
                        <label for="rep_password" class="uname" data-icon="u" >Ponovite geslo</label>
                        <input id="rep_password" name="rep_password" required="required" type="password" value=""/>
                    </p>
                    <p class="login button">
                        <input type="submit" value="Spremeni geslo" />
                    </p>
                    <p class="change_link">
                        <a href="<?php echo base_url().'Prijava'; ?>" class="to_register"> Nazaj na prijavo </a>
                    </p>
                </form>
            </div>
        </div>
</section>

<script type ="text/javascript">
/*
    $("#tokenForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url:  '<?php echo base_url().'Auth/Redeem/'; ?>',
            data :  $(this).serialize(),
            type: 'POST',
            success: function(data)
            {

            }
        }).fail(function(data){

            });

    });
    */
</script>