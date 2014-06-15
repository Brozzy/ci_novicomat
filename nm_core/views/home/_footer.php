<!-- NEW EVENT -->
<div class="md-modal md-effect-16" id="modal-event-form">
    <div class="md-content">
        <h3>Dodaj dogodek</h3>
        <div>
            <p>Tukaj lahko dodate nov dogodek.</p>
            <ul>
                <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
                <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
                <li><strong>Close:</strong> click on the button below to close the modal.</li>
            </ul>
            <button class="md-close">Close me!</button>
        </div>
    </div>
</div>

<!-- NEW IMAGE -->
<div class="md-modal md-effect-16" id="modal-image-form">
    <div class="md-content">
        <h3>Naloži novo sliko</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-image-form">
            <label class="icon edit-icon">Naslov slike<span class="required">*</span></label>
            <input type="text" id="upload-image-name" name="content[name]" required="required" placeholder="Naslov slike">

            <label class="icon edit-icon">Opis slike<span class="required">*</span></label>
            <textarea placeholder="Kratek opis slike..." id="upload-image-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon folder-icon">Naloži sliko iz računalnika</label><br>
            <input type="file" name="content[file]" id="upload-image-local"><br>

            <label for="upload-url" class="icon link-icon">URL povezava do slike</label><br>
            <input type="url" name="content[from_internet]" id="upload-image-url" placeholder="http://...."><br>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="button" class="md-trigger icon images-icon" data-modal="modal-gallery-form" value="Izberi sliko iz galerije">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-image-button" value="Naloži">
            </div>

            <input type="hidden" name="content[header]" id="upload-header-type" value="true">
            <input type="hidden" name="content[type]" value="multimedia">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-image-ref-id" value="0">
            <input type="hidden" name="content[id]" id="upload-image-id" value="0">
        </form>
    </div>
</div>

<!-- EDIT IMAGE -->
<div class="md-modal md-effect-16" id="modal-edit-image-form">
    <div class="md-content">
        <h3>Uredi sliko</h3>
        <p style="text-align: center;">Slika mora biti velikosti vsaj 300x250 (px) - tako, da se obrezuje v tem razmerju.</p>
        <div style="padding: 10px;">
            <img src="<?php echo base_url().$article->image->url; ?>" id="modal-edit-image" style="width:100%; max-width: 800px; max-height: 500px; " alt="article image">
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
            <input type="hidden" class="current-image-id" name="crop[image_id]" value="25">
        </form>

        <input class="icon rotate-left-icon" type="button" value="spremeni v črno-belo">
    </div>
</div>

<!-- SELECT FROM GALLERY -->
<div class="md-modal md-effect-16" id="modal-gallery-form"  style="width: 80%;">
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

            <ul class="ff-items scrollbar" style="position: relative; overflow: hidden; max-height:400px; ">
                <?php foreach($gallery->images as $image) { foreach($gallery->categories as $key=>$value) { if($value->name == $image->category || ($value->name == "neopredeljeno" && $image->category == "uncategorized")) { $index = $key; break; } } ?>
                    <li class="ff-item-type-<?php echo $index+1; ?>">
                        <a href="<?php echo base_url().$image->url; ?>" class="select-gallery-image">
                            <span><?php echo $image->name; ?></span>
                            <img src="<?php echo base_url().$image->url; ?>" />
                            <form action="<?php echo base_url()."content/SetGalleryImage"; ?>" class="select-gallery-image-form" method="post">
                                <input type="hidden" name="gallery[basename]" value="<?php echo basename($image->url); ?>">
                                <input type="hidden" name="gallery[format]" value="<?php echo $image->format; ?>">
                                <input type="hidden" name="gallery[id]" value="<?php echo $image->id; ?>">
                                <input type="hidden" name="gallery[asoc_id]" value="<?php echo $article->id; ?>">
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