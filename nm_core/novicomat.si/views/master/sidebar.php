
<style type="text/css" scoped>
	.Osnutek { 
		padding:10px; 
		margin-bottom:15px; 
		background-color:#294e73; 
		border-bottom:4px solid #0e2945;
	}
	.Osnutek a { color:white; }
	.Osnutek ul { padding:0px; list-style:none; text-align:right;  }
	.Osnutek li { display:inline-block; margin-right:10px; }
	#OsnutekList {
		padding:0px; list-style:none;
	}
	
	.EditButtonImage { height:21px; width:auto; vertical-align:bottom; }

</style>

<?php if(isset($Osnutki)) { ?>

<section id='Sidebar' style="display:table-cell; width:30%; padding-right:20px;">
    <h2>Vaši prispevki</h2>
    <?php if(count($Osnutki) == 0) { "<p>Dodali še niste nobenega prispevka. Dodate ga lahko <a href='".base_url()."article/Dodaj'>tukaj.</a></p>"; }?>
    <ul id='OsnutekList'>
        <?php foreach($Osnutki as $Osnutek) { ?>
            <li class='Osnutek' id='Osnutek<?php echo $Osnutek->id; ?>'> 
                <a href='<?php echo base_url()."article/".$Osnutek->id."/".$Osnutek->title_url; ?>'><?php echo $Osnutek->title; ?></a>
                <hr>
                <ul>
                    <li><img src='<?php echo base_url()."style/images/icon_view.png";?>' alt="View icon" class='EditButtonImage'><a href='<?php echo base_url()."article/".$Osnutek->id."/".$Osnutek->title_url; ?>'>Ogled</a></li>
                    <li><img src='<?php echo base_url()."style/images/icon_edit.png";?>' alt="View icon" class='EditButtonImage'><a href='<?php echo base_url()."article/Urejanje/".$Osnutek->id; ?>'>Urejanje</a></li>
                    <li><img src='<?php echo base_url()."style/images/icon_delete.png";?>' alt="View icon" class='EditButtonImage'><a href='<?php echo base_url()."article/Delete/".$Osnutek->id; ?>' id='<?php echo $Osnutek->id; ?>' class='Deletearticle'>Izbriši</a></li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</section>

<script type="text/javascript">
	$(".Deletearticle").on("click",function(e) {
		e.preventDefault();
		var answer = confirm("Ali ste prepričani, da želite izbrisati izbrani article?")
		var OsnutekId = $(this).attr("id");
		
		if (answer) { 
			$.ajax({ 
				type: "POST", 
				url: "<?php echo base_url()."content/Delete/"; ?>"+OsnutekId
			});
			
			$("#Osnutek"+OsnutekId).fadeOut("slow",function() { $(this).remove(); });
		}
	});
</script>

<?php } ?>