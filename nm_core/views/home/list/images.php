<header>
    <h2>Vaše slike</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'image') { ?>
        <a href="<?php echo base_url().'vsebina/'.$content->id.'/urejanje'; ?>" title="<?php echo $content->name; ?>">
            <div style="max-width:320px; display: inline-block; vertical-align: top; padding: 1px; margin: 5px; background-color: white; border:thin solid #ccc; ">
                <header>
                    <h3 style="word-break: break-all;"><?php echo $content->name; ?></h3>
                    <img src="<?php echo base_url().$content->medium; ?>" alt="<?php echo $content->name; ?>" style="margin-top:10px; max-height: 200px; width:100%;">
                    <p style="opacity: 0.7; font-size: 1.1em; margin-bottom: 0px;"><?php echo $content->author->name.', '.$content->display_created; ?></p>
                </header>
                <section>
                    <?php if($content->description != '') echo '<p>'.$content->description.'</p>'; ?>
                    <ul class="icon tags-icon" style="opacity: 0.6; margin: 0px;">
                        <?php foreach($content->tags as $tag) { ?>
                            <li style="display: inline-block; margin-right: 10px;"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul>
                </section>
            </div>
        </a>
    <?php } } ?>
</section>
