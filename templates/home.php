<?php
//Meta informações, CSS e Javascript
$css = func_css(
        array(
            URL_BASE . "/public/css/bootstrap.css",
            URL_BASE . "/public/css/bootstrap-responsive.css",
            URL_BASE . "/public/css/layout.css",
            URL_BASE . "/public/css/jquery.mCustomScrollbar.css",
            URL_BASE . "/public/js/introjs/introjs.css"
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
            URL_BASE . "/public/js/jquery.mCustomScrollbar.js",
            URL_BASE . "/public/js/introjs/intro.js"
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
    $(document).ready(function(){

        $('#bem-vindo').modal('show');

        /* Live Search para as Notícias */
        $('input#searchdom').quicksearch('div#alvosearch div.item-feed',
            {
                'delay': 300,
                'loader': 'span.input-loader',
                'noResults': 'Nenhum resultado'
            }
        );
        
        /* Live Search para os Feeds */
        $('input#searchrss').quicksearch('ul#alvosearchrss li.li-rss',
            {
                'delay': 300,
                'loader': 'span.input-loader-feeds',
                'noResults': 'Nenhum resultado'
            }
        );
        
        
            
        $(".box-scroll").mCustomScrollbar();
        
        //Carrega com Ajax as recomendações
        $("#load_recomendacoeso").css("display", "block");
        $("#recomendacoes").load("<?php echo URL_BASE; ?>/recomendacoes", function(response, status, xhr){
                if (status == "error") {
                    var msg = "Um erro ocorreu ao carregar a página: ";
                    $("#recomendacoes").html(msg + xhr.status + " " + xhr.statusText);
                }
                $("#load_recomendacoes").css("display", "none");
            });
    });
</script>
<div class="row">
    <div class="span4" data-step="3" data-intro="
                                                Aqui você visualiza as últimas entradas do Feed<br />
                                                que foi selecionado a esquerda. Ao clicar em uma<br />
                                                das notícias abaixo você será redirecionado para<br />
                                                a página com a notícia integral, podendo avaliá-la."
                                        data-position="left">
        <!--
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <img src="<?php echo URL_BASE; ?>/public/img/alerts-2.png"/>
        </div>
        -->
        
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
                    <?php
                        $nome_form = rand();
                        $permalink = base64_encode($item->get_permalink());
                    ?>
                    <div class="item-feed">
                        <h4><a href="javascript:void(0);" onclick="document['<?php echo $nome_form; ?>'].submit();"><?php echo $item->get_title(); ?></a></h4>
                        <small>Postado dia <?php echo $item->get_date('d/m/Y') . ' às ' . $item->get_date('H:i'); ?></small>
                        <div class="descricao-feed"><?php echo $item->get_description(); ?></div>
                        <hr>
                    </div>
                    <form style="display:none;" method="post" name="<?php echo $nome_form; ?>" action="<?php echo URL_BASE . "/noticia/" . urlSEO($item->get_title()); ?>">
                        <input type="hidden" name="feed_permalink" value="<?php echo $permalink; ?>"/>
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
    <div class="span4" data-step="4" data-intro="Após avaliar algumas notícias você já poderá ver aqui várias recomendações. Divirta-se!" data-position="left">
        <!--
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <img src="<?php echo URL_BASE; ?>/public/img/alerts-3.png"/>
        </div>
        -->
        <div class="well">
            <i class="icon-tag"></i> <span class="label label-success">Notícias Recomendadas</span>
            <form style="margin-top: 20px;">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-filter"></i></span>
                    <input type="text" value="" placeholder="Filtrar recomendações" name="searchrecomendacoes" id="searchrecomendacoes"/>
                    <span class="input-loader-recomendacoes" style="margin-left: 10px; width: 24px; display: none;">
                        <img style="margin-bottom: 5px;" src="<?php echo URL_BASE; ?>/public/img/loader-mini.gif"/>
                    </span>
                </div>
            </form>
            <span class="divider"></span>
            <div id="load_recomendacoes" style="display: block; position:absolute; z-index: 9; text-align: center;margin-left: 80px; margin-top: 16px;">
                <span>Aguarde...</span><br />
                <span>Gerando recomendações.</span><br />
                <span><img src="<?php echo URL_BASE; ?>/public/img/loader.gif"/></span>
            </div>
            <div style="overflow-y:auto; height: 500px;" id="recomendacoes" class="box-scroll-recomendacoes">
            </div>
        </div>
    </div>
</div>
<?php
include('templates/inc/footer.php');