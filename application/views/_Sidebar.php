<style type="text/css">
	#OsnutekList { width:90%; margin-right:40px; padding-left:20px; list-style:none; }
	#OsnutekList li { width:90%; margin-bottom:10px; }
	.OsnutekLabel { color:blue; margin-right:10px; opacity:0.5; }
</style>

<section id='Sidebar'>
	<?php 
		if(isset($Osnutki)) {
		echo "<h3>Vaši prispevki</h3>";
	?>
    	<ul id='OsnutekList'>
        	<?php foreach($Osnutki as $Osnutek) {
				echo "<li>"; if($Osnutek->status == 0) echo "<span class='OsnutekLabel'>[osnutek]</span>"; 
				echo "<a href='".base_url()."Prispevek/".$Osnutek->prispevek_id."'>".$Osnutek->title."</a></li>"; ?>
            <?php } ?>
        </ul>
    <?php
		}
	?>
</section>