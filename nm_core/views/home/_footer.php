<!-- NEW EVENT -->
<div class="md-modal md-effect-16" id="modal-event-form">
    <div class="md-content">
        <h3>Dodaj dogodek</h3>
        <div>
            <p>Tukaj lahko dodate nov dogodek ali pa članek povežete z že obstoječim dogodkom.</p>
            <form action="<?php echo base_url()."content/Update"; ?>" method="post">
                <label class="icon magnify-icon" for="search-events">Išči po dogodkih</label>
                <input type="text" class="tags" id="search-events" placeholder="npr. mačkarade" style="width:100%;">
                <input type="hidden" class="current-event-id" name="content[id]">

                <hr>
                <label class="icon notification-icon" style="opacity: 0.8; font-size:90%; background-position: left 1px;">Če dogodek še ne obstaja lahko naredite novega.</label><br>
                <label class="icon edit-icon">Naslov dogodka<span class="required">*</span></label>
                <input type="text" id="upload-image-name" name="content[name]" required="required" placeholder="Naslov dogodka">

                <label class="icon edit-icon">Opis dogodka<span class="required">*</span></label>
                <textarea placeholder="Kratek opis dogodka..." id="upload-image-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

                <label class="icon eye-icon" for='publish_up'>Trajanje od<span class="required">*</span></label><br/>
                <input class="text_input datepicker_up" required="required" type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />

                <label class="icon eye-blocked-icon" for='publish_down'>do</label><br>
                <input class="text_input datepicker_down" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' />

                <div style="text-align:right;">
                    <input type="button" class="md-close icon cancel-icon" value="Prekliči">
                    <input class="icon save-icon" type="submit" value="Shrani in dodaj dogodek">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="md-modal md-effect-16" id="modal-image-position-notification">
    <div class="md-content" style="text-align: center;">
        <h3>Položaj slike</h3>
        <h4 style="font-size: 1.5em; background-position: left 5px; opacity: 0.8;">Privzet položaj slike je na spodnji strani članka</h4>
        <p>
           Če želite spremeniti položaj slike, izberite željeni kvadrat na desni strani prikaza priponk.<br>
           Izbirate lahko med desno ali spodnjo stran članka.
        </p>
        <input type="button" class="md-close icon check-icon" value="Zapri">
    </div>
</div>

<!-- NEW IMAGE -->
<div class="md-modal md-effect-16" id="modal-image-form">
    <div class="md-content">
        <h3>Naloži nove slike</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-image-form">
            <label class="icon edit-icon">Naslov<span class="required">*</span></label>
            <input type="text" class="current-image-name" name="content[name]" required="required" placeholder="Naslov">

            <label class="icon edit-icon">Opis<span class="required">*</span></label>
            <textarea placeholder="Kratek opis slik..." class="current-image-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon folder-icon">Naloži slike iz računalnika</label><br>
            <input type="file" name="content[file][]" id="upload-image-local" multiple><br>

            <label for="upload-image-url" class="icon link-icon">URL povezave do slik</label><br>
            <label for="upload-image-url" class="icon notification-icon" style="background-position: left 0px;">Več povezav hkrati ločite med seboj z vejico kot je prikazano v primeru</label>
            <textarea type="url" name="content[from_internet]" id="upload-image-url" style="width:100%; min-height: 75px;" placeholder="http://www.hostpaperz.com/wallpaper/original/10076.jpg, http://www.hdpaperz.com/wallpaper/original/best-hd-wallpapers-for-desktop-7toe6d3o.jpg"></textarea><br>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="button" class="md-trigger icon images-icon" data-modal="modal-select-gallery-form" value="Izberi sliko iz galerije">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-image-button" value="Naloži">
            </div>

            <input type="hidden" name="content[header]" id="upload-header-type" value="true">
            <input type="hidden" name="content[type]" value="multimedia">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-image-ref-id" value="0">
            <input type="hidden" name="content[id]" id="upload-image-id" value="0">
            <input type="hidden" name="content[url]" id="upload-image-url" value="">
        </form>
    </div>
