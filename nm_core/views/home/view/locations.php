<header>
    <h2>Lokacije</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'location') { ?>
        <div style="display:table; width: 100%; padding: 3px; margin: 10px 0px; border:thin solid #ccc; ">
            <header style="display:table-cell; width:300px; ">
                <img class="attachment-image" src='<?php echo $content->google_image; ?>' alt='google location image'>
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
