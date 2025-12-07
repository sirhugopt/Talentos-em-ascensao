<?php

$dsn = 'mysql:host=localhost;dbname=sql_hugo_igr05_p';
$username = 'root';
$senha = ''; // Corrigido o nome da variável

try {
    // Cria uma nova conexão PDO
    $pdo = new PDO($dsn, $username, $senha);

    // Define o modo de erro do PDO para Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário de login foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtém as credenciais do formulário
        $email = $_POST['email'];
        $senhaEncrip = $_POST['senha']; // Corrigido o nome da variável



        // Consulta para verificar as credenciais do usuário (usando placeholders)
        $query = "SELECT id_socio, email, senha FROM socios WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica as credenciais
        if ($user && password_verify($senhaEncrip, $user['senha'])) { 
            echo 'Login bem-sucedido!';
        } else {
            echo 'Credenciais inválidas. Tente novamente.';
        }
    }
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Talentos em Ascensão</title>
  <!-- Custom CSS File -->
  <link rel="stylesheet" href="login.css">
  <link rel="icon" href="dist/img/5.png">

</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <form class="form card" action="verificar.php" method="POST">
      <img src="rcjms.png" alt="Jogador" class="form-player">

        <header>Talentos em Ascensão</header>
        <div class="field">
          <label><span>Email: </span><input class="input" type="email" name="email" required></label>
        </div>
        <div class="field">
          <label><span>Palavra-Passe: </span><input class="input" type="password" name="senha" required></label>
        </div>
        <input type="submit" class="button" value="Entrar">
        <p>Não é sócio? <a href="sersocio.html">Registre-se</a></p>
      </form>
    </div>
  </div>
</body>
</html>
