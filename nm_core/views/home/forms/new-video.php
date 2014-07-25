<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Nov video posnetek</h3>'; ?>

<form action="<?php echo base_url()."content/Update".$js; ?>" method="post" enctype="multipart/form-data" <?php if($js == '/true') echo 'id="contentForm"'; ?>>
    <label class="icon edit-icon" for="video-title">Naslov</label>
    <input type="text" name="content[name]" id="video-title" size="30" value="<?php echo (isset($content->name) ? $content->name : ''); ?>">

    <label class="icon edit-icon" for="video-description">Opis</label>
    <textarea name="content[description]" id="video-description" style="width:70%; height:70px;"><?php echo (isset($content->description) ? $content->description : ''); ?></textarea>

    <label class="icon tags-icon" for="video-tags">Ključne besede</label>
    <input type="text" class="tags" name="content[tags]" size="50" id="video-tags" value="<?php echo (isset($content->tags) ? implode(', ',$content->tags) : ''); ?>">

    <label for="upload-video-local" class="icon folder-icon">Naloži video iz računalnika (format mora biti .mp4 in ne sme presegati velikosti več kot 55Mb).</label>
    <input type="file" accept="video/mp4" name="content[file][]" id="upload-video-local" multiple><br>

    <label for="upload-video-url" class="icon youtube-icon">YouTube povezava do video posnetka (več povezav hkrati ločite med seboj z vejico).</label>
    <textarea name="content[from_internet]" id="upload-video-url" style="width:100%; min-height: 75px;"></textarea><br>

    <input type="button" value="Prekliči" class="icon cancel-icon md-close">
    <input type="submit" class="icon upload-icon" value="Shrani">

    <input type="hidden" name="content[id]" value="<?php echo (isset($content->id) ? $content->id : '0'); ?>">
    <input type="hidden" name="content[url]" value="<?php echo (isset($content->url) ? $content->url : ''); ?>">
    <input type="hidden" name="content[type]" value="video">

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>
</form>