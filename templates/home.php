<?php
    //Meta informações, CSS e Javascript
    $css = func_css(
        array(
            URL_BASE."/public/css/bootstrap.css",
            URL_BASE."/public/css/bootstrap-responsive.css",
            URL_BASE."/public/css/layout.css"
        )
    );
    $js = func_js(
            array(
                "http://code.jquery.com/jquery-latest.js",
                URL_BASE."/public/js/bootstrap.js",
                URL_BASE."/public/js/custom.js"
            )
    );
    $meta = func_meta("Dehbora");

    include('/templates/inc/header.php');
    include('/templates/inc/nav_home.php');
    include('/templates/inc/sidebar.php');
?>
<div class="row">
    <div class="span4">
        <div class="well">
            <i class="icon-tag"></i> Feeds de <span class="label label-info"><?php if(isset($nome)) echo $nome; else echo $nome_feed_inicial; ?></span>
            <hr>
            <span class="divider"></span>
            <div style="overflow-y:scroll;overflow-x: hidden;height: 500px;">
            <?php foreach ($rss as $item):?>
                <?php $nome_form = rand(); ?>
                <div class="item-feed">
                        <h4><a href="javascript:void(0);" onclick="document['<?php echo $nome_form; ?>'].submit();"><?php echo $item->get_title(); ?></a></h4>
                    <small>Postado dia <?php echo $item->get_date('d/m/Y').' às '.$item->get_date('H:i'); ?></small>
                    <div class="descricao-feed"><?php echo $item->get_description(); ?></div>
                </div><hr>
                <form style="display:none;" method="post" name="<?php echo $nome_form; ?>" action="<?php echo URL_BASE."/noticia/".urlSEO($item->get_title()); ?>">
                    <input type="hidden" name="feed_permalink" value="<?php echo $item->get_permalink(); ?>"/>
                    <input type="hidden" name="titulo" value="<?php echo $item->get_title(); ?>"/>
                    <input type="hidden" name="titulo_seo" value="<?php echo urlSEO($item->get_title()); ?>"/>
                    <input type="hidden" name="descricao" value="<?php echo $item->get_description(); ?>"/>
                    <input type="hidden" name="data" value="<?php echo $item->get_date(); ?>"/>
                    <input type="hidden" name="data_formatada" value="<?php echo $item->get_date('d/m/Y').' às '.$item->get_date('H:i'); ?>"/>
                </form>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="well">
            <i class="icon-tag"></i> <span class="label label-success">Notícias Recomendadas</span>
            <hr>
            <span class="divider"></span>
            <div style="overflow-y:scroll;overflow-x: hidden;height: 500px;">
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
    include('/templates/inc/footer.php');