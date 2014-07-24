<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Nov glasbeni posnetek</h3>'; ?>

<form action="<?php echo base_url()."content/Update".$js; ?>" method="post" style="padding: 15px;" enctype="multipart/form-data" class="upload-form" id="new-audio-form">
    <label class="icon edit-icon">Naslov</label>
    <input type="text" name="content[name]" value="<?php echo (isset($content->name) ? $content->name : ''); ?>">

    <label class="icon edit-icon">Opis</label>
    <textarea style="width:70%; height:70px;" name="content[description]"><?php echo (isset($content->description) ? $content->description : ''); ?></textarea>

    <label class="icon tags-icon" for="video-tags">Ključne besede</label>
    <input type="text" class="tags" name="content[tags]" size="50" id="video-tags" value="<?php echo (isset($content->tags) ? implode(', ',$content->tags) : ''); ?>">

    <label for="upload-local" class="icon folder-icon">Naloži posnetke iz računalnika (format mora biti .mp3 in ne sme presegati velikosti več kot 55Mb.).</label>
    <input type="file" accept="audio/mp3" name="content[file][]" multiple>

    <br>

    <input type="button" value="Prekliči" class="icon cancel-icon md-close">
    <input type="submit" class="icon upload-icon" value="Shrani">
    <input type="hidden" name="content[type]" value="audio">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>