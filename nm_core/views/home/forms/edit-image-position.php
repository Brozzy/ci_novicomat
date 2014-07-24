
<h4 class="icon notification-icon" style="font-size: 1.2em; background-position: left 2px; opacity: 0.8;">Trenutni položaj slike je <?php echo ($content->position == 'bottom' ? 'na spodnji strani članka' : 'na desni strani članka'); ?></h4>

<p>
    Če želite spremeniti položaj slike, izberite željeni kvadrat na prikazanem članku spodaj.<br>
    Izbirate lahko med <strong>desno</strong> ali <strong>spodnjo stran</strong> članka.
</p>

<p>
    Položaj slike se uporablja za izbiro kje želite sliko prikazati pri prikazu članka.
    V primeru, da je na spodnji strani pomeni, da bo slika del galerije slik, če pa je prikazana desno pa bo slika najverjetneje prikazana ob besedilu članka (vsaka stran izdelana na novicomat sistemu ima načeloma svojo grafično podobo).
</p>

<div class="attachment-position-wrapper" style="width:100%;">
    <table class="icon newspaper-icon attachment-position" style="margin:0px auto; width:300px; height:300px; background-size: 300px 300px; background-position: center;">
        <tr>
            <td>&nbsp;</td>
            <td style="width:30%;" class="area right <?php if($content->position == "right") echo "selected"; ?>">
                <input type="hidden" name='id' value="<?php echo $content->id; ?>">
                <input type="hidden" name='asoc_id' value="<?php echo $content->id; ?>">
            </td>
        </tr>
        <tr style="height:25%;">
            <td colspan="2" class="area bottom <?php if($content->position == "bottom") echo "selected"; ?>">
                <input type="hidden" name='id' value="<?php echo $content->id; ?>">
                <input type="hidden" name='asoc_id' value="<?php echo $content->id; ?>">
            </td>
        </tr>
    </table>
</div>

<input type="button" class="md-close icon check-icon" value="Zapri">
