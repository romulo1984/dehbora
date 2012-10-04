<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dehbora | <?php echo $dados_feed['titulo']; ?></title>
    </head>
<body style="margin: 0; padding: 0; overflow:hidden; height: 100%;">
    <div>
        <?php
        echo_pre($dados_feed['data_formatada']);
        ?>
    </div>
<iframe src="<?php echo $dados_feed['feed_permalink']; ?>"
        id="mainframe" frameborder="0"
        noresize="noresize"
        style="position:absolute;background:transparent;width:100%;height:100%;top:133px;padding:0;z-index:1;"
/>
</body>
</html>