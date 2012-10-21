<?php
$css = func_css(
        array(
            URL_BASE . "/public/css/bootstrap.css",
            URL_BASE . "/public/css/bootstrap-responsive.css"
        )
);
$js = func_js(
        array(
            "http://code.jquery.com/jquery-latest.js",
            URL_BASE . "/public/js/bootstrap.js",
            URL_BASE . "/public/js/custom.js"
        )
);
$meta = func_meta("Dehbora | " . $dados_feed['titulo']);

include('templates/inc/header.php');
?>
<style type="text/css">
    body {
        margin: 0;
        padding: 0;
        overflow:hidden;
        height: 100%;
    }
    .shadow {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        -moz-box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        -webkit-box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
    }
    .cinza {
        background: #ccc;
    }
</style>
<div class="container">
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="<?php echo URL_BASE; ?>/">Dehbora</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class=""><a href="<?php echo URL_BASE; ?>/"><i class="icon-home"></i> Home</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-th-list"></i> Feeds <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#addFeed" data-toggle="modal"><i class="icon-plus"></i> Adicionar Feed</a></li>
                                <li><a href="#"><i class="icon-edit"></i> Gerenciar Feeds</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="#"><i class="icon-question-sign"></i> Como funciona?</a></li>
                        <li class=""><a href="#"><i class="icon-info-sign"></i> Sobre</a></li>
                    </ul>
                    <ul class="nav pull-right">
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $user['nome'] . " (" . $user['email'] . ")"; ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="icon-pencil"></i> Perfil</a></li>
                                <li><a href="#"><i class="icon-heart"></i> Amigos</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo URL_BASE; ?>/logout"><i class="icon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <div class="row" style="margin-top:46px;">
        <div class="span9">
            <?php
            $feed_permalink = base64_decode($dados_feed['feed_permalink']);
            echo "<small>";
            echo "<strong>Título:</strong> " . $dados_feed['titulo'] . "<br />";
            echo "<strong>Link original:</strong> <a href='" . $feed_permalink . "' target='_blank'>" . $feed_permalink . "</a><br />";
            echo "<strong>Data:</strong> " . $dados_feed['data_formatada'] . "<br /><br />";
            echo "</small>";
            echo "<div style='display:none;'>";
            echo "<input type='hidden' name='titulo' value='".$dados_feed['titulo']."'/>";
            echo "<input type='hidden' name='permalink' value='".$feed_permalink."'/>";
            echo "<input type='hidden' name='data' value='".$dados_feed['data']."'/>";
            echo "</div>";
            ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                var titulo = $("input[name=titulo]").attr("value");
                var permalink = $("input[name=permalink]").attr("value");
                var data = $("input[name=data]").attr("value");
                $("#carregando").css("display", "block");
                $('#avaliacao').load('<?php echo URL_BASE; ?>/templates/avaliacao.php', {dados: {titulo:titulo, permalink:permalink, data:data}, userid:<?php echo $user['id']; ?>}, function(){
                    $("#carregando").css("display", "none");
                });
            })
        </script>
        <div class="span3" id="avaliacao">
            <div id="carregando" style="display: none;position:absolute; margin-left: 140px; margin-top: 16px;; z-index: 9">
                <img src="<?php echo URL_BASE; ?>/public/img/loader.gif"/>
            </div>
        </div>
    </div>
</div>
<div class="shadow" style="width:100%; height: 10px; background: #0088cc;"></div>
<div>
    <IFRAME
        src="<?php echo $feed_permalink; ?>"
        frameborder="0"
        noresize="noresize"
        style="position:absolute;background:transparent;width:100%;height:100%;padding:0;z-index:-1;">
    </IFRAME>
</div>
</body>
</html>