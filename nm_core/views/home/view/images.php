<header>
    <h2>Slike</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'image') { ?>
        <div style="display: inline-block; vertical-align: top; padding: 3px; margin: 10px; background-color: white; border:thin solid #ccc; ">
            <header>
                <h3><?php echo $content->name; ?></h3>
                <img src="<?php echo base_url().$content->medium; ?>" alt="<?php echo $content->name; ?>" style="height: 200px; max-width: 300px;">
                <p><?php echo $content->author->name.', '.$content->display_created; ?></p>
            </header>
            <section>
                <p><?php echo $content->description; ?></p>
                <ul class="icon tags-icon">
                    <?php foreach($content->tags as $tag) { ?>
                        <li><?php echo $tag; ?></li>
                    <?php } ?>
                </ul>
            </section>
        </div>
    <?php } } ?>
</section>
