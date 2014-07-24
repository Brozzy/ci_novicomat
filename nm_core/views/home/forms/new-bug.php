<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Javite napako</h3>'; ?>

<p style="font-size:1.1em; background-position: left;" class="icon notification-icon">
    V primeru, da naletite na težavo ali napako nam prosim javite. Podrobno opišite napako in, če je mogoče zraven pripnite še zaslonske slike.
    <strong>Napako bomo popravili v najkrajšem možnem času.</strong>
</p>
<div>
    <form action="<?php echo base_url()."content/ReportBug"; ?>" id="bug-reporting-form" enctype="multipart/form-data" method="post">
        <label class="icon edit-icon" for="bug-description">Opis napake</label>
        <textarea style="width:100%; min-height:100px;" name="content[description]" id="bug-description"></textarea><br>

        <label class="icon image-icon" for="bug-images">Zaslonske slike</label>
        <input type="file" class="multifile" multiple accept="image/*" name="content[file][]" id="bug-images">

        <input type="hidden" name="content[name]" value="Bug report">
        <input type="hidden" name="content[type]" value="bug">
        <input type="hidden" name="content[tags]" value="bug, error, report">

        <div style="margin-top: 10px;">
            <input type="button" class="md-close icon cancel-icon" value="Prekliči">
            <input class="icon save-icon" type="submit" name="bug-post" value="Oddaj">
        </div>
    </form>
</div>