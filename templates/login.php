<?php
echo "<h2>Está é a página de login.</h2><br /><br />";
echo "Variáveis de sessão:<br />";
echo_pre($_SESSION);
echo "<a href='/dehbora/entrar'>Logar</a>";

$facebook = new Facebook(array(
  'appId'  => '419563918092035',
  'secret' => 'a03a80f9985a5d7bc9c38e2817f64aea',
));

// Get User ID
$fb = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($fb) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $fb = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($fb) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
$me = $facebook->api('/me');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($fb): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>Sessão PHP</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($fb): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $fb; ?>/picture">

      <h3>Seu objeto Usuário (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>Você não está conectado.</em></strong>
    <?php endif ?>

    <h3>Perfil Público de Rômulo</h3>
    <img src="https://graph.facebook.com/romulo1984/picture">
    <?php echo $me['name']; ?>
  </body>
</html>