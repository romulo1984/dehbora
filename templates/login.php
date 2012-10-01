<?php
echo "<h2>Está é a página de login.</h2><br /><br />";
echo "Variáveis de sessão:<br />";
echo_pre($_SESSION);
echo "<a href='/dehbora/entrar'>Logar</a>";
?>
<form method="POST" action="/dehbora/entrar">
    E-mail: <input type="text" name="email"/><br />
    Senha: <input type="password" name="senha"/><br />
    <input type="submit" value="Entrar"/>
</form>