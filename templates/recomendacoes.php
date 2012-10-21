<script type="text/javascript">
    $(document).ready(function(){
        $(".box-scroll-recomendacoes").mCustomScrollbar();
        
        /* Live Search para as Recomendações */
        $('input#searchrecomendacoes').quicksearch('div#recomendacoes div.item-feed',
            {
                'delay': 300,
                'loader': 'span.input-loader-recomendacoes',
                'noResults': 'Nenhum resultado'
            }
        );
     });
</script>       
<?php foreach ($dados as $d): ?>
    <?php
    $nome_form_r = rand();
    $permalink = base64_encode($d['permalink']);
    ?>
    <div class="item-feed">
        <h4><a href="javascript:void(0);" onclick="document['<?php echo $nome_form_r; ?>'].submit();"><?php echo $d['titulo']; ?></a></h4>
        <small>Postado dia <?php echo $d['pubDate']; ?></small>
        <hr>
    </div>
    <form style="display:none;" method="post" name="<?php echo $nome_form_r; ?>" action="<?php echo URL_BASE . "/noticia/" . urlSEO($d['titulo']); ?>">
        <input type="hidden" name="feed_permalink" value="<?php echo $permalink; ?>"/>
        <input type="hidden" name="titulo" value="<?php echo $d['titulo']; ?>"/>
        <input type="hidden" name="titulo_seo" value="<?php echo urlSEO($d['titulo']); ?>"/>
        <input type="hidden" name="data" value="<?php echo $d['pubDate']; ?>"/>
        <input type="hidden" name="data_formatada" value="<?php echo $d['pubDate']; ?>"/>
    </form>
<?php endforeach; ?>