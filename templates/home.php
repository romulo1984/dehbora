<?php
//Meta informações, CSS e Javascript
$css = func_css(
        array(
            URL_BASE . "/public/css/bootstrap.css",
            URL_BASE . "/public/css/bootstrap-responsive.css",
            URL_BASE . "/public/css/layout.css",
            URL_BASE . "/public/css/jquery.mCustomScrollbar.css"
        )
);
$js = func_js(
        array(
            "http://code.jquery.com/jquery-latest.js",
            URL_BASE . "/public/js/bootstrap.js",
            URL_BASE . "/public/js/jquery.quicksearch.js",
            URL_BASE . "/public/js/custom.js",
            URL_BASE . "/public/js/jquery-ui.min.js",
            URL_BASE . "/public/js/jquery.mousewheel.min.js",
            URL_BASE . "/public/js/jquery.mCustomScrollbar.js"
        )
);
$meta = func_meta("Dehbora");

include('templates/inc/header.php');
include('templates/inc/nav_home.php');
include('templates/inc/sidebar.php');

$useragent = $_SERVER['HTTP_USER_AGENT'];
 
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent)) {
    
}
?>
<script type="text/javascript">
    $(function(){
        /* Live Search para os Feeds */
        $('input#searchdom').quicksearch('div#alvosearch div.item-feed',
            {
                'delay': 300,
                'loader': 'span.input-loader',
                'noResults': 'Nenhum resultado'
            }
        );
            
        $('input#searchrss').quicksearch('ul#alvosearchrss li.li-rss',
            {
                'delay': 300,
                'loader': 'span.input-loader-feeds',
                'noResults': 'Nenhum resultado'
            }
        );
            
        $(".box-scroll").mCustomScrollbar();
    });
</script>
<div class="row">
    <div class="span4">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <img src="<?php echo URL_BASE; ?>/public/img/alerts-2.png"/>
        </div>
        <div class="well">
            <i class="icon-tag"></i> Feeds de <span class="label label-info"><?php if (isset($nome)) echo $nome; else echo $nome_feed_inicial; ?></span>
            <form style="margin-top: 20px;">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-filter"></i></span>
                    <input type="text" value="" name="searchdom" id="searchdom" placeholder="Filtrar noticias" autofocus/>
                    <span class="input-loader" style="margin-left: 10px; width: 24px; display: none;">
                        <img style="margin-bottom: 5px;" src="<?php echo URL_BASE; ?>/public/img/loader-mini.gif"/>
                    </span>
                </div>
            </form>
            <span class="divider"></span>
            <div style="overflow-y:auto; height: 500px;" id="alvosearch" class="box-scroll">
                <?php foreach ($rss as $item): ?>
                    <?php $nome_form = rand(); ?>
                    <div class="item-feed">
                        <h4><a href="javascript:void(0);" onclick="document['<?php echo $nome_form; ?>'].submit();"><?php echo $item->get_title(); ?></a></h4>
                        <small>Postado dia <?php echo $item->get_date('d/m/Y') . ' às ' . $item->get_date('H:i'); ?></small>
                        <div class="descricao-feed"><?php echo $item->get_description(); ?></div>
                        <hr>
                    </div>
                    <form style="display:none;" method="post" name="<?php echo $nome_form; ?>" action="<?php echo URL_BASE . "/noticia/" . urlSEO($item->get_title()); ?>">
                        <input type="hidden" name="feed_permalink" value="<?php echo $item->get_permalink(); ?>"/>
                        <input type="hidden" name="titulo" value="<?php echo $item->get_title(); ?>"/>
                        <input type="hidden" name="titulo_seo" value="<?php echo urlSEO($item->get_title()); ?>"/>
                        <input type="hidden" name="descricao" value="<?php echo strip_tags($item->get_description()); ?>"/>
                        <input type="hidden" name="data" value="<?php echo $item->get_date(); ?>"/>
                        <input type="hidden" name="data_formatada" value="<?php echo $item->get_date('d/m/Y') . ' às ' . $item->get_date('H:i'); ?>"/>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <img src="<?php echo URL_BASE; ?>/public/img/alerts-3.png"/>
        </div>
        <div class="well" style="background-image: url('../public/img/bg-logo.png');background-position: top right;background-repeat: no-repeat">
            <i class="icon-tag"></i> <span class="label label-success">Notícias Recomendadas</span>
            <form style="margin-top: 20px;">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-filter"></i></span>
                    <input type="text" value="" placeholder="Filtrar recomendações"/>
                    <span class="input-loader-recomendacoes" style="margin-left: 10px; width: 24px; display: none;">
                        <img style="margin-bottom: 5px;" src="<?php echo URL_BASE; ?>/public/img/loader-mini.gif"/>
                    </span>
                </div>
            </form>
            <span class="divider"></span>
            <div style="overflow-y:auto; height: 500px;" class="box-scroll">
                <h4><a href="#">Juiz da PB manda PF prender diretor do Google no Brasil</a></h4>
                <small class="cinza">Postado 2012/08/02 20h47</small>
                <p>São Paulo - O juiz da propaganda eleitoral de mídia e internet de Campina Grande (PB), Ruy Jander, decretou nesta sexta a prisão...</p>
                <div>
                    <div class="pull-left">
                        <span class="label">tecnologia</span>
                        <span class="label">internet</span>
                    </div>
                </div><br /><br />
                <div class="btn-group">
                    <button class="btn btn-mini">Recomendar</button>
                    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
                        Avaliar
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                    </ul>
                </div>
                <br /><hr>
                <h4><a href="#">Juiz da PB manda PF prender diretor do Google no Brasil</a></h4>
                <small class="cinza">Postado 2012/08/02 20h47</small>
                <p>São Paulo - O juiz da propaganda eleitoral de mídia e internet de Campina Grande (PB), Ruy Jander, decretou nesta sexta a prisão...</p>
                <div>
                    <div class="pull-left">
                        <span class="label">tecnologia</span>
                        <span class="label">internet</span>
                    </div>
                </div><br /><br />
                <div class="btn-group">
                    <button class="btn btn-mini">Recomendar</button>
                    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
                        Avaliar
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                    </ul>
                </div>
                <br /><hr>
                <h4><a href="#">Twitter envia mensagens de manifestante de Wall Street a juiz</a></h4>
                <small class="cinza">Postado 2012/08/02 20h47</small>
                <p>Nova York - O Twitter entregou mensagens de um manifestante do movimento Ocupe Wall Street a um juiz criminal de Nova York nesta sexta-feira depois...</p>
                <div>
                    <div class="pull-left">
                        <span class="label">redes sociais</span>
                        <span class="label">bolsa de valores</span>
                        <span class="label">internet</span>
                        <span class="label">tecnologia</span>
                    </div>
                </div><br /><br />
                <div class="btn-group">
                    <button class="btn btn-mini">Recomendar</button>
                    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
                        Avaliar
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                        <li><a href="#"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                    </ul>
                </div>
                <br /><hr>
                <div class="pagination">
                    <ul>
                        <li><a href="#">Anterior</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">Próximo</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('templates/inc/footer.php');