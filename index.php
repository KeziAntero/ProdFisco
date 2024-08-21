<?php
session_start();

$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
  include 'Prod.php';
  $prod = new Prod();
  $user = $prod->loginUsers($_POST['email'], $_POST['pwd']);
  if (!empty($user)) {
    $_SESSION['user'] = $user[0]['first_name'];
    $_SESSION['userid'] = $user[0]['id'];
    $_SESSION['email'] = $user[0]['email'];
    $_SESSION['matricula'] = $user[0]['matricula'];
    header("Location:prod_list.php");
  } else {
    $loginError = "E-mail ou senha inválidos!";
  }
}
?>
<title>Sistema de produtividade</title>

<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css'>
<link rel="stylesheet" href="./css/style.css">
<script src="js/prod.js"></script>

<div id="login" class="row">

  <div class="login-form">
    <img id="logo" src="./img/logo-prod.png" alt="Logo" style="width: 100px;">
    <h2>ProdFisco</h2>
    <form method="post" action="">
      <div class="form-group">
        <?php if ($loginError) { ?>
          <div class="alert alert-warning"><?php echo $loginError; ?></div>
        <?php } ?>
      </div>
      <div class="form-group">
        <input name="email" id="email" type="email" class="form-control" placeholder="e-mail" required style="border: 1px solid rgba(0, 0, 0, 0.20);">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="pwd" placeholder="Senha" required style="border: 1px solid rgba(0, 0, 0, 0.20);">
      </div><br>
      <div class="form-group">
        <button type="submit" name="login" class="btn btn-success">Entrar</button>
      </div>

    </form>
    <br>

  </div>
</div>
</div>