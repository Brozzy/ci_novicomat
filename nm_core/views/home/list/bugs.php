<header>
    <h2>Poročila o napakih</h2>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'bug') { ?>
        <article class="front-article" id='<?php echo "Vsebina_".$content->id; ?>'>
            <header>
                <?php foreach($content->images as $image) { ?>
                    <a href="<?php echo base_url().$image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $image->name; ?>">
                        <img src="<?php echo base_url().$image->medium; ?>" alt="article header image">
                    </a>
                <?php } ?>
            </header>

            <section>
                <p class="content"><?php echo $content->description; ?></p>
                <p class="created"><?php echo $content->author->name.", ".$content->display_created; ?></p>
            </section>

            <footer>
                <nav class="cl-effect-16" id="cl-effect-16">
                    <a class="icon delete-icon" href='<?php echo base_url()."content/Delete/".$content->id; ?>' data-hover="izbriši">izbriši</a>
                </nav>
            </footer>
        </article>
        <hr>
    <?php } } ?>
</section>