<div id="addFeed" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Adicionar Feed</h3>
  </div>
  <div class="modal-body">
    <p>Vários sites de notícias e blogs disponibilizam links de feeds.<br />
       Geralmente estes links são disponibilizados em um ícone parecido com este <img src="<?php echo URL_BASE;?>/public/img/rss.png"/>
        Copie este link e cole no campo abaixo.
        <a href="http://pt.wikipedia.org/wiki/Feed" target="_blank">Saiba mais sobre feeds</a></p>
    <form method="POST" action="<?php echo URL_BASE;?>/feeds/add">
        <br /><label><small>Nome:</small></label>
        <input type="text" name="nome" placeholder="ex: Terra Notícias"><br />
        <label><small>Url do feed:</small></label>
        <input type="text" name="url" placeholder="ex: http://rss.terra.com.br/rss.xml">
        <label class="checkbox">
            <input type="checkbox" name="publico" value="1"> Público
            <a href="#" rel="tooltip" title="Deixando esta opção marcada, seu Feed poderá ser compartilhado com outros usuários. Caso queira que o feed inserido seja privado, deixe esta opção desmarcada.">?</a>
        </label>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Fechar</a>
    <button class="btn btn-primary" type="submit">Adicionar Feed</button>
    </form>
  </div>
</div>

<div id="bem-vindo" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><div class="logo"></div>Bem-vindo ao Dehbora!</h3>
  </div>
  <div class="modal-body">
    <p>Nós iremos guiá-lo em um tour explicativo, para que você possa aproveitar ao máximo a experiência de usar o Dehbora.<br />
       Clique em Avançar para percorrer pelas etapas do Tour, e Voltar para retornar ao passo anterior. <img src="<?php echo URL_BASE;?>/public/img/rss.png"/>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Fechar</a>
    <a data-dismiss="modal" class="btn btn-large btn-success" href="javascript:void(0);" onclick="javascript:introJs().start();">Iniciar Tour</a>
    </form>
  </div>
</div>

<div class="container content-top">
            <div class="row">
                <div class="span12">
                    <div class="row">
                        <div class="span4" data-step="1" data-intro="Esta área contem todos os seus feeds cadastrados." data-position="right">
                            <!--
                            <div class="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <img src="<?php echo URL_BASE; ?>/public/img/alerts-1.png"/>
                            </div>
                            -->
                            <div class="well">
                                <i class="icon-tag"></i> Feeds Cadastrados
                                <form style="margin-top: 20px;">
                                        <div class="input-prepend">
                                            <span class="add-on"><i class="icon-filter"></i></span>
                                            <input type="text" value="" name="searchrss" id="searchrss" placeholder="Filtrar feeds"/>
                                            <span class="input-loader-feeds" style="margin-left: 10px; width: 24px; display: none;">
                                                <img style="margin-bottom: 5px;" src="<?php echo URL_BASE; ?>/public/img/loader-mini.gif"/>
                                            </span>
                                        </div>
                                    </form>
                                <div style="overflow-y:auto; height: 200px;" class="box-scroll">
                                <ul class="nav nav-list" id="alvosearchrss" >
                                    <?php
                                        $lista_feeds = new Crud();
                                        $lista_feeds->setTabela('feeds');
                                        
                                        $l_f = $lista_feeds->consultar(
                                                array('id', 'nome', 'url', 'publico', 'id_categoria'),
                                                'id_user ='.$user['id'],
                                                'created DESC'
                                             )->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($l_f as $l){
                                            echo '<li class="li-rss ';
                                            if(isset($id_feed_atual) && $id_feed_atual == $l['id']){
                                                echo "active";
                                            }
                                            echo '"><a href="'.URL_BASE.'/feeds/'.$l['id'].'">'.$l['nome'].'</a></li>';
                                        }
                                        
                                        $nome_feed_inicial = $l_f[0]['nome'];
                                    ?>
                                </ul>
                                </div>
                                <ul class="nav nav-list">
                                    <li class="divider"></li>
                                    <li><a href="#addFeed" style="color: green !important;" data-toggle="modal" data-step="2" data-intro="Clicando neste botão você adiciona novos feeds." data-position="right"><i class="icon-plus"></i> Adicionar Feed</a></li>
                                    <li><a href="#" style="color: green !important;"><i class="icon-edit"></i> Gerenciar Feeds</a></li>
                                </ul>
                            </div>
                             <div class="well img-margin">
                                <img src="https://graph.facebook.com/romulo1984/picture" alt="">
                                <img src="https://graph.facebook.com/sandrofsantos/picture" alt="">
                                <img src="https://graph.facebook.com/MonicaG.ventorim/picture" alt="">
                                <img src="https://graph.facebook.com/fbguilherme/picture" alt="">
                                <img src="https://graph.facebook.com/malcteria1/picture" alt="">
                                <img src="https://graph.facebook.com/igorantcaetano/picture" alt="">
                                <img src="https://graph.facebook.com/raphael.amorim/picture" alt="">
                            </div>
                            
                        </div>
                        
                        <?php if(isset($_SESSION['slim.flash']['errors'])) { ?>
                        <div class="span8">
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <h4>Atenção!</h4>
                                <?php echo $_SESSION['slim.flash']['errors']; ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if(isset($_SESSION['slim.flash']['sucesso'])) { ?>
                        <div class="span8">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <h4>Sucesso!</h4>
                                <?php echo $_SESSION['slim.flash']['sucesso']; ?>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <?php if(preg_match('|MSIE ([0-9].[0-9]{1,2})|',$_SERVER['HTTP_USER_AGENT'])) { ?>
                        <div class="span8">
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <h4>Usuário de Internet Explorer detectado!</h4>
                                Tudo bem, não é nenhum pecado, mas para tirar total proveito do Dehbora, experimente utilizar um navegador mais moderno, como o Chrome, Firefox ou Opera.
                            </div>
                        </div>
                        <?php } ?>