<header>
    <h2>Dokumenti</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'document') { ?>
        <div style="display:table; width: 100%; padding: 3px; margin: 10px 0px; border:thin solid #ccc; ">
            <header style="display:table-cell; width:300px; ">
                <div class="attachment-image-wrapper" style="width: 300px; background:transparent url('<?php echo $content->thumbnail; ?>') no-repeat center; ">
                    &nbsp;
                </div>
            </header>
            <section style="display:table-cell; vertical-align: top;">
                <h3><?php echo $content->name; ?></h3>
                <p><?php echo $content->description; ?></p>
                <ul class="icon tags-icon">
                    <?php foreach($content->tags as $tag) { ?>
                        <li><?php echo $tag; ?></li>
                    <?php } ?>
                </ul>

                <p><?php echo $content->author->name.', '.$content->display_created; ?></p>
            </section>
        </div>
    <?php } } ?>
</section>
