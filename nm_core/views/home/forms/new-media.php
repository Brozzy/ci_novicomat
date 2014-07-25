<?php if($js == '/true') echo '<h3 style="padding-bottom:15px;">Nov medij</h3>'; ?>

<p class="icon question-icon">
    V primeru, da želite članek objaviti na svoj medij - lahko s pomočjo tega obrazca dodate svoj medij.<br>
    Dodate lahko e-naslov na kategera vam bomo pošiljali vaše objavljene članke.
</p>

<form>
    <label for="new-media-email" class="icon email-icon">e-naslov</label>
    <input type="email" id="new-media-email" name="media[email]" size="40">

    <input type="button" value="Prekliči" class="md-close icon cancel-icon">
    <input type="submit" value="Dodaj" class="icon save-icon">
</form>