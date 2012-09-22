<?php
include "inc/header.php";
echo "Hello World - I'm Rômulo.";

//Teste da classe de conexão usando PDO
$teste = new Crud();
$teste->setTabela('teste');
$q = $teste->consultar(array('*'))->fetchAll(PDO::FETCH_ASSOC);

$categoria = new Crud();
$categoria->setTabela('categoria');
$j = $categoria->consultar(array('nome'))->fetchAll(PDO::FETCH_ASSOC);

echo_pre($q);

echo_pre($j);