<h1 style='margin:0px; padding:3px;'><?php echo $user->name; ?></h1>

<nav class="head-navigation">
    <a href="<?php echo base_url()."Domov"; ?>" target="_self">Domov</a>
    <a href="<?php echo base_url()."content/Create"; ?>" target="_self">Dodaj nov članek</a>
    <a href="#">Urejanje člankov</a>
    <a href="<?php echo base_url()."auth/Logout"; ?>" target="_self" style="float: right;">Odjava</a>
</nav>




<!-- CHANGE VIEW (admin, user, publisher, editor etc..) [DEVELOPMENT ONLY]

<?php if($user->level > 1) { if(isset($_GET["view"])) $CurrentViewPort = $_GET["view"]; else $CurrentViewPort = 7; ?>
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
		document.location.href = "<?php echo current_url()."?view="; ?>"+$(this).val();
	});
</script>

<?php } else { ?>

<?php } ?>
-->