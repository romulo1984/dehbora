<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <a class="brand" href="<?php echo URL_BASE; ?>/"><div class="logo"></div></a>
        <div style="margin-top: 25px;" class="nav-collapse">
            <ul class="nav">
            <li class=""><a href="<?php echo URL_BASE; ?>/"><i class="icon-home"></i> Home</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-th-list"></i> Feeds <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#addFeed" data-toggle="modal"><i class="icon-plus"></i> Adicionar Feed</a></li>
                    <li><a href="#"><i class="icon-edit"></i> Gerenciar Feeds</a></li>
                </ul>
            </li>
            <li class=""><a href="#bem-vindo" data-toggle="modal"><i class="icon-question-sign"></i> Como funciona?</a></li>
            <li class=""><a href="#"><i class="icon-info-sign"></i> Sobre</a></li>
            </ul>
            <ul class="nav pull-right">
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $user['nome']." (".$user['email'].")"; ?><b class="caret"></b></a>
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