<p class="icon question-icon">
    Z dodajanjem novega urednika omogočite drugemu uporabniku, da lahko pregleduje in ureja vaš članek.
    Če želite dodati novega uporabnika, vpišite njegov e-naslov ali uporabniško ime.
</p>

<form action="<?php echo base_url()."content/AddEditor"; ?>" method="post">
    <label for="add-user-username" class="icon user-icon">Uporabniško ime</label>
    <input type="text" id="add-user-username" class="username-autocomplete" name="user[username]">

    <label style="opacity: 0.7;">- ali -</label>

    <label for="add-user-email" class="icon email-icon">E-naslov</label>
    <input type="email" name="user[email]" class="email-autocomplete" size="50">


    <label for="add-user-access-level" class="icon eye-icon">Pravice urednika</label>
    <select name="user[access_level]" id="add-user-access-level" style="width:200px;">
        <option value="1">samo ogled članka</option>
        <option value="2">urejanje članka</option>
        <option value="3">popoln nadzor</option>
    </select>

    <br>

    <div style="display: table;">
        <input type="checkbox" style="display: table-cell;" required="required" id="add-user-agreement" name="user[agreement]">
        <label for="add-user-agreement" style="display: table-cell; font-size:1em; padding-left: 10px; ">Potrjujem, da omogočam dodanem uredniku, da lahko pregleduje in ureja trenutni članek glede na dodeljene pravice. <span class="required">*</span> </label>
    </div>

    <br>

    <?php foreach($hidden as $input) { ?>
        <input type="hidden" name="<?php echo 'content['.$input['name'].']'; ?>" value="<?php echo $input['value']; ?>">
    <?php } ?>

    <input type="button" value="Prekliči" class="md-close icon cancel-icon">
    <input type="submit" value="Dodaj" class="icon save-icon">
</form>




