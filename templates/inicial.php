<?php
echo "Fazer logout: <a href='/dehbora/logout'>Clique aqui</a>";
echo "<h2>Está é a página Inicial (protegida).</h2><br /><br />";
include("templates/inc/header.php");
echo_pre($_SESSION);
echo_pre($user);