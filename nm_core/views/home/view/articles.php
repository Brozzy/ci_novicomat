<header>
    <h2>Vaši prispevki</h2>
    <p>
        Prikazano so vsi vaši prispevki, ki ste jih dodali vi ali pa ste bili dodani kot urednik.
        Privzeto so razporejeni po časovnem zaporedju po datumu nastanka od najnovejšega proti najstarejšemu.
    </p>
</header>
<section>
    <?php foreach($contents as $content) { if(get_class($content) == 'article') { ?>
        <article class="front-article" id='<?php echo "Vsebina_".$content->id; ?>'>
            <header>
                <h3><a href="<?php echo base_url()."Prispevek/".$content->id."/Urejanje"; ?>" data-hover="<?php echo $content->name; ?>"><?php echo $content->name; ?></a></h3>
                <a href="<?php echo base_url().$content->image->extra_large."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $content->image->name; ?>">
                    <img src="<?php echo base_url().$content->image->medium; ?>" alt="article header image">
                </a>
            </header>

            <section>
                <p class="content"><?php echo $content->description; ?></p>
                <p class="created"><?php echo $content->author->name.", ".date('m. d. Y', strtotime($content->created)); ?></p>
            </section>

            <footer>
                <nav class="cl-effect-16" id="cl-effect-16">
                    <a class="icon magnify-icon" href='<?php echo base_url()."Prispevek/".$content->id."/".$content->slug; ?>' data-hover="pogled">pogled</a>
                    <?php if($content->owner) { ?>
                        <a class="icon edit-icon" href='<?php echo base_url()."Prispevek/".$content->id."/Urejanje/"; ?>' data-hover="urejanje">urejanje</a>
                        <a class="icon delete-icon" href='<?php echo base_url()."content/Delete/".$content->id; ?>' data-hover="izbriši">izbriši</a>
                    <?php } ?>
                </nav>
            </footer>
        </article>
    <?php } } ?>
</section>
