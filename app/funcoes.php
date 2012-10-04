<?php

//FUNÇÕES COMUNS DO SISTEMA
//Adiciona um arquivo CSS
function func_css(array $url) {
    $return = array();
    foreach ($url as $u) {
        $return[] = "<link rel='stylesheet' href='" . $u . "'>" . PHP_EOL;
    }
    return $return;
}

//Adiciona um arquivo javascript
function func_js(array $url) {
    $return = array();
    foreach ($url as $u) {
        $return[] = "<script src='" . $u . "' type='text/javascript'></script>" . PHP_EOL;
    }
    return $return;
}

//Adiciona informações de metadados
function func_meta($title = "Dehbora", $charset = "utf-8", $description = "", $author = "") {
    $return = array();
    $return[] = "<meta charset='" . $charset . "' />" . PHP_EOL;
    $return[] = "<title>" . $title . "</title>" . PHP_EOL;
    $return[] = "<meta name='description' content='" . $description . "' />" . PHP_EOL;
    $return[] = "<meta name='author' charset='" . $author . "' />" . PHP_EOL;

    return $return;
}

//Alternativa para a função file_get_contents()
function my_file_get_contents($site_url) {
    $ch = curl_init();
    $timeout = 10;
    curl_setopt($ch, CURLOPT_URL, $site_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

//Print_r com taga PRE
function echo_pre($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

//Ecurtador de caracteres
function shorten($string, $length) {
// Por padrão, uma elipse será acrescentada ao final do texto.
    $suffix = '&hellip;';

// Converter pontuação 'inteligente' para a pontuação 'burro', tira as tags HTML,
// e converter todas as guias e de quebra de linha personagens para espaços simples.
    $short_desc = trim(str_replace(array("\r", "\n", "\t"), ' ', strip_tags($string)));

// Corte a corda no comprimento desejado, e tira os espaços exteriores
// desde o início e fim.
    $desc = trim(substr($short_desc, 0, $length));

// Descubra o que o último caractere exibido é na cadeia encurtada
    $lastchar = substr($desc, -1, 1);

// Se o último caractere é um período, um ponto de exclamação ou uma pergunta
// marca, limpar o texto anexado.
    if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?')
        $suffix = '';

// Anexar o texto.
    $desc .= $suffix;

// Enviar a nova descrição de volta para a página.
    return $desc;
}

//INÍCIO DE CONVERÇÃO DE STRING PARA URL AMIGÁVEL
function urlSEO($string) {
    $table = array(
        'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z',
        'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
    );

// Traduz os caracteres em $string, baseado no vetor $table 
    $string = strtr($string, $table);

// converte para minúsculo 
    $string = strtolower($string);

// remove caracteres indesejáveis (que não estão no padrão) 
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

// Remove múltiplas ocorrências de hífens ou espaços 
    $string = preg_replace("/[\s-]+/", " ", $string);

// Transforma espaços e underscores em hífens 
    $string = preg_replace("/[\s_]/", "-", $string);

// retorna a string 
    return $string;
}