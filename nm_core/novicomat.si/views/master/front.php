
<section style='display:table; width:100%; color:#333;'>
	<?php foreach($contents as $content) { ?>
			<article id='<?php echo "Vsebina_".$content->id; ?>'>
				<header>
					<h1><a href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje"; ?>'><?php echo $content->name; ?></a></h1>
					<p><?php echo $content->author->name.", ".date('m. d. Y', strtotime($content->created)); ?></p>
				</header>

				<p>
					<?php echo $content->description; ?>
				</p>
                <hr style="margin:0px;">
				<footer>
					<?php if($content->owner) { ?>
						<a class='button' style="border-left:thin solid #999; margin:0px;" href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje/"; ?>'>urejanje</a>
						<a class='button delete' style='border-right:none; margin:0px;' href='<?php echo base_url()."content/Delete/".$content->id; ?>'>izbriši</a>
					<?php } ?>
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
