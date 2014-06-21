<!-- FORM DISPLAY -->
<section>
    <header>
        <h2>Urejanje prispevka</h2>
    </header>
    <section id="content-edit">
        <form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

            <section class="editable-row">
                <!-- NAME, DESCRIPTION, TEXT -->
                <div class="first-column">
                    <label class="icon edit-icon" for='name'>Naslov<span class="required">*</span></label><br/>
                    <input type='text' required="required" name='content[name]' size="30" id='name' value='<?php echo $article->name; ?>' />

                    <label class="icon edit-icon" for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?><span class="required">*</span></label><br/>
                    <textarea name='content[description]' required="required" style="width:60%; min-height:50px; border-color:#777;" id='description'><?php echo $article->description; ?></textarea><br/>

                    <label class="icon edit-icon" for='text'>Besedilo<span class="required">*</span></label><br/>
                    <textarea class="editor" name='content[text]' required="required" style="width:100%; min-height:150px;" id='text'><?php echo $article->text; ?></textarea><br/>

                    <input type="hidden" value='<?php echo $article->id; ?>' name='content[id]'>
                    <input type="hidden" value='<?php echo $article->ref_id; ?>' name='content[ref_id]'>
                    <input type="hidden" value='<?php echo $article->type; ?>' name='content[type]'>
                </div>

                <!-- HEADER IMAGE -->
                <div class="second-column">
                    <label class="md-trigger icon image-icon" data-modal="modal-image-form">Naslovna slika<span class="required">*</span></label><br/>
                    <div class="view view-first" style="background-color:white; overflow: hidden; border:thin solid #888; border-radius:5px;" >
                        <img src='<?php echo base_url().$article->image->display."?img=".rand(0,1000); ?>' class="article-header-image" id="image-<?php echo $article->image->id; ?>" style="display:block; margin:0px auto; min-width:300px; min-height: 250px; max-height: 250px;" alt='article header image' />
                        <div class="mask">
                            <h2><?php echo $article->image->name; ?></h2>
                            <p><?php echo $article->image->description; ?></p>

                            <?php if($article->image->url != "style/images/icons/png/pictures.png") { ?>
                            <a href="<?php echo base_url().$article->image->display."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $article->image->name; ?>">Povečaj</a>
                            <?php } ?>

                            <a href="#" class="md-trigger upload-image-button header-image new-image info " data-modal="modal-image-form">Naloži</a>

                            <?php if($article->image->url != "style/images/icons/png/pictures.png") { ?>
                            <a href="#" class="md-trigger info edit-image-button header-image" data-modal="modal-edit-image-form">Uredi</a>
                            <?php } ?>

                            <input type="hidden" value="<?php echo $article->image->url; ?>" name="image_url">
                            <input type="hidden" value="<?php echo $article->image->ref_id; ?>" name="image_ref_id">
                            <input type="hidden" value="<?php echo $article->image->id; ?>" name="image_id">
                            <input type="hidden" value="<?php echo $article->image->display; ?>" name="image_display">
                        </div>
                    </div>
                </div>
            </section>

            <hr>

            <section class="editable-row">
                <!-- MISC CHECKBOXES (AUTHOR NAME, PUBLISH_UP, PUBLISH_DOWN...) -->
                <div class="first-column">
                    <label class="icon user-icon" for='author_name'>Ime avtorja<span class="required">*</span></label><br/>
                    <input type='text' required="required" name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' />

                    <label class="icon eye-icon" for='publish_up'>Objava od<span class="required">*</span></label><br/>
                    <input class="datepicker_up" required="required" type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' />

                    <label class="icon eye-blocked-icon" for='publish_down'>Objava do</label><br>
                    <input class="datepicker_down" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' />

                    <label class="icon tags-icon" for='article_tags'>Ključne besede<span class="required">*</span></label><br/>
                    <textarea class="tags" required="required" style="width:100%; min-height:60px;" name='content[tags]'><?php echo $article->tags; ?></textarea><br>

                    <label class="icon locked-icon" for="locked-content" title="Pomeni, da ne more istočasno urejati članka še drug urednik.">Urejanje članka je zaklenjeno. Članek trenutno lahko urejate samo vi.</label>
                </div>

                <!-- ADD ATTACHMENT BUTTONS -->
                <div class="second-column">
                    <input class="icon images-icon upload-image-button md-trigger new-image" data-modal="modal-image-form" type="button" value="Dodaj slike" ><br>
                    <input class="icon video-icon md-trigger" data-modal="modal-video-form" type="button" value="Dodaj video" ><br>
                    <input class="icon music-icon md-trigger" type="button" value="Dodaj glasbeni posnetek" data-modal="modal-audio-form" ><br>
                    <input class="icon file-icon md-trigger" type="button" value="Dodaj dokument"  data-modal="modal-document-form" ><br>
                    <input class="md-trigger icon calendar-icon" data-modal="modal-event-form" type="button" value="Dodaj dogodek" ><br>
                    <input class="icon location-icon" type="button" value="Označi lokacijo" ><br>
                    <input class="icon link-icon" type="button" value="Poveži z obstoječim člankom" ><br>
                    <input class="icon users-icon" type="button" value="Dodaj urednika" ><br>
                </div>
            </section>

            <hr>

            <!-- DISPLAY ATTACHMENTS -->
            <section id="attachments-section">
                <?php if($article->attachments_count > 0) { ?>
                    <h3 class='icon attachment-icon' style='background-position: left 10px; padding-top:5px; padding-bottom:10px;'>Priponke</h3>
                <?php } ?>
                <div>
                    <?php foreach($article->attachments as $attachment)  {
                        if(get_class($attachment) == "image") { ?>
                            <div class="attachment-wrapper">
                                <div class="attachment-image-wrapper">
                                    <a href="<?php echo base_url().$attachment->display."?img=".rand(0,1000); ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                                        <img class="attachment-image" src='<?php echo base_url().$attachment->display."?img=".rand(0,1000); ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                                    </a>
                                </div>
                                <div style="position:relative; margin-left:210px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                                    <h2><?php echo $attachment->name; ?></h2>
                                    <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>
                                    <input type="hidden" value="<?php echo $attachment->ref_id; ?>" name="image_ref_id">
                                    <input type="hidden" value="<?php echo $attachment->id; ?>" name="image_id">
                                    <input type="hidden" value="<?php echo $attachment->url; ?>" name="image_url">

                                    <div style="position: absolute; bottom:0px; left:0px;">
                                        <input type="button" class="md-trigger icon upload-icon upload-image-button new-image existing-image" data-modal="modal-image-form" value="Naloži">
                                        <input type="button" class="md-trigger icon edit-icon edit-image-button" data-modal="modal-edit-image-form" value="Uredi">
                                        <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">
                                        <input type="button" class="md-trigger icon question-icon image-position-button" data-modal="modal-image-position-notification" value="Položaj slike">
                                        <input type="hidden" name='id' value="<?php echo $attachment->id; ?>">
                                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                        <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                        <input type="hidden" name='display' value="<?php echo $attachment->display; ?>">
                                    </div>
                                </div>
                                <div class="attachment-position-wrapper">
                                    <table class="attachment-position">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td style="width:45px;" class="area right <?php if($attachment->position == "right") echo "selected"; ?>"><input type="hidden" name='id' value="<?php echo $attachment->ref_id; ?>"></td>
                                        </tr>
                                        <tr style="height:30px;">
                                            <td colspan="2" class="area bottom <?php if($attachment->position == "bottom") echo "selected"; ?>"><input type="hidden" name='id' value="<?php echo $attachment->ref_id; ?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php  } else if(get_class($attachment) == "video") { ?>
                            <div class="attachment-wrapper" style="height: 200px; background:transparent url('<?php echo base_url()."style/images/icons/svg/play.svg"; ?>') no-repeat 98% 15px;">
                                <div class="attachment-image-wrapper" style="width: 250px;">
                                    <?php if($attachment->source == "internet") { ?>
                                        <iframe width="250" height="180" style="margin-top:5px;" src="<?php echo $attachment->url; ?>" frameborder="0" allowfullscreen></iframe>
                                    <?php } else { ?>
                                        <video width="250" height="180" controls style="margin-top:5px;">
                                            <source src="<?php echo base_url().$attachment->url; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php } ?>
                                </div>
                                <div style="position:relative; margin-left:260px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                                    <h2><?php echo $attachment->name; ?></h2>
                                    <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>

                                    <div style="position: absolute; bottom:0px; left:0px;">
                                        <input type="button" class="md-trigger icon edit-icon edit-content-button" data-modal="modal-content-edit-form" value="Uredi">
                                        <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">
                                        <input type="hidden" name='id' value="<?php echo $attachment->id; ?>">
                                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                        <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                        <input type="hidden" name='type' value="video">
                                        <input type="hidden" name='name' value="<?php echo $attachment->name; ?>">
                                        <input type="hidden" name='description' value="<?php echo $attachment->description; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } else if(get_class($attachment) == "audio") { ?>
                            <div class="attachment-wrapper" style="height: 200px; background:transparent url('<?php echo base_url()."style/images/icons/svg/music.svg"; ?>') no-repeat 98% 15px;">
                                <div class="attachment-image-wrapper" style="width: 250px; background:transparent url('<?php echo $attachment->thumbnail; ?>') no-repeat center 90px; ">
                                    <audio controls width="250" height="180"" >
                                        <source src="<?php echo base_url().$attachment->url; ?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                                <div style="position:relative; margin-left:260px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                                    <h2><?php echo $attachment->name; ?></h2>
                                    <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>

                                    <div style="position: absolute; bottom:0px; left:0px;">
                                        <input type="button" class="md-trigger icon edit-icon edit-content-button" data-modal="modal-content-edit-form" value="Uredi">
                                        <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">
                                        <input type="hidden" name='id' value="<?php echo $attachment->id; ?>">
                                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                        <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                        <input type="hidden" name='type' value="audio">
                                        <input type="hidden" name='name' value="<?php echo $attachment->name; ?>">
                                        <input type="hidden" name='description' value="<?php echo $attachment->description; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } else if(get_class($attachment) == "document") { ?>
                            <div class="attachment-wrapper" style="height: 200px; background:transparent url('<?php echo base_url()."style/images/icons/svg/file.svg"; ?>') no-repeat 98% 15px;">
                                <a href="<?php echo base_url().$attachment->url; ?>" target="_self">
                                    <div class="attachment-image-wrapper" style="width: 250px; background:transparent url('<?php echo $attachment->thumbnail; ?>') no-repeat center; ">
                                        &nbsp;
                                    </div>
                                </a>
                                <div style="position:relative; margin-left:260px; margin-right: 210px; padding:5px; height:100%; min-height: 167px;">
                                    <h2><?php echo $attachment->name; ?><small style="margin-left:5px; vertical-align: top; opacity: 0.6; font-size: 0.6em;">[<?php echo $attachment->format; ?>]</small></h2>
                                    <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; "><?php echo substr($attachment->description,0,120); ?></p>

                                    <div style="position: absolute; bottom:0px; left:0px;">
                                        <a class="icon save-icon" href="<?php echo base_url().$attachment->url; ?>" target="_self">Prenesi</a>
                                        <input type="button" class="md-trigger icon edit-icon edit-content-button" data-modal="modal-content-edit-form" value="Uredi">
                                        <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                        <input type="hidden" name='id' value="<?php echo $attachment->id; ?>">
                                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                        <input type="hidden" name='url' value="<?php echo $attachment->url; ?>">
                                        <input type="hidden" name='type' value="document">
                                        <input type="hidden" name='name' value="<?php echo $attachment->name; ?>">
                                        <input type="hidden" name='description' value="<?php echo $attachment->description; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } else if(get_class($attachment) == "event") { ?>
                            <div class="attachment-wrapper" style="height: 167px; background:transparent url('<?php echo base_url()."style/images/icons/svg/calendar.svg"; ?>') no-repeat 98% 15px;">
                                <div class="attachment-image-wrapper">
                                    <a href="<?php echo base_url().$attachment->image->display; ?>" class="info fancybox" rel="content-images" title="<?php echo $attachment->name; ?>">
                                        <img class="attachment-image" src='<?php echo base_url().$attachment->image->display; ?>' id="image-<?php echo $attachment->id; ?>" alt='attachment image'>
                                    </a>
                                </div>
                                <div style="position:relative; margin-left:210px; padding:5px; height:100%; min-height: 167px;">
                                    <h2><?php echo $attachment->name; ?></h2>
                                    <p style="padding-left: 3px; opacity: 0.6; word-break: break-all; padding:2px 0px; margin:0px; "><?php echo substr($attachment->description,0,120); ?></p>
                                    <p style="opacity: 0.8;">
                                        Pričetek dogodka <strong><?php echo $attachment->display_start_date; ?></strong> <small class="icon clock-icon" style="margin-left:10px; background-position: left 0px; background-size: 14px;"><?php echo $attachment->exact_date_start; ?></small>
                                        <?php if($attachment->exact_date_end != "") { ?><br>in konec <strong><?php echo $attachment->display_end_date; ?></strong> <small class="icon clock2-icon" style="margin-left:10px; background-position: left 0px; background-size: 14px;"><?php echo $attachment->exact_date_end; ?></small> <?php } ?>
                                    </p>
                                    <div style="position: absolute; bottom:0px; left:0px;">
                                        <input type="button" class="md-trigger icon edit-icon edit-event-button" data-modal="modal-edit-event-form" value="Uredi">
                                        <input type="button" class="icon location-icon" value="Lokacija">
                                        <input type="button" class="icon delete-icon delete-attachment-button" value="Izbriši">

                                        <input type="hidden" name='id' value="<?php echo $attachment->id; ?>">
                                        <input type="hidden" name='ref_id' value="<?php echo $attachment->ref_id; ?>">
                                        <input type="hidden" name='asoc_id' value="<?php echo $article->id; ?>">
                                        <input type="hidden" name='type' value="event">
                                        <input type="hidden" name='name' value="<?php echo $attachment->name; ?>">
                                        <input type="hidden" name='description' value="<?php echo $attachment->description; ?>">
                                        <input type="hidden" name='start_date' value="<?php echo $attachment->start_date; ?>">
                                        <input type="hidden" name='end_date' value="<?php echo $attachment->end_date; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

            </section>

            <!-- MEDIA PUBLISH -->
            <section class="editable-row">
                <h3 class="icon list-icon">Objavi na naslednjih medijih</h3>
                <div style="width:100%;">
                    <?php
                    function loop_trough($value) {
                        if(is_array($value)) {
                            foreach($value as $v) {
                                echo "<ul style='padding-left:40px;'>";
                                loop_trough($v);
                                echo "</ul>";
                            }
                        }
                        else echo "<li style='padding-left:40px;'><span>".$value."</span><input type='checkbox' name='content[media][]' value='".$value."'></li>";
                    }

                    foreach($article->media as $media) {
                        echo "<ul class='media'>";
                            echo "<li><img src='".$media->favicon."' alt='media favicon'><span>".$media->media."</span><input type='checkbox' name='content[media][]' value='".$media->media."'></li>";
                            foreach($media->menu as $menu)
                                loop_trough($menu);
                        echo "</ul>";
                    }
                    ?>
                </div>
            </section>

            <hr>

            <!-- CANCEL, SAVE, PUBLISH BUTTONS -->
            <section class="editable-row">
                <input class="icon home-icon" type='button' value='nazaj na domačo stran' onclick="window.location.href='<?php echo base_url()."Domov"; ?>'"/>
                <input class="icon save-icon" type='submit' style="float:right;" value='samo shrani' formaction='<?php echo base_url()."content/Update"; ?>'/>

                <?php if($user->level > 3) { ?>
                    <input class="icon publish-icon" type='submit' value='objavi' formaction='<?php echo base_url()."content/Publish"; ?>'/>
                <?php } else { ?>
                    <input class="icon checkout-icon" type='submit' style="float:right; margin-right:15px;" value='shrani in pošlji v pregled' formaction='<?php echo base_url()."content/Editing"; ?>'/>
                <?php } ?>
            </section>

        </form>
    </section>
</section>

<!-- CONTENT EDIT -->
<div class="md-modal md-effect-16" id="modal-content-edit-form">
    <div class="md-content">
        <h3>Uredi vsebino</h3>
        <div>
            <form action="<?php echo base_url()."content/Update"; ?>" class="content-edit-form" method="post">
                <label class="icon edit-icon">Naslov<span class="required">*</span></label>
                <input type="text" style="width:50%;" class="current-content-name" name="content[name]" required="required" placeholder="Naslov">

                <label class="icon edit-icon">Kratek opis<span class="required">*</span></label>
                <textarea class="current-content-description" required="required" style="width:100%; min-height:150px;" name="content[description]"></textarea>

                <input type="hidden" name="content[id]" class="current-content-id">
                <input type="hidden" name="content[asoc_id]" class="current-content-asoc-id" value="<?php echo $article->id; ?>">
                <input type="hidden" name="content[type]" class="current-content-type" >
                <input type="hidden" name="content[url]" class="current-content-url" >

                <div style="text-align:right;">
                    <input type="button" class="md-close icon cancel-icon" value="Prekliči">
                    <input class="icon save-icon" type="submit" value="Shrani">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- IMAGE POSITION NOTIFICATION -->
<div class="md-modal md-effect-16" id="modal-image-position-notification">
    <div class="md-content" style="text-align: center;">
        <h3>Položaj slike</h3>
        <h4 style="font-size: 1.5em; background-position: left 5px; opacity: 0.8;">Privzet položaj slike je na spodnji strani članka</h4>
        <p>
            Če želite spremeniti položaj slike, izberite željeni kvadrat na desni strani prikaza priponk.<br>
            Izbirate lahko med <strong>desno</strong> ali <strong>spodnjo stran</strong> članka.
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

        <form style="display: inline-block;" action="<?php echo base_url()."content/GreyscaleImage"; ?>" class="transform-image-form" method="post">
            <input type="hidden" class="current-image-id" name="image[image_id]" value="<?php echo $article->image->id; ?>">
            <input type="hidden" class="current-image-url" name="url" value="<?php echo $article->image->url; ?>">
            <input type="hidden" class="current-image-display" name="display" value="<?php echo $article->image->display; ?>">
            <input type="hidden" name="image[asoc_id]" value="<?php echo $article->id; ?>">
            <input class="md-close icon wand-icon" type="submit" value="spremeni v črno-belo">
        </form>

        <form style="display: inline-block;" action="<?php echo base_url()."content/FlipImage"; ?>" class="transform-image-form" method="post">
            <input type="hidden" class="current-image-id" name="image[image_id]" value="<?php echo $article->image->id; ?>">
            <input type="hidden" class="current-image-url" name="url" value="<?php echo $article->image->url; ?>">
            <input type="hidden" class="current-image-display" name="display" value="<?php echo $article->image->display; ?>">
            <input type="hidden" name="image[asoc_id]" value="<?php echo $article->id; ?>">
            <input class="md-close icon flip-icon" type="submit" value="zasukaj sliko horizontalno">
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

<!-- NEW VIDEO -->
<div class="md-modal md-effect-16" id="modal-video-form">
    <div class="md-content">
        <h3>Naloži nov video posnetek</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-video-form">
            <label class="icon edit-icon">Naslov<span class="required">*</span></label>
            <input type="text" class="current-video-name" name="content[name]" required="required" placeholder="Naslov">

            <label class="icon edit-icon">Opis<span class="required">*</span></label>
            <textarea placeholder="Kratek opis video posnetka..." class="current-video-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon folder-icon">Naloži video iz računalnika.</label><br>
            <small class="icon notification-icon" style="background-position: left 0px; padding-bottom: 5px;">Format mora biti .mp4 in ne sme presegati velikosti več kot 55Mb.</small><br><br>
            <input type="file" accept="video/mp4" name="content[file][]" id="upload-video-local" multiple><br>

            <label for="upload-video-url" class="icon youtube-icon">YouTube povezava do video posnetka</label><br>
            <label for="upload-video-url" class="icon notification-icon" style="background-position: left 0px; padding-bottom: 5px;">Več povezav hkrati ločite med seboj z vejico kot je prikazano v primeru</label>
            <textarea type="url" name="content[from_internet]" id="upload-video-url" style="width:100%; min-height: 75px;" placeholder="http://www.youtube.com/watch?v=b6vSf0cA9qY, http://www.youtube.com/watch?v=cFf85n-Im8Q"></textarea><br>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-video-button" value="Naloži">
            </div>

            <input type="hidden" name="content[type]" value="video">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-video-ref-id" value="0">
            <input type="hidden" name="content[id]" id="upload-video-id" value="0">
            <input type="hidden" name="content[url]" id="upload-video-url" value="">
        </form>
    </div>
</div>

<!-- NEW AUDIO -->
<div class="md-modal md-effect-16" id="modal-audio-form">
    <div class="md-content">
        <h3>Naloži glasbene posnetke</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-audio-form">
            <label class="icon edit-icon">Naslov<span class="required">*</span></label>
            <input type="text" class="current-audio-name" name="content[name]" required="required" placeholder="Naslov">

            <label class="icon edit-icon">Opis<span class="required">*</span></label>
            <textarea placeholder="Kratek opis posnetka..." class="current-audio-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon folder-icon">Naloži posnetke iz računalnika.</label><br>
            <small class="icon notification-icon" style="background-position: left 0px; padding-bottom: 5px;">Format mora biti .mp3 in ne sme presegati velikosti več kot 55Mb.</small><br><br>
            <input type="file" accept="audio/mp3" name="content[file][]" id="upload-audio-local" multiple><br>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-audio-button" value="Naloži">
            </div>

            <input type="hidden" name="content[type]" value="audio">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-audio-ref-id" value="0">
            <input type="hidden" name="content[id]" class="current-content-id" id="upload-audio-id" value="0">
            <input type="hidden" name="content[url]" class="current-content-url" id="upload-audio-url" value="">
        </form>
    </div>
</div>

<!-- NEW DOCUMENT -->
<div class="md-modal md-effect-16" id="modal-document-form">
    <div class="md-content">
        <h3>Naloži datoteke</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-document-form">
            <label class="icon edit-icon">Naslov<span class="required">*</span></label>
            <input type="text" class="current-document-name" name="content[name]" required="required" placeholder="Naslov">

            <label class="icon edit-icon">Opis<span class="required">*</span></label>
            <textarea placeholder="Kratek opis..." class="current-document-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon folder-icon">Naloži datoteko iz računalnika.</label><br>
            <small class="icon notification-icon" style="background-position: left 0px; padding-bottom: 5px;">Format mora biti .pdf, .doc ali .docx in ne sme presegati velikosti več kot 55Mb.</small><br><br>
            <input type="file" accept="application/msword, application/pdf" name="content[file][]" id="upload-document-local" multiple><br>

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-document-button" value="Naloži">
            </div>

            <input type="hidden" name="content[type]" value="document">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-audio-ref-id" value="0">
            <input type="hidden" name="content[id]" class="current-content-id" id="upload-audio-id" value="0">
            <input type="hidden" name="content[url]" class="current-content-url" id="upload-audio-url" value="">
        </form>
    </div>
</div>

<!-- NEW EVENT -->
<div class="md-modal md-effect-16" id="modal-event-form">
    <div class="md-content">
        <h3>Dodaj dogodek</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-event-form">
            <label class="icon edit-icon">Naslov<span class="required">*</span></label>
            <input type="text" class="current-event-name" name="content[name]" required="required" placeholder="Naslov">

            <label class="icon edit-icon">Opis<span class="required">*</span></label>
            <textarea placeholder="Kratek opis..." class="current-event-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon image-icon" style="background-position: left 0px;">Dodajte dogodku naslovno sliko</label><br>
            <input type="file" accept="image/*" name="content[file][]" id="upload-event-local" multiple><br>

            <label class="icon eye-icon" for='publish_up'>Začetek dogodka<span class="required">*</span></label><br/>
            <input class="datepicker_up_event" required="required" type='text' name='content[start_date]' id='publish_up_event' />

            <label class="icon eye-blocked-icon" for='publish_down'>Konec</label><br>
            <input class="datepicker_down_event" type='text' name='content[end_date]' id='publish_down_event' />

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="submit" class="icon upload-icon modal-submit-button" id="upload-document-button" value="Dodaj">
            </div>

            <input type="hidden" name="content[type]" value="event">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-event-ref-id" value="0">
            <input type="hidden" name="content[id]" class="current-content-id" id="upload-event-id" value="0">
            <input type="hidden" name="content[url]" class="current-content-url" id="upload-event-url" value="">
        </form>
    </div>
</div>

<!-- EDIT EVENT -->
<div class="md-modal md-effect-16" id="modal-edit-event-form">
    <div class="md-content">
        <h3>Dodaj dogodek</h3>
        <form action="<?php echo base_url()."content/Update"; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" id="new-event-form">
            <label class="icon edit-icon">Naslov<span class="required">*</span></label>
            <input type="text" class="current-event-name" name="content[name]" required="required" placeholder="Naslov">

            <label class="icon edit-icon">Opis<span class="required">*</span></label>
            <textarea class="current-event-description" required="required" style="width:70%; height:70px;" name="content[description]"></textarea>

            <label for="upload-local" class="icon image-icon" style="background-position: left 0px;">Dodajte dogodku naslovno sliko</label><br>
            <input type="file" accept="image/*" name="content[file][]" id="upload-event-local" multiple><br>

            <label class="icon eye-icon" for='publish_up'>Začetek dogodka<span class="required">*</span></label><br/>
            <input class="datepicker_up_event" required="required" type='text' name='content[start_date]' />

            <label class="icon eye-blocked-icon" for='publish_down'>Konec</label><br>
            <input class="datepicker_down_event" type='text' name='content[end_date]' />

            <div style="text-align: right;">
                <input type="button" value="Prekliči" class="icon cancel-icon md-close">
                <input type="submit" class="icon save-icon modal-submit-button" value="Shrani">
            </div>

            <input type="hidden" name="content[type]" value="event">
            <input type="hidden" name="content[asoc_id]" value="<?php echo $article->id; ?>">
            <input type="hidden" name="content[ref_id]" id="upload-event-ref-id" value="0">
            <input type="hidden" name="content[id]" class="current-event-id" value="0">
        </form>
    </div>
</div>

<!-- MODAL OVERLAY -->
<div class="md-overlay"></div>
