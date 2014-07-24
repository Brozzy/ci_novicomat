<h2 style="text-align: center; font-size: 1.2em; padding:0px; margin: 5px 0px;">prikazana je originalna slika - za predogled slike kliknite na gumb "povečaj".</h2>
<p style="text-align: center; padding:0px; margin: 2px 0px; opacity: 0.8;">Slika mora biti v razmerju 300/200 (1:5) - tako, da se v tem razmerju tudi obrezuje.</p>

<div style="display:block; overflow:hidden; background-color: white; width:100%; max-width: 1024px; max-height: 533px; margin: 0px auto; border: thin solid #ccc; border-radius: 5px;">
    <img src="<?php echo base_url().$content->url; ?>" id="modal-edit-image" style="display:block; height:100%; width:100%;margin:0px auto; border:thin dashed #777; vertical-align: middle;" alt="article image">
</div>

<input class="md-close icon cancel-icon" type="button" value="prekliči">

<form style="display: inline-block;" action="<?php echo base_url()."content/CropImage"; ?>" class="transform-image-form" id="image-cropping-form" method="post">
    <input type="hidden" id="crop-x" name="crop[x]" value="">
    <input type="hidden" id="crop-y" name="crop[y]" value="">
    <input type="hidden" id="crop-w" name="crop[w]" value="">
    <input type="hidden" id="crop-h" name="crop[h]" value="">
    <input type="hidden" id="crop-x2" name="crop[x2]" value="">
    <input type="hidden" id="crop-y2" name="crop[y2]" value="">
    <input type="button" class="icon crop-icon" id="crop-image" value="obreži sliko">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>

<form style="display: inline-block;" action="<?php echo base_url()."content/GreyscaleImage"; ?>" method="post">
    <input class="md-close icon wand-icon" type="submit" value="spremeni v črno-belo">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>

<form style="display: inline-block;" action="<?php echo base_url()."content/FlipImage"; ?>" method="post">
    <input type="hidden" name="content[mode]" value="horizontal">
    <input class="md-close icon flip-icon" type="submit" value="prezrcali h.">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>

<form style="display: inline-block;" action="<?php echo base_url()."content/FlipImage"; ?>" method="post">
    <input type="hidden" name="content[mode]" value="vertical">
    <input class="md-close icon flip2-icon" type="submit" value="prezrcali v.">
    <input type="hidden" name="content[type]" value="image">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>