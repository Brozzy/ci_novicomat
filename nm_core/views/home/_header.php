<h1 style='margin:0px; padding:3px;'><?php echo $user->name; ?></h1>

<nav class="head-navigation">
    <a class="icon home2-icon" href="<?php echo base_url()."Domov"; ?>" style="padding-left: 30px; background-position: left; margin-right: 5px;" target="_self">Domov</a>
    <a class="icon file3-icon" href="<?php echo base_url()."content/Create"; ?>" target="_self" style="padding-left: 30px; background-position: left; margin-right: 5px;">Dodaj nov članek</a>
    <a class="icon edit2-icon" href="#" style="padding-left: 30px; background-position: left; margin-right: 5px;">Urejanje člankov</a>
    <?php if($user->level > 4) { ?><a class="icon bug-icon" href="<?php echo base_url()."content/Errors"; ?>" style="padding-left: 30px; background-position: left; margin-right: 5px;">Pregled napak</a><?php } ?>
    <a class="icon exit2-icon" href="<?php echo base_url()."auth/Logout"; ?>" target="_self" style="float: right; padding-left: 30px; background-position: left; margin-right: 5px;">Odjava</a>
    <a class="md-trigger icon bug-icon info" data-modal="report-bug-form" href="#" target="_self" style="float: right; padding-left: 30px; background-position: left; margin-right: 5px;">Javi napako</a>
</nav>