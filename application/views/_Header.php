<h1 style="text-align:left; display:table-cell; padding:2%;">
	<?php echo $User->name; ?>
</h1>
<?php if($User->level > 6) { if(isset($_GET["view"])) $CurrentViewPort = $_GET["view"]; else $CurrentViewPort = 7; ?>
<div style="text-align:right; display:table-cell; padding-right:4%;">
    <label for="ViewPort" style="margin-right:10px; color:#EEE;">Spremeni pogled</label>
    <select name="level" id='ViewPort'>
        <option value="7" <?php if($CurrentViewPort == 7) echo "selected"; ?>>Administrator</option>
        <option value="6" <?php if($CurrentViewPort == 6) echo "selected"; ?>>Manager</option>
        <option value="5" <?php if($CurrentViewPort == 5) echo "selected"; ?>>Publisher</option>
        <option value="4" <?php if($CurrentViewPort == 4) echo "selected"; ?>>Editor</option>
        <option value="3" <?php if($CurrentViewPort == 3) echo "selected"; ?>>Author</option>
        <option value="2" <?php if($CurrentViewPort == 2) echo "selected"; ?>>Registered</option>
        <option value="1" <?php if($CurrentViewPort == 1) echo "selected"; ?>>Public</option>
    </select>
</div>

<script type="text/javascript">
	$("#ViewPort").on("change",function() {
		console.log($(this).val());
		document.location.href = "<?php echo current_url()."?view="; ?>"+$(this).val();
	});
</script>

<?php } else { ?>

<?php } ?>