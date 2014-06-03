
<style type="text/css" scoped>
	#GalleryContainer { width:100%; -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:0.5; }
	#GalleryContainer:hover { -webkit-transition:opacity 0.5s; -moz-transition:opacity 0.5s; transition:opacity 0.5s; opacity:1; }
	.appended { vertical-align:top; }

    .remove_attachment {
        position:absolute;
        top:40px; right:10px;
        width:auto; min-width:auto;
        background-color:Transparent;
        color:white;
        border:none; cursor:pointer;
    }
    .remove_attachment:hover { color:#FF6D68; }
    .attachment {
        position:relative;
        display:inline-block;
        vertical-align:top;
        margin-right:20px;
        padding:5px;
        min-width:300px; min-height:300px;
        border:thin solid #888; margin-bottom:20px;
    }
    .attachment h3 {
        margin:0px 0px 10px 0px;
        border:thin solid #333;
    }

    .attachment h4 {
        text-align:center;
        margin:5px; color:#333;
        text-transform:uppercase;
    }

    .attachment input {
       margin-bottom:10px;
    }

    .attachment hr {
        padding-top:5px;
        margin-bottom:10px;
    }

    .attachment .buttons {
        float:right;
        margin-left:10px;
        cursor:pointer;
    }

    .table-cell {
        display:table-cell;
        border-bottom:thin solid #222;
        padding:15px 0px;
        vertical-align:top;
    }
    .table-cell input {
        margin-bottom:15px;
    }
    section .header-image {
        width:100%;
    }
    section .content {
    }

    .image_display {
        position:absolute;
        left:auto;right:auto; top:5%;
    }

    .fancy_button {
        background-color:transparent;
        border:none;
        background-repeat:no-repeat;
        background-size:150px 150px;
        background-position:center;
        padding-bottom:180px; padding-top:10px;
        width:190px;
        cursor:pointer;
        font-size:1.1em;
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        filter: grayscale(100%);
    }
    .fancy_button:hover {
        -webkit-filter:none;
        filter:none;
        -moz-filter:none;
        background-color:#174371; color:white;
    }

    .video_button {
        background-image:url("<?php echo base_url()."style/images/video.png"; ?>");

    }
    .event_button {
        background-image:url("<?php echo base_url()."style/images/calendar.png"; ?>");
    }

    .location_button {
        background-image:url("<?php echo base_url()."style/images/location.png"; ?>");
    }
    .gallery_button {
        background-image:url("<?php echo base_url()."style/images/gallery.png"; ?>");
    }

    .tags { color: #495d92; }

    .image_settings {
        border:thin solid #BBB;
        padding-top:32px;
        background-repeat:no-repeat;
        background-position:center 3px;
        background-size:30px;
        width:75px;
        position:absolute;
        top:0px; right:4px;
    }

    .image_container {
        position:relative;
        display:block;
        width:580px; padding-right:4px;
        border-right:thin solid #999;
    }

    .crop_button {
        background-image:url('<?php echo base_url()."style/images/crop.png"; ?>');
    }

    .cancel_crop_button {
         background-image:url('<?php echo base_url()."style/images/cancel.png"; ?>');
    }

    .done_crop_button {
        background-image:url('<?php echo base_url()."style/images/checked.png"; ?>');
    }

    .magnifying_glass {
        background-image:url('<?php echo base_url()."style/images/magnifying_glass.png"; ?>');
    }

    .hidden { display:none; }

    .image { padding:0px 3px 15px 0px;}
</style>

<section style='padding:20px; color:#222;'>
	<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='contentForm' enctype="multipart/form-data" >

        <section style="display:table; width:100%;">
            <section class="table-cell content" style="width:75%;" >
                <label for='header_image_upload'>Naslovna slika<span class="required">*</span></label><br/>

                <span id="header_image_wrapper" class="image_container">
                    <img src='<?php echo base_url().$article->image->large."?img=".rand(0,100); ?>' style="max-width:500px; max-height:500px;" alt='article header image' class="image" id='header_image' />
                    <input class='master_input image_settings crop_button' type='button' value='obreži'>
                    <a class='fancybox' rel='image_attachments' href='<?php echo base_url().$article->image->cropped; ?>' title='<?php echo $article->image->description; ?>'>
                        <input class='master_input image_settings magnifying_glass' style="top:65px;" type='button' value='povečaj'>
                    </a>
                    <img src="<?php echo base_url().$article->image->url; ?>" class="hidden hidden_url">
                    <img src="<?php echo base_url().$article->image->large; ?>" class="hidden hidden_large">
                    <input type='hidden' value='<?php echo $article->image->width; ?>' class="hidden_width">
                    <input type='hidden' value='<?php echo $article->image->height; ?>' class="hidden_height">
                </span>

                <input type='file' name='content[file][]' id='header_image_upload' value='' accept='image/*' />

                <br>

                <label for='name'>Naslov<span class="required">*</span></label><br/>
                <input class="text_input" type='text' required name='content[name]' size="30" id='name' value='<?php echo $article->name; ?>' /><br/>

                <label for='description'><?php if($article->type == "article") echo "Uvodno besedilo"; else echo "Opis"; ?><span class="required">*</span></label><br/>
                <textarea class="text_input" name='content[description]' required style="width:60%; min-height:50px; border-color:#777;" id='description'><?php echo $article->description; ?></textarea><br/>

                <?php if($article->type == "article") { ?>
                <label for='text'>Besedilo<span class="required">*</span></label><br/>
                <textarea class="editor" name='content[text]' required style="width:100%; min-height:150px;" id='text'><?php echo $article->text; ?></textarea><br/>
                <?php } ?>

                <input type="hidden" value='<?php echo $article->id; ?>' name='content[id]'>
                <input type="hidden" value='<?php echo $article->ref_id; ?>' name='content[ref_id]'>
                <input type="hidden" value='<?php echo $article->type; ?>' name='content[type]'>
            </section>

            <section class="table-cell gallery" style="padding-left:2%;">
                <?php foreach($article->attachments as $attachment)  {
                    if(isset($attachment->type) && $attachment->type == "gallery") {
                        echo "<div class='attachment image' style='margin:5px 0px;' >
                                        <h4>".$attachment->name."</h4>
                                        <h3>Galerija slik</h3>
                                        ";
                        foreach($attachment->images as $image) {
                            echo "<a class='fancybox' rel='image_attachments_".$image->asoc_id."' href='".base_url().$image->cropped."' title='".$image->description."'>
                                    <img src='".base_url().$image->medium."' style='max-width:300px; max-height:300px;' vertical-align:middle; alt='article header image' class='image' id='header_image' />
                                </a>";
                        }

                        echo "<input type='button' class='remove_attachment' id='remove_".$attachment->id."' value='odstrani'>
                                     </div>";
                    }
                }
                ?>
            </section>
        </section>

        <section style="display:table; width:100%;">
            <?php if($article->type == "article") { ?>
            <section class="table-cell misc" style="width:32.7%;">
                <label for='author_name'>Ime avtorja<span class="required">*</span></label><br/>
                <input class="text_input" type='text' required name='content[author_name]' id='author_name' value='<?php echo $article->author_name; ?>' /><br/>

                <label for='publish_up'>Objava od<span class="required">*</span></label><br/>
                <input class="text_input datepicker" required type='text' name='content[publish_up]' id='publish_up' value='<?php echo $article->publish_up; ?>' /><br>

                <label for='publish_down'>do</label><br>
                <input class="text_input datepicker" type='text' name='content[publish_down]' id='publish_down' value='<?php echo $article->publish_down; ?>' /><br/>

                <label for='article_tags'>Ključne besede<span class="required">*</span></label><br/>
                <input class="text_input tags" type='text' required style="width:90%;" value='<?php echo $article->tags; ?>' name='content[tags]' id='article_tags'/><br/>
            </section>
            <?php } ?>

            <section class="table-cell attachments" style="padding-left:20px;">
                <input class="fancy_button event_button" type="button" id='add_event' value="Dodaj dogodek" >
                <input class="fancy_button video_button" type="button" value="Dodaj video" >
                <input class="fancy_button gallery_button" type="button" id='add_gallery' value="Dodaj slike" >
                <input class="fancy_button location_button" type="button" id='add_location' value="Dodaj lokacijo" >
                <br>
            </section>
        </section>

        <section style="display:table; width:100%;">

            <ul style="padding:0px; list-style:none;" id="attachments_list">
                <?php foreach($article->attachments as $attachment)  {
                    if(isset($attachment->type) && $attachment->type == "multimedia") {
                        echo "<li class='attachment image'>
                                    <h4>".$attachment->name."</h4>
                                    <h3>Slika</h3>
                                    <span class='image_container'>
                                        <img src='".base_url().$attachment->large."' style='max-width:500px; max-height:500px; vertical-align:middle; padding:15px 3px;' alt='article header image' class='image' id='header_image' />
                                        <input class='master_input image_settings crop_button' type='button' value='obreži'>
                                        <a class='fancybox' rel='image_attachments' href='".base_url().$attachment->cropped."' title='".$attachment->description."'>
                                            <input class='master_input image_settings magnifying_glass' style='top:65px;' type='button' value='povečaj'>
                                        </a>
                                        <img src='".base_url().$attachment->url."' class='hidden hidden_url'>
                                        <img src='".base_url().$attachment->large."' class='hidden hidden_large'>
                                        <input type='hidden' value='".base_url().$attachment->width."' class='hidden_width'>
                                        <input type='hidden' value='".base_url().$attachment->height."' class='hidden_height'>
                                    </span>
                                    <input type='button' class='remove_attachment' id='remove_".$attachment->id."' value='odstrani'>
                                 </li>";
                    }
                    else if(isset($attachment->type) && $attachment->type == "event") {
                        echo "<li class='attachment event'>
                                    <h4>".$attachment->name."</h4>
                                    <h3>Dogodek</h3>";
                                    if($attachment->image->medium != "style/images/image_upload.png")
                                        echo "<a class='fancybox' href='".base_url().$attachment->image->url."'>
                                                <img style='max-width:300px; max-height:225px;' src='".base_url().$attachment->image->medium."' alt='image attachment thumbnail'>
                                            </a>";

                       echo        "<p>".$attachment->description."</p>
                                    <p>Začetek: ".$attachment->start_date."</p>
                                    <p>Konec: ".$attachment->end_date."</p>
                                    <input type='button' class='remove_attachment' id='remove_".$attachment->id."' value='odstrani'>
                              </li>";
                    }
                    else if(isset($attachment->type) && $attachment->type == "location")
                        echo "<li class='attachment location'>
                                <h4>".$attachment->country."</h4>
                                <h3>Lokacija</h3>
                                <p>Mesto: ".$attachment->post_number." ".$attachment->city."</p>
                                <p>Ulica ali vas: ".$attachment->street_village."</p>
                                <p>Hišna številka: ".$attachment->house_number."</p>
                                <input type='button' class='remove_attachment' id='".$attachment->id."' value='odstrani'>
                              </li>";
                } ?>
            </ul>
        </section>

        <section style="display:table; width:100%;">
            <?php
                /*function loop_trough($value) {
                    if(is_array($value)) {
                        foreach($value as $v) {
                            echo "<div style='padding-left:30px;'>";
                            loop_trough($v);
                            echo "</div>";
                        }
                    }
                    else echo "<div style='padding-left:30px;'>".$value."</div>";
                }

                foreach($article->domains as $domain) {
                    echo $domain->domain;
                    foreach($domain->menu as $menu) {
                        loop_trough($menu);
                    }
                }*/
            ?>
        </section>

        <section style="display:table; width:100%;">
            <section class="table-cell cp">
                <input class='master_input' type='button' value='Nazaj' onclick="window.location.href='<?php echo base_url()."Domov"; ?>'"/>
                <input class='master_input' type='submit' style="float:right;" value='Shrani' formaction='<?php echo base_url()."content/Update"; ?>'/>

                <?php if($user->level > 3) { ?>
                    <input class='master_input' type='submit' value='Objavi' formaction='<?php echo base_url()."content/Publish"; ?>'/>
                <?php } else { ?>
                    <input class='master_input' type='submit' style="float:right; margin-right:15px;" value='Pošlji v pregled' formaction='<?php echo base_url()."content/Editing"; ?>'/>
                <?php } ?>
            </section>
        </section>
	</form>

</section>

<script type="text/javascript">
    var jcrop_api;

    $(".fancybox").fancybox({
        showNavArrows: true
    });
    $(".editor").jqte();
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date()
    });

    $(".tags").autocomplete({
        source: "<?php echo base_url()."content/GetTags"; ?>",
        minLength: 2,
        focus: function() {
            return false;
        },
        select: function( event, ui ) {
            var terms = $(this).val().split(", ");

            terms.pop();
            terms.push( ui.item.value );
            terms.push( "" );

            this.value = terms.join( ", " );
            return false;
        }
    });


    $(document).on("click",".crop_button",function() {
        $(this).parent().children(".image").remove();
        var url = $(this).parent().children(".hidden_url").attr("src");
        var height = $(this).parent().children(".hidden_height").val();
        var width = $(this).parent().children(".hidden_width").val();

        $(this).parent().append("<img src='"+url+"' alt='header_image' id='header_image' class='image' style='margin-bottom:15px; max-width:500px; max-height:500px; vertical-align:top;'>");

        var Image = $(this).parent().children(".image");

        $(Image).Jcrop({
            onSelect: setCoords,
            aspectRatio: 1.8,
            trueSize: [width,height]
        }, function() { jcrop_api = this });

        var Form =
            "<form action='<?php echo base_url().'content/CropImage'; ?>' method='post' class='cropping_form' style='float:right; position:relative; width:100%;'>"+
                "<input type='hidden' id='crop_x' name='crop[x]' value='' >"+
                "<input type='hidden' id='crop_y' name='crop[y]' value='' >"+
                "<input type='hidden' id='crop_x2' name='crop[x2]' value='' >"+
                "<input type='hidden' id='crop_y2' name='crop[y2]' value='' >"+
                "<input type='hidden' id='crop_w' name='crop[w]' value='' >"+
                "<input type='hidden' id='crop_h' name='crop[h]' value='' >"+
                "<input type='hidden' name='crop[content_id]' value='<?php echo $article->id; ?>' >"+
                "<input type='hidden' name='crop[image_large]' value='<?php echo $article->image->large; ?>' >"+
                "<input type='hidden' name='crop[image_url]' value='<?php echo $article->image->url; ?>' >"+
                "<input type='hidden' name='crop[image_id]' value='<?php echo $article->image->asoc_id; ?>' >"+
                "<br><br>"+
                "<input class='master_input image_settings done_crop_button' style='top:0px; right:0px;' type='submit' value='končaj'>"+
                "<input class='master_input image_settings cancel_crop_button' style='top:65px; right:0px;' type='button' value='prekliči'>"+
            "</form>";

        $(this).parent().css("border-right","thin dashed #666");
        $(this).after(Form);
        $(this).siblings(".fancybox").hide();
        $(this).hide();
    });

    function setCoords(c) {
        $("#crop_x").val(c.x);
        $("#crop_y").val(c.y);
        $("#crop_x2").val(c.x2);
        $("#crop_y2").val(c.y2);
        $("#crop_w").val(c.w);
        $("#crop_h").val(c.h);
    };

    setInterval("Update();",1000);

    function Update() {
        var Form = $("#contentForm").serialize();

        $.ajax({
            url: "<?php echo base_url()."content/Update"; ?>",
            type: "post",
            data: Form
        })
    }

    $(document).on("click",".cancel_crop_button",function() {
        var Image = $(this).parents(".image_container:first").children(".image");
        RemoveCroppingButtons(Image);
    });

    function RemoveCroppingButtons(Image) {
        var large = $(Image).siblings(".hidden_large").attr("src");
        $(Image).parent().css("border-right","thin solid #999");
        $(Image).parent().append("<img src='"+large+"' alt='header_image' class='image' id='header_image' style='max-width:500px; max-height:500px;'>");
        $(Image).remove();

        $(".cropping_form").remove();
        jcrop_api.destroy();
        $(".crop_button").show();
        $(".fancybox").show();
    }

    $(document).on("change","#header_image_upload",function() {
        $("#header_image_upload").after("<span class='loading'><br><img src='<?php echo base_url()."style/images/loading.gif"; ?>' alt='loading'>nalaganje slike..</span>");
        $("#contentForm").submit();
    });

    $(document).on("submit",".cropping_form",function(e) {
        e.preventDefault();
        var Form = $(this);

        if($("#crop_x").val() != '') {
            $(".done_crop_button").css("background-image","url('<?php echo base_url()."style/images/loading.gif"; ?>')");
            $.ajax({
                url: "<?php echo base_url().'content/CropImage'; ?>",
                type: "POST",
                data: $(this).serialize(),
                cache: false,
                success: function(data) {
                    $(".done_crop_button").css("background-image","url('<?php echo base_url()."style/images/checked.png"; ?>')");
                    $(Form).parent().children(".image").remove();
                    $(Form).parent().children(".hidden_large").attr("src",data+"?img="+Math.floor((Math.random()*1000)+1));
                    $(Form).parent().append("<img src='"+data+"?img="+Math.floor((Math.random()*1000)+1)+"' style='max-width:500px; max-height:500px;' class='image' alt='cropped image' id='header_image'>");
                    $(Form).parent().css("border-right","thin solid #999");
                    $(Form).parent().children(".fancybox").attr("href",data+"?img="+Math.floor((Math.random()*1000)+1));
                    $(".cropping_form").remove();
                    $(".crop_button").show();
                    jcrop_api.destroy();
                    $(".fancybox").show();
                }
            });
        }
        else alert("Zajamite mesto na sliki katerega želite obrezati.");
    });

    $("#SaveButton").on("click",function(e) {

        if(CheckForEmpty("contentTags") || CheckForEmpty("contentText")) {
            e.preventDefault();
            alert("Prosim vpišite vsaj eno ključno besedo.");
        }
    });

    $(document).on("click",".remove_appended",function() {
        $(this).parents("li:first").remove();
    });

    $(document).on("click",".remove_attachment",function(e) {
        e.preventDefault();
        var attacthment_id = $(this).attr("id").substr(7);
        $(this).parent().remove();

        $.ajax({
           url: "<?php echo base_url()."content/DeleteAttachment"; ?>",
           type: "post",
           data: { id:attacthment_id, asoc_id:<?php echo $article->id; ?> }
        });
    });

    $("#add_event").on("click",function(e) {
        e.preventDefault();

        var Event =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended event'  margin-right:15px;'>"+
            "<h3>Nov dogodek</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='eventForm' enctype='multipart/form-data'>"+
                "<label>Ime dogodka<span class='required'>*</span></label><br>"+
                "<input type='text' required name='content[name]'><br>"+
                "<label>Opis<span class='required'>*</span></label><br>"+
                "<textarea required name='content[description]'></textarea><br>"+
                "<label>Začetek<span class='required'>*</span></label><br>"+
                "<input type='text' required name='content[start_date]' class='datepicker'><br>"+
                "<label>Konec</label><br>"+
                "<input type='text' name='content[end_date]' class='datepicker'><br>"+
                "<label>Slika</label><br>"+
                "<input type='file' name='content[file][]' value='' accept='image/*' /><hr/>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='event'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Event);
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: new Date()
        });
    });
    $("#add_multimedia").on("click",function(e) {
        e.preventDefault();

        var Multimedia =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended multimedia' style='display:inline-block; margin-right:15px;'>"+
            "<h3>Nova slika</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='multimediaForm' enctype='multipart/form-data'>"+
                "<label>Naslov<span class='required'>*</span></label><br>"+
                "<input required type='text' name='content[name]'><br>"+
                "<label>Kratek opis<span class='required'>*</span></label><br>"+
                "<textarea required name='content[description]'></textarea><br>"+
                "<label>Slika<span class='required'>*</span></label><br>"+
                "<input required type='file' name='content[file][]' accept='image/*'><hr>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='multimedia'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Multimedia);
    });
    $("#add_gallery").on("click",function(e) {
        e.preventDefault();

        var Gallery =
            "<li class='attachment event' style='padding-top:33px;'>"+
                "<div class='appended multimedia' style='display:inline-block; margin-right:15px;'>"+
                "<h3>Nova galerija</h3>"+
                "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='galleryForm' enctype='multipart/form-data'>"+
                    "<label>Naslov<span class='required'>*</span></label><br>"+
                    "<input required type='text' name='content[name]'><br>"+
                    "<label>Kratek opis<span class='required'>*</span></label><br>"+
                    "<textarea required name='content[description]'></textarea><br>"+
                    "<label>Izberite slike<span class='required'>*</span></label><br>"+
                    "<input required type='file' multiple name='content[file][]' accept='image/*'><hr>"+
                    "<input type='submit' class='buttons' value='Dodaj'>"+
                    "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                    "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                    "<input type='hidden' name='content[type]' value='gallery'>"+
                "</form>"+
                "</div>"+
            "</li>";

        $("#attachments_list").prepend(Gallery);
    });
    $("#add_location").on("click",function(e) {
        e.preventDefault();

        var Location =
            "<li class='attachment event' style='padding-top:33px;'>"+
            "<div class='appended locations' style='display:inline-block; margin-right:15px;'>"+
            "<h3>Nova lokacija</h3>"+
            "<form action='<?php echo base_url()."content/Update"; ?>' method='POST' id='locationsForm'>"+
                "<label>Mesto</label><br>"+
                "<input required type='text' name='content[city]'><br>"+
                "<label>Poštna številka</label><br>"+
                "<input size='6' required type='text' name='content[post_number]'><br>"+
                "<label>Ulica</label><br>"+
                "<input size='40' required type='text' name='content[street_village]'><br>"+
                "<label>Hišna številka</label><br>"+
                "<input size='6' type='text' name='content[house_number]'><br>"+
                "<label>Država</label><br>"+
                "<input required type='text' name='content[country]' value='Slovenija'><hr>"+
                "<input type='submit' class='buttons' value='Dodaj'>"+
                "<input type='button' class='buttons remove_appended' value='Odstrani'>"+
                "<input type='hidden' name='content[asoc_id]' value='<?php echo $article->id; ?>'>"+
                "<input type='hidden' name='content[type]' value='location'>"+
            "</form>"+
            "</div>"+
            "</li>";

        $("#attachments_list").prepend(Location);
    });
</script>
