
<section>
    <header>
        <h2>Vaši prispevki</h2>
    </header>
    <section>
        <?php foreach($contents as $content) { ?>
            <article class="front-article" id='<?php echo "Vsebina_".$content->id; ?>'>
                <div style="display:inline-block; overflow:hidden; width:150px;">
                    <img src="<?php echo $content->image->medium; ?>" alt="article header image">
                </div>
                <div style="display:inline-block; margin-left: 15px;">
                    <header>
                        <h3 style="margin:0px; padding:0px; width: 99%;">
                            <nav class="cl-effect-17">
                                <a style="padding: 0px; margin: 0px 0px 5px;" href="<?php echo base_url()."Prispevek/".$content->id; ?>" data-hover="<?php echo $content->name; ?>"><?php echo $content->name; ?></a>
                            </nav>
                        </h3>
                        <p class="created">
                            <?php echo $content->author->name.", ".date('m. d. Y', strtotime($content->created)); ?>
                        </p>
                    </header>

                    <p class="content" style="padding: 15px 0px; ">
                        <?php echo $content->description; ?>
                    </p>

                    <hr style="margin:0px;">
                    <footer>
                        <nav class="cl-effect-16" id="cl-effect-16">
                            <a class="icon magnify-icon" href='<?php echo base_url()."Prispevek/".$content->id; ?>' data-hover="pogled">pogled</a>
                            <?php if($content->owner) { ?>
                                <a class="icon edit-icon" href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje/"; ?>' data-hover="urejanje">urejanje</a>
                                <a class="icon delete-icon" href='<?php echo base_url()."content/Delete/".$content->id; ?>' data-hover="izbriši">izbriši</a>
                            <?php } ?>
                        </nav>
                    </footer>
                </div>
            </article>
        <?php } ?>
    </section>
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
