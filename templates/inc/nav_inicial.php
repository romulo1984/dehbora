<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
            <a class="brand" href="<?php echo URL_BASE; ?>/inicial"><div class="logo"></div></a>
        <div style="margin-top: 25px;" class="nav-collapse">
            <ul class="nav">
            <li class=""><a href="<?php echo URL_BASE; ?>/inicial"><i class="icon-home"></i> Home</a></li>
            <li class=""><a href="#"><i class="icon-question-sign"></i> Como funciona?</a></li>
            <li class=""><a href="#"><i class="icon-info-sign"></i> Sobre</a></li>
            </ul>
            <form class="navbar-form pull-right" method="POST" action="<?php echo URL_BASE; ?>/login">
              <input class="span2" type="text" name="email" placeholder="E-mail">
              <input class="span2" type="password" name="senha" placeholder="Senha">
              <button type="submit" class="btn">Entrar</button><br />
            <?php if(isset($_SESSION['slim.flash']['erro-login'])) { ?>
                <span class="pull-right" style="color: red;"><small><?php echo $_SESSION['slim.flash']['erro-login']; ?></small></span>
            <?php } ?>
            </form>
        </div><!--/.nav-collapse -->
        </div>
    </div>
</div>