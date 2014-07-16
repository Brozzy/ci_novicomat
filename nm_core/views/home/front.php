
<section>
    <header>
        <h2>Vaši prispevki</h2>
    </header>
    <section>
        <?php foreach($contents as $content) { ?>
            <article class="front-article" id='<?php echo "Vsebina_".$content->id; ?>'>
                <header>
                    <h3><a href="<?php echo base_url()."Prispevek/".$content->id."/Urejanje"; ?>" data-hover="<?php echo $content->name; ?>"><?php echo $content->name; ?></a></h3>
                    <a href="<?php echo base_url().$content->image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $content->image->name; ?>">
                        <img src="<?php echo base_url().$content->image->medium; ?>" alt="article header image">
                    </a>
                </header>

                <section>
                    <p class="content"><?php echo $content->description; ?></p>
                    <p class="created"><?php echo $content->author->name.", ".date('m. d. Y', strtotime($content->created)); ?></p>
                </section>

                <footer>
                    <nav class="cl-effect-16" id="cl-effect-16">
                        <a class="icon magnify-icon" href='<?php echo base_url()."Prispevek/".$content->id."/".$content->slug; ?>' data-hover="pogled">pogled</a>
                        <?php if($content->owner) { ?>
                            <a class="icon edit-icon" href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje/"; ?>' data-hover="urejanje">urejanje</a>
                            <a class="icon delete-icon" href='<?php echo base_url()."content/Delete/".$content->id; ?>' data-hover="izbriši">izbriši</a>
                        <?php } ?>
                    </nav>
                </footer>
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
