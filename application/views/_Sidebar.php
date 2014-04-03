<style type="text/css">
	#OsnutekList { width:500px; margin-right:40px; padding:0px; list-style:none; }
	.Osnutek { width:90%; margin-bottom:10px; padding:5px; border:thin solid #999; }

	.Osnutek ul { list-style:none; padding:0px; text-align:right; display:inline-block; width:100%; }
	.Osnutek ul li { display:inline-block; padding:3px; margin-right:5px; }
	.OsnutekLabel { color:blue; margin-right:10px; opacity:0.5; }
</style>

	<?php 
		if(count($Osnutki) > 0) {
	?>
<section id='Sidebar'>
    <h3>Prispevki</h3>
    <ul id='OsnutekList'>
        <?php foreach($Osnutki as $Osnutek) { ?>
            <li class='Osnutek' id='Osnutek<?php echo $Osnutek->id; ?>'> 
                <span class='OsnutekLabel'>[osnutek]</span>

                <a href='<?php echo base_url()."Prispevek/".$Osnutek->id; ?>'><?php echo $Osnutek->title; ?></a>
                <br>
                <ul>
                    <li><a href='<?php echo base_url()."Vsebine/View/".$Osnutek->id; ?>'>View</a>
                    <li><a href='<?php echo base_url()."Vsebine/Edit/".$Osnutek->id; ?>'>Edit</a>
                    <li><a href='<?php echo base_url()."Vsebine/Delete/".$Osnutek->id; ?>' id='<?php echo $Osnutek->id; ?>' class='DeleteOsnutek'>Delete</a>
                </ul>
            </li>
        <?php } ?>
    </ul>
</section>
<?php } ?>

<script type="text/javascript">
	$(".DeleteOsnutek").on("click",function(e) {
		e.preventDefault();
		var answer = confirm("Ali ste prepričani, da želite izbrisati izbrani prispevek?")
		var OsnutekId = $(this).attr("id");

		if (answer) { 
			$.ajax({ type: "POST", url: "<?php echo base_url()."Vsebine/Delete/"; ?>"+OsnutekId, success: function() {
					$("#Osnutek"+OsnutekId).fadeOut("slow",function() { $(this).remove(); });
				}
			});
		}
	});

</script>