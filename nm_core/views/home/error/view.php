<section id="content-edit">
    <h3>Pregled poročila napak</h3>
    <ul>
        <?php foreach($errors as $bug) { ?>
            <li class="attachment-wrapper icon bug2-icon" style="background-position: 98% 10%; background-size: 35px;" id="bug-<?php echo $bug->id; ?>">
                <div class="attachment-image-wrapper">
                    <?php foreach($bug->images as $image) { ?>
                        <a href="<?php echo base_url().$image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $image->name; ?>">
                            <img class="attachment-image" src='<?php echo base_url().$image->medium."?img=".rand(0,1000); ?>' id="image-<?php echo $image->id; ?>" alt='attachment image'>
                        </a>
                    <?php } ?>
                </div>
                <div style="position:relative; margin-left:310px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                    <p style="padding-left: 3px; opacity: 0.8; "><?php echo $bug->description; ?></p>

                    <div style="position: absolute; bottom:0px; left:0px;">
                        <input type="button" class="icon edit-icon" value="Uredi">
                        <input type="button" class="icon delete-icon delete-bug-button" value="Izbriši">

                        <input type="hidden" name='type' value="bug">
                        <input type="hidden" name='id' value="<?php echo $bug->id; ?>">
                        <input type="hidden" name='name' value="<?php echo $bug->name; ?>">
                        <input type="hidden" name='description' value="<?php echo $bug->description; ?>">
                        <input type="hidden" name='status' value="<?php echo $bug->status; ?>">
                        <input type="hidden" name='priority' value="<?php echo $bug->priority; ?>">
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>
<input type="hidden" value="<?php echo base_url(); ?>" id="base_url">