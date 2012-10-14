<?php
include("../app/config.php");
include("../classes/DbConfig.php");
include("../classes/Connection.php");
include("../classes/Crud.php");

$noticia = new Crud();
$noticia->setTabela("noticias");

if(isset($_POST['dados']['permalink'])){
    $permalink = $_POST['dados']['permalink'];
}else{
    $permalink = $_GET['permalink'];
}
if(isset($_POST['userid'])){
    $iduser = $_POST['userid'];
}else{
    $iduser = $_GET['iduser'];
}

$result_noticia = $noticia->consultar(array("id"), "permalink = '".$permalink."'");

$n = $result_noticia->fetch(PDO::FETCH_ASSOC);

if($n == ""){
    $avaliado = 0;
}else{
    $avaliado = 1;
    $nota = new Crud();
    $nota->setTabela("notas");
    $result_nota = $nota->consultar(array("nota"), "id_user = ".$iduser." AND id_noticia = ".$n['id']);
    $no = $result_nota->fetch(PDO::FETCH_ASSOC);
}

if(isset($no)){
    if($no['nota'] == 1){
        $nota_dada = '<img src="'.URL_BASE.'/public/img/1-stars.png"/>';
    }elseif($no['nota'] == 2){
        $nota_dada = '<img src="'.URL_BASE.'/public/img/2-stars.png"/>';
    }elseif($no['nota'] == 3){
        $nota_dada = '<img src="'.URL_BASE.'/public/img/3-stars.png"/>';
    }elseif($no['nota'] == 4){
        $nota_dada = '<img src="'.URL_BASE.'/public/img/4-stars.png"/>';
    }elseif($no['nota'] == 5){
        $nota_dada = '<img src="'.URL_BASE.'/public/img/5-stars.png"/>';
    }
}else{
    $nota_dada = "Avaliar esta notícia";
}

?>
<script type="text/javascript">
    $(document).ready(function(){                
        $(".links-avaliar").click(function(e) {
            e.preventDefault();
            var nota = $(this).attr("nota");
            var titulo = $("input[name=titulo]").attr("value");
            var permalink = $("input[name=permalink]").attr("value");
            var data = $("input[name=data]").attr("value");
            
            $("#carregando").css("display", "block");
            $("#notas").css("display", "none");
            $("#avaliacao").load("<?php echo URL_BASE; ?>/noticia/avaliar/", {dados:{titulo:titulo,permalink:permalink,data:data},nota:nota}, function(response, status, xhr){
                if (status == "error") {
                    var msg = "Sorry but there was an error: ";
                    $("#erro").html(msg + xhr.status + " " + xhr.statusText);
                }
                $("#carregando").css("display", "none");
                $("#notas").css("display", "block");
            });
        });
    })
</script>
<div id="carregando" style="display: none;position:absolute; margin-left: 140px; margin-top: 16px;; z-index: 9">
    <img src="<?php echo URL_BASE; ?>/public/img/loader.gif"/>
</div>
<div id="erro"></div>
<div class="pull-right" id="notas">
    <div class="well">
        <div class="btn-group">
            <?php if($avaliado == 0){ ?>
                <button class="btn btn-large disabled" rel="tooltip" title="Para recomendar, você precisa avaliar primeiro">Recomendar</button>
            <?php }else { ?>
                <button class="btn btn-large">Recomendar</button>
            <?php } ?>
            <button class="btn btn-large dropdown-toggle" data-toggle="dropdown">
                <?php echo $nota_dada; ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="links-avaliar" href="#" rel="tooltip" nota="1" title="Péssimo"><i class="icon-star"></i></a></li>
                <li><a class="links-avaliar" href="#" rel="tooltip" nota="2" title="Ruim"><i class="icon-star"></i><i class="icon-star"></i></a></li>
                <li><a class="links-avaliar" href="#" rel="tooltip" nota="3" title="Regular"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                <li><a class="links-avaliar" href="#" rel="tooltip" nota="4" title="Bom"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
                <li><a class="links-avaliar" href="#" rel="tooltip" nota="5" title="Ótimo"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></a></li>
            </ul>
        </div>
    </div>
</div>