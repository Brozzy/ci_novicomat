<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Nova slika</h3>'; ?>

<form action="<?php echo base_url()."content/Update".$js; ?>" method="post" enctype="multipart/form-data" <?php if($js == '/true') echo 'id="contentForm"'; ?>>
    <label class="icon edit-icon">Naslov</label>
    <input type="text" name="content[name]" placeholder="Naslov" value="<?php echo (isset($content->name) ? $content->name : ''); ?>">

    <label class="icon edit-icon">Opis</label>
    <textarea placeholder="Kratek opis slik..." style="width:70%; height:70px;" name="content[description]"><?php echo (isset($content->description) ? $content->description : ''); ?></textarea>

    <label class="icon tags-icon">Ključne besede</label>
    <input type="text" class="tags" name="content[tags]" value="<?php echo (isset($content->tags) ? implode(', ',$content->tags) : ''); ?>" size="40">

    <label for="upload-local" class="icon folder-icon">Naloži slike iz računalnika</label>
    <input type="file" name="content[file][]" id="upload-image-local" multiple accept="image/*"><br>

    <label for="upload-image-url" class="icon link-icon">URL povezave do slik (več povezav hkrati ločite med seboj z vejico).</label>
    <textarea type="url" name="content[from_internet]" id="upload-image-url" style="width:100%; min-height: 75px;"></textarea><br>

    <input type="button" value="Prekliči" class="icon cancel-icon md-close">
    <input type="button" class="md-trigger icon images-icon" data-modal="new-gallery-image" title="Izberite sliko iz galerije" value="Izberi sliko iz galerije">
    <input type="submit" class="icon upload-icon modal-submit-button" id="upload-image-button" value="Shrani">

    <input type="hidden" name="content[id]" value="<?php echo (isset($content->id) ? $content->id : '0'); ?>">
    <input type="hidden" name="content[url]" value="<?php echo (isset($content->url) ? $content->url : ''); ?>">
    <input type="hidden" name="content[type]" value="image">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>