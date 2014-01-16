<form method="get" action="">
    <input type="text" name="phrase" value="<?=exists($tplVars,'phrase','');?>" placeholder="Find programme" /> 
    <input type="submit" value="search" />
</form>
<script type="text/javascript">
    var timeout = null;
    $('input[name="phrase"]').keyup(function(){
        clearTimeout(timeout);
        var el = $(this);
        timeout = setTimeout(function(){
            $.get(location.href, { phrase: el.val() },function(resp){
                $('#results-container').html(resp);
            },'html');
        },1000);
    });
</script>

<div id="results-container">
    <?php include 'sresults.tpl.php'; ?>
</div>

