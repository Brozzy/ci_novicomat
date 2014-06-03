<!--TODO LEPSE SPISATI -->
<div>
    REGISTRACIJA USPESNA
</div>
<!--TODO ni 10s delaya ampak bolj 2s, povecanje ne pomaga -->
<script type="text/javascript">
    $(function(){
window.setInterval(function(){goHome(),10000});
});

function goHome()
{
window.location = "<?php echo base_url()."Prijava"; ?>";
}
</script>