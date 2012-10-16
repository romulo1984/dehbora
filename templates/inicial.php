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
    include('/templates/inc/nav_inicial.php');
?>
<div class="container content-top">
    <div class="row">
        <div class="span12">
            <div class="alert alert-info">
                <h3>Descubra uma nova forma de receber recomendações. Descubra Dehbora!</h3>
            </div>
        </div>
        <div class="span8">
            <iframe
                src="http://player.vimeo.com/video/8812686?title=0&amp;byline=0&amp;portrait=0&amp;color=ff9933"
                width="100%"
                height="440"
                frameborder="0"
                webkitAllowFullScreen mozallowfullscreen allowFullScreen>
            </iframe>
        </div>
        <div class="span4">
            <?php if(isset($_SESSION['slim.flash']['errors'])) { ?>
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h4>Seu cadastro não foi realizado!</h4>
                    <?php foreach($_SESSION['slim.flash']['errors'] as $er) echo "* ".$er."<br />"; ?>
                </div>
            <?php } ?>
            <div class="well">
                <form method="POST" action="<?php echo URL_BASE; ?>/newuser">
                    <h3>Cadastre-se!</h3><br />
                    <label>Nome completo:</label>
                    <input type="text" name="nome"/>
                    <label>E-mail:</label>
                    <input type="text" name="email"/>
                    <label>Senha:</label>
                    <input type="password" name="senha"/>
                    <label>Confirme a senha:</label>
                    <input type="password" name="confirma_senha"/><br /><br />
                    <button type="submit" class="btn">Cadastrar</button>
                </form>
            </div>
        </div>
        <div class="span4">
            <h3>A opinião de seus amigos é importante?</h3>
            <p>Dehbora reúne as preferências não só de seus amigos, mas de toda a base de usuários.
            Desta forma vai te entregar conteúdo relevante sempre.
            </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h3>Dehbora aprende com você!</h3>
            <p>O Algoritimo de recomendação cruza informações baseadas em suas avaliações. Mas se não gostou de nossas recomendações, Dehbora aprende com você. Basta adicionar palavras na "blacklist".</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h3>Heading</h3>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
    </div>
</div>
<?php
    //include(URL_BASE.'/templates/inc/footer.php');