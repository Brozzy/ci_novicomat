<section>

    <div id='login-container'>
        <div id="wrapper">
            <div id="login" class="animate form">
                <form id = "emailForm" action="<?php echo base_url().'auth/Lost_Password'; ?>" method="post">
                    <h1>novicomat.si</h1>
                    <p>
                        <label for="email" class="uname" data-icon="u" > Vaš email</label>
                        <input id="email" name="email" required="required" type="email" value="" placeholder="vas@email-naslov.com"/>
                    </p>
                    <p class="login button">
                        <input type="submit" value="Pošlji email" />
                    </p>
                    <p class="change_link">
                        <a href="<?php echo base_url().'Prijava'; ?>" class="to_register"> Nazaj na prijavo </a>
                    </p>
                </form>
            </div>
    </div>
</section>

<script type ="text/javascript">

    $("#emailForm").submit(function(e){
        e.preventDefault();
        var email = $("#email").val();
        $.ajax({
            url:  '<?php echo base_url().'Auth/Lost_Password/'; ?>',
            data :  {email: email},
            type: 'POST',
            success: function(data)
            {

            }
        }).fail(function(data){

            });

    });

</script>