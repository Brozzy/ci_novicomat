
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
</style>

<?php if(isset($Osnutki)) { ?>

<section id='Sidebar' style="display:table-cell; width:30%; padding-right:20px;">
    <h2>Vaši prispevki</h2>
    <?php if(count($Osnutki) == 0) { "<p>Dodali še niste nobenega prispevka. Dodate ga lahko <a href='".base_url()."Prispevek/Dodaj'>tukaj.</a></p>"; }?>
    <ul id='OsnutekList'>
        <?php foreach($Osnutki as $Osnutek) { ?>
            <li class='Osnutek' id='Osnutek<?php echo $Osnutek->id; ?>'> 
                <a href='<?php echo base_url()."Prispevek/".$Osnutek->id."/".$Osnutek->title_url; ?>'><?php echo $Osnutek->title; ?></a>
                <br>
                <ul>
                    <li><a href='<?php echo base_url()."Prispevek/".$Osnutek->id."/".$Osnutek->title_url; ?>'>Ogled</a>
                    <li><a href='<?php echo base_url()."Prispevek/Urejanje/".$Osnutek->id; ?>'>Urejanje</a>
                    <li><a href='<?php echo base_url()."Prispevek/Delete/".$Osnutek->id; ?>' id='<?php echo $Osnutek->id; ?>' class='DeletePrispevek'>Izbriši</a>
                </ul>
            </li>
        <?php } ?>
    </ul>
</section>

<script type="text/javascript">
	$(".DeletePrispevek").on("click",function(e) {
		e.preventDefault();
		var answer = confirm("Ali ste prepričani, da želite izbrisati izbrani prispevek?")
		var OsnutekId = $(this).attr("id");
		
		if (answer) { 
			$.ajax({ 
				type: "POST", 
				url: "<?php echo base_url()."vsebine/Delete/"; ?>"+OsnutekId
			});
			
			$("#Osnutek"+OsnutekId).fadeOut("slow",function() { $(this).remove(); });
		}
	});
</script>

<?php } ?>