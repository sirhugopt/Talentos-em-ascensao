<?php
session_start();

// Verifica se o usuário não está autenticado
if (!isset($_SESSION['nome_completo']) || empty($_SESSION['nome_completo'])) {
    header("Location: ../index.php");
    exit;
}

// Lógica de inatividade
$session_lifetime = 60 * 60; // em segundos
if (!isset($_SESSION['last_activity']) || (time() - $_SESSION['last_activity']) > $session_lifetime) {
    // A sessão expirou devido à inatividade
    session_unset();
    session_destroy();
    header('Location: ../index.php'); // Redireciona para a página de login
    exit;
}

// Atualiza o último horário de atividade a cada requisição
$_SESSION['last_activity'] = time();

// Verifica se o formulário de logout foi enviado
if (isset($_POST['logout'])) {
    // Realiza o logout
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atv_7</title>
</head>
<body>
    <!-- Seu conteúdo HTML aqui -->

    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
