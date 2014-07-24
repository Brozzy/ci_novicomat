<input class="images-search-input icon magnify-icon" style="padding-left: 33px; background-position:8px center;" type="text" size="50" placeholder="iskanje slik">

<ul class="scrollbar" id="gallery-images-list" style="position: relative; overflow: hidden; height:400px;">
</ul>

<div id="gallery-hidden-inputs">
    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo $input['name']; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</div>

<input type="button" class="md-close icon cancel-icon" value="Prekliči">