<ul>
<?php foreach($errors as $bug) { ?>
    <li>
        <?php echo $bug->description; ?>
        <?php foreach($bug->images as $image) { ?>
            <img src="<?php echo base_url().$image->medium; ?>" alt="bug screenshot">
        <?php } ?>
    </li>
<?php } ?>
</ul>