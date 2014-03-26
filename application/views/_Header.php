<h1 style="text-align:left; display:table-cell; padding:2%;">
	<?php echo $User->name; ?>
</h1>
<?php if($User->level > 6) { ?>
<div style="text-align:right; display:table-cell; padding-right:4%;">
    <label for="ViewPort" style="margin-right:10px; color:#EEE;">Spremeni pogled</label>
    <select name="level" id='ViewPort'>
        <option value="7" selected>Administrator</option>
        <option value="6">Manager</option>
        <option value="5">Publisher</option>
        <option value="4">Editor</option>
        <option value="3">Author</option>
        <option value="2">Registered</option>
        <option value="1">Public</option>
    </select>
</div>
<?php } ?>