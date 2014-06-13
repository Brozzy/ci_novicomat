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
            <input type="url" name="content[url]" id="upload-image-url" placeholder="http://...."><br>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="button" class="md-trigger icon images-icon" data-modal="modal-gallery-form" value="Izberi sliko iz galerije">
                <input type="submit" class="icon file-icon modal-submit-button" value="Naloži">
            </div>

            <input type="hidden" name="content[header]" id="upload-header-type" value="true">
            <input type="hidden" name="content[type]" value="multimedia">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-image-ref-id" value="0">
            <input type="hidden" name="content[id]" id="upload-image-id" value="0">
        </form>
    </div>
</div>

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

<div class="md-modal md-effect-16" id="modal-gallery-form"  style="width: 80%;">
    <div class="md-content">
        <h3>Izberi sliko iz galerije</h3>
        <section class="ff-container">
            <input id="select-type-all" name="radio-set-1" type="radio" class="ff-selector-type-all" checked="checked" />
            <label for="select-type-all" class="ff-label-type-all">Zelnik.net slike</label>

            <input id="select-type-1" name="radio-set-1" type="radio" class="ff-selector-type-1" />
            <label for="select-type-1" class="ff-label-type-1">Lokacije</label>

            <input id="select-type-2" name="radio-set-1" type="radio" class="ff-selector-type-2" />
            <label for="select-type-2" class="ff-label-type-2">Dogodki</label>

            <input id="select-type-3" name="radio-set-1" type="radio" class="ff-selector-type-3" />
            <label for="select-type-3" class="ff-label-type-3">Narava</label>

            <div class="clr"></div>

            <ul class="ff-items">
                <li class="ff-item-type-2">
                    <a href="<?php echo base_url().$article->image->large; ?>" class="fancybox" rel="gallery" title="<?php echo $article->image->description; ?>">
                        <span><?php echo $article->image->name; ?></span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-1">
                    <a href="http://dribbble.com/shots/272575-Tutorials-wip-">
                        <span>Tutorials (wip)</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-1">
                    <a href="http://dribbble.com/shots/138484-Symplas-website">
                        <span>Symplas website</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-1">
                    <a href="http://dribbble.com/shots/188524-Event-Planning">
                        <span>Event Planning</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-2">
                    <a href="http://dribbble.com/shots/347197-Cake">
                        <span>Cake</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-2">
                    <a href="http://dribbble.com/shots/372566-Flower">
                        <span>Flower</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-3">
                    <a href="http://dribbble.com/shots/134868-TRON-Mobile-ver-">
                        <span>TRON: Mobile version</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-1">
                    <a href="http://dribbble.com/shots/186199-Tailoring-accessories">
                        <span>Tailoring accessories</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-3">
                    <a href="http://dribbble.com/shots/133859-App-icon">
                        <span>App icon</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
                <li class="ff-item-type-3">
                    <a href="http://dribbble.com/shots/133859-App-icon">
                        <span>App icon</span>
                        <img src="http://www.pachd.com/free-images/food-images/apricots-03.jpg" />
                    </a>
                </li>
            </ul>
        </section>
        <div style="text-align: right;">
            <input type="button" class="md-close icon cancel-icon" value="Prekliči">
        </div>
    </div>
</div>

<div class="md-overlay"></div>

<p style="opacity: 0.4; font-size: 1.2em; color:#222; position: absolute; bottom:0px; left:45%; ">&copy; zelnik.net, <?php echo date("Y"); ?></p>