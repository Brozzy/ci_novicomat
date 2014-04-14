<ul style="list-style:none; padding:0px; margin:0px; background-color:#555; text-align:right; ">
	<li style='display:inline-block;'><a class='button' href='<?php echo base_url()."Prispevek/Dodaj"; ?>'>dodaj vsebino</a>

    <li style='display:inline-block;'></li><a class='button' href='<?php echo base_url()."Nastavitve"; ?>'>nastavitve</a>

	<?php if($user->level > 4) { ?>
    <li class='button' >Urejanje vsebin
    <?php } if($user->level > 5) { ?>
    <li class='button' >Urejanje portalov
    <?php } if($user->level > 12) { ?>
    <li class='button' >Urejanje uporabnikov
    <?php } ?>
    <li style="display:inline-block; border-right:none;"><a class='button' href='<?php echo base_url()."Odjava"; ?>'>odjava</a>
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