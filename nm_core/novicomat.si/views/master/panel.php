<ul style="list-style:none; padding:0px; margin:0px; ">
	<li class='button' onClick="document.location.href='<?php echo base_url()."Domov"; ?>';">Domov

    <li class='button' onClick="document.location.href = '<?php echo base_url()."Prispevek/Dodaj"; ?>';">Dodaj prispevek

	<?php if($User->level > 4) { ?>
    <li class='button' >Urejanje vsebin
    <?php } if($User->level > 5) { ?>
    <li class='button' >Urejanje portalov
    <?php } if($User->level > 12) { ?>
    <li class='button' >Urejanje uporabnikov
    <?php } ?>
    <li class='button' style="float:right; margin-right:0px;" onClick="document.location.href = '<?php echo base_url()."auth/Logout"; ?>';">Odjava
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