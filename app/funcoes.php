<?php
//FUNÇÕES COMUNS DO SISTEMA

//Adiciona um arquivo CSS
function func_css(array $url){
    $return = array();
    foreach($url as $u){
        $return[] = "<link rel='stylesheet' href='".$u."'>".PHP_EOL;
    }
    return $return;
}

//Adiciona um arquivo javascript
function func_js(array $url){
    $return = array();
    foreach($url as $u){
        $return[] = "<script src='".$u."' type='text/javascript'></script>".PHP_EOL;
    }
    return $return;
}

//Adiciona informações de metadados
function func_meta($title = "Dehbora", $charset = "utf-8", $description = "", $author = ""){
    $return = array();
    $return[] = "<meta charset='".$charset."' />".PHP_EOL;
    $return[] = "<title>".$title."</title>".PHP_EOL;
    $return[] = "<meta name='description' content='".$description."' />".PHP_EOL;
    $return[] = "<meta name='author' charset='".$author."' />".PHP_EOL;
    
    return $return;
}

//Alternativa para a função file_get_contents()
function my_file_get_contents( $site_url ){
        $ch = curl_init();
        $timeout = 10;
        curl_setopt ($ch, CURLOPT_URL, $site_url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
}

//Print_r com taga PRE
function echo_pre($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}
?>