</div>

<!-- EDIT IMAGE -->
<div class="md-modal md-effect-16" id="modal-edit-image-form" style="width:80%;">
    <div class="md-content">
        <h3>Uredi sliko</h3>
        <h2 style="text-align: center; font-size: 1.2em; padding:0px; margin: 5px 0px;">prikazana je originalna slika - za predogled slike kliknite na gumb "povečaj".</h2>
        <p style="text-align: center; padding:0px; margin: 2px 0px; opacity: 0.8;">Slika mora biti v razmerju 300/250 - tako, da se v tem razmerju tudi obrezuje.</p>
        <div style="margin:1%; padding: 0px; background-color: white; width:98%; height: 500px; border: thin solid #ccc; border-radius: 5px;">
            <img src="<?php echo base_url().$article->image->url; ?>" id="modal-edit-image" style="display:block; height:100%; max-height:500px; max-width: 100%; margin:0px auto; border:thin dashed #777; vertical-align: middle;" alt="article image">
        </div>
        <hr>
        <input class="md-close icon cancel-icon" type="button" value="prekliči">

        <form style="display: inline-block;" action="<?php echo base_url()."content/CropImage"; ?>" method="post">
            <input type="button" class="icon crop-icon" id="crop-image" value="obreži sliko">
            <input type="hidden" id="crop-x" name="crop[x]" value="">
            <input type="hidden" id="crop-y" name="crop[y]" value="">
            <input type="hidden" id="crop-w" name="crop[w]" value="">
            <input type="hidden" id="crop-h" name="crop[h]" value="">
            <input type="hidden" id="crop-x2" name="crop[x2]" value="">
            <input type="hidden" id="crop-y2" name="crop[y2]" value="">
            <input type="hidden" class="current-image-id" name="crop[image_id]" value="<?php echo $article->image->id; ?>">
            <input type="hidden" name="crop[asoc_id]" value="<?php echo $article->id; ?>">
        </form>

        <form style="display: inline-block;" action="<?php echo base_url()."content/GreyscaleImage"; ?>" method="post">
            <input type="hidden" class="current-image-id" name="image[image_id]" value="<?php echo $article->image->id; ?>">
            <input type="hidden" name="image[asoc_id]" value="<?php echo $article->id; ?>">
            <input class="icon wand-icon" type="submit" value="spremeni v črno-belo">
        </form>

        <form style="display: inline-block;" action="<?php echo base_url()."content/FlipImage"; ?>" method="post">
            <input type="hidden" class="current-image-id" name="image[image_id]" value="<?php echo $article->image->id; ?>">
            <input type="hidden" name="image[asoc_id]" value="<?php echo $article->id; ?>">
            <input class="icon flip-icon" type="submit" value="zasukaj sliko horizontalno">
        </form>

        <form style="display: inline-block; float:right;" action="<?php echo base_url()."content/DeleteAttachment"; ?>" class="ajax-form delete-image" method="post">
            <input type="hidden" class="current-image-id" name="attachment[id]" value="<?php echo $article->image->id; ?>">
            <input type="hidden" name="attachment[asoc_id]" value="<?php echo $article->id; ?>">
            <input class="md-close icon delete-icon" type="submit" value="izbriši">
        </form>
    </div>
</div>

<!-- NEW GALLERY -->
<div class="md-modal md-effect-16" id="modal-gallery-form">
    <div class="md-content">
        <h3>Naloži novo galerijo slik</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-image-form">
            <label class="icon edit-icon">Naslov galerije<span class="required">*</span></label>
            <input type="text" id="upload-image-name" name="content[name]" required="required" placeholder="Naslov galerije">

            <label class="icon edit-icon">Opis galerije<span class="required">*</span></label>
            <textarea placeholder="Kratek opis slik, ki jih boste dodali..." id="upload-image-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon folder-icon">Naloži slike iz računalnika</label><br>
            <input type="file" name="content[file][]" multiple id="upload-image-local"><br>

            <label for="upload-url" class="icon link-icon">URL povezave do slik</label><br>
            <textarea type="url" name="content[from_internet]" style="min-height:150px; width:99%;" id="upload-image-url" placeholder="Povezave med seboj ločite z vejico."></textarea><br>

            <p class="icon notification-icon" style="background-position: left 1px;">Dodate lahko tako slike iz računalnika kot tudi preko URL povezav hkrati.</p>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-image-button" value="Naloži">
            </div>

            <input type="hidden" name="content[header]" id="upload-header-type" value="true">
            <input type="hidden" name="content[type]" value="gallery">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-image-ref-id" value="0">
            <input type="hidden" name="content[id]" id="upload-image-id" value="0">
        </form>
    </div>
</div>

<!-- SELECT FROM GALLERY -->
<div class="md-modal md-effect-16" id="modal-select-gallery-form"  style="width: 80%;">
    <div class="md-content">
        <h3>Izberi sliko iz galerije</h3>
        <section class="ff-container">
            <input id="select-type-all" name="radio-set-1" type="radio" class="ff-selector-type-all" checked="checked" />
            <label for="select-type-all" class="ff-label-type-all">vse slike</label>

            <?php for($i = 0;$i<sizeof($gallery->categories);$i++) { if($gallery->categories[$i]->name == "uncategorized") $gallery->categories[$i]->name = "neopredeljeno" ?>

            <input id="select-type-<?php echo $i+1; ?>" name="radio-set-1" type="radio" class="ff-selector-type-<?php echo $i+1; ?>" />
            <label for="select-type-<?php echo $i+1; ?>" class="ff-label-type-<?php echo $i+1; ?>"><?php echo $gallery->categories[$i]->name; ?></label>

            <?php } ?>

            <div class="clr"></div>

            <ul class="ff-items scrollbar" style="position: relative; overflow: hidden; height:400px; ">
                <?php foreach($gallery->images as $image) { foreach($gallery->categories as $key=>$value) { if($value->name == $image->category) { $index = $key; break; } } ?>
                    <li class="ff-item-type-<?php echo $index+1; ?>">
                        <a href="<?php echo base_url().$image->url; ?>" class="select-gallery-image">
                            <span><?php echo $image->name; ?></span>
                            <img src="<?php echo base_url().$image->url; ?>" style="height:100%; margin: 0px auto; " />
                            <form action="<?php echo base_url()."content/SetGalleryImage"; ?>" class="select-gallery-image-form" method="post">
                                <input type="hidden" name="gallery[name]" value="<?php echo $image->name; ?>">
                                <input type="hidden" name="gallery[description]" value="<?php echo $image->description; ?>">
                                <input type="hidden" name="gallery[url]" value="<?php echo $image->url; ?>">
                                <input type="hidden" name="gallery[format]" value="<?php echo $image->format; ?>">
                                <input type="hidden" name="gallery[id]" value="<?php echo $image->id; ?>">
                                <input type="hidden" name="gallery[asoc_id]" value="<?php echo $article->id; ?>">
                                <input type="hidden" name="gallery[header]" class="gallery-image-header" value="true">
                                <input type="hidden" name="gallery[update]" class="gallery-image-update" value="true">
                                <input type="hidden" name="gallery[update_id]" class="gallery-image-update-id" value="<?php echo $article->image->id; ?>">
                                <input type="hidden" name="gallery[update_ref_id]" class="gallery-image-update-ref-id" value="<?php echo $article->image->ref_id; ?>">
                            </form>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <div style="text-align: right;">
            <input type="button" class="md-close icon cancel-icon" value="Prekliči">
        </div>
    </div>
</div>

<!-- MODAL OVERLAY AND FOOTER -->
<div class="md-overlay"></div>
<p style="opacity: 0.4; font-size: 1.2em; color:#222; position: absolute; bottom:0px; left:45%; ">&copy; zelnik.net, <?php echo date("Y"); ?></p>