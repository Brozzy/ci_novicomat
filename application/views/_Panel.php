<ul>
	<li class='button' onClick="document.location.href='<?php echo base_url()."Home"; ?>';">Domov
    <li class='button add-button' onClick="document.location.href = '<?php echo base_url()."Prispevek/Dodaj"; ?>';">Dodaj prispevek
    <?php if($User->level > 2) { ?>
    <li class='button add-button' id='NewLocation'>Urejanje lokacij
    <li class='button add-button' id='NewSlika'>Urejanje slik
    <?php } if($User->level > 3) { ?>
    <?php } ?>
    <li class='button' style="float:right;" onClick="document.location.href = '<?php echo base_url()."Auth/Logout"; ?>';">Odjava
</ul>