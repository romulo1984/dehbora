<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <a class="brand" href="<?php echo URL_BASE; ?>/inicial">Dehbora</a>
        <div class="nav-collapse">
            <ul class="nav">
            <li class=""><a href="<?php echo URL_BASE; ?>/inicial"><i class="icon-home"></i> Home</a></li>
            <li class=""><a href="#"><i class="icon-question-sign"></i> Como funciona?</a></li>
            <li class=""><a href="#"><i class="icon-info-sign"></i> Sobre</a></li>
            </ul>
            <form class="navbar-form pull-right" method="POST" action="/dehbora/login">
              <input class="span2" type="text" name="email" placeholder="E-mail">
              <input class="span2" type="password" name="senha" placeholder="Senha">
              <button type="submit" class="btn">Entrar</button>
            </form>
        </div><!--/.nav-collapse -->
        </div>
    </div>
</div>