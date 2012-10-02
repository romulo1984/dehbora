<!DOCTYPE html>
<html lang="en">
    <head>
        <?PHP for($i = 0; $i < sizeof($meta); $i++){ /* Informações de Metadados */ echo $meta[$i]; }?>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- JAVASCRIPT e CSS -->
        <?php
            //Inclui arquivos JAVASCRIPT através da função func_js();
            if(isset($js)){
                for($i = 0; $i < sizeof($js); $i++){
                    echo $js[$i];
                }
            }
            
            //Inclui arquivos CSS através da função func_css();
            if(isset($css)){
                for($i = 0; $i < sizeof($css); $i++){
                    echo $css[$i];
                }
            }
        ?>
    </head>
    <body>