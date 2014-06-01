<style type="text/css" scoped>
    #MasterMain {
        background-image:url('<?php echo base_url()."style/images/logo_large.png"; ?>');
        background-position:90% 130px;
        background-repeat: no-repeat;
        background-size: 400px auto;
    }
</style>


<section id="content_section">
    <h1>Vaše vsebine</h1>
	<?php foreach($contents as $content) { ?>
			<article id='<?php echo "Vsebina_".$content->id; ?>'>
				<header>
					<h1 style="margin-bottom:5px; padding: 0px;"><a href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje"; ?>'><?php echo $content->name; ?></a></h1>
                    <p class="created"><?php echo $content->author->name.", ".date('m. d. Y', strtotime($content->created)); ?></p>
				</header>

				<p class="content">
					<?php echo $content->description; ?>
				</p>

                <hr style="margin:0px;">

				<footer style="padding:3px 0px;">
                    <ul style="list-style:none; padding:3px; margin:0px; background-color:#558fd3; text-align:right; ">
					<?php if($content->owner) { ?>
                        <li style='display:inline-block;'><a class='button' href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje/"; ?>'>urejanje</a></li>
                        <li style='display:inline-block;'><a class='button delete' style="border-right:none;" href='<?php echo base_url()."content/Delete/".$content->id; ?>'>izbriši</a></li>
					<?php } ?>
                    </ul>
				</footer>
			</article>
	<?php } ?>
</section>

<script type='text/javascript'>
	$(".delete").on("click",function(e) {
		e.preventDefault();
		var conf = confirm("Ali ste prepričani, da želite izbrisati to vsebino?");
		var content_id = $(this).parents("article").attr("id").substr(8);
		
		if(conf) {
			$.ajax({
				url: '<?php echo base_url()."content/Delete/"; ?>'+content_id,
				type: "POST",			
			});
			
			$("#Vsebina_"+content_id).fadeOut("fast",function() { $(this).remove(); });
		}
	});
</script>
