<style type="text/css" scoped>
    a:visited { color:white; }
</style>


<ul style="list-style:none; padding:3px; margin:0px; background-color:#2e365c; text-align:right; ">
	<li style='display:inline-block;'><a class='button' href='<?php echo base_url()."Prispevek/Dodaj"; ?>'>dodaj vsebino</a></li>

    <li style='display:inline-block;'><a class='button' href='<?php echo base_url()."Nastavitve"; ?>'>nastavitve</a></li>

	<?php if($user->level > 4) { ?>
    <li class='button' >Urejanje vsebin</li>
    <?php } if($user->level > 5) { ?>
    <li class='button' >Urejanje portalov</li>
    <?php } if($user->level > 12) { ?>
    <li class='button' >Urejanje uporabnikov</li>
    <?php } ?>

    <li style="display:inline-block;"><a class='button' style="border-right:none;" href='<?php echo base_url()."Odjava"; ?>'>odjava</a></li>
</ul>


<?php 

/*

	<option value="7" >Administrator</option>
	<option value="6" >Manager</option>
	<option value="5" >Publisher</option>
	<option value="4" >Editor</option>
	<option value="3" >Author</option>
	<option value="2" >Registered</option>
	<option value="1" >Public</option>

*/

?>