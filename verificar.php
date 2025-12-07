<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sql_hugo_igr05_p";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com a base de dados: ". $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $senha = $conn->real_escape_string($_POST['senha']);

    $query = "SELECT * FROM socios WHERE email =?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['start'] = time();
            $_SESSION['nome_completo'] = $dados['nome_completo'];
    
            if (strtolower($dados['nome_completo']) == 'administrator') { 
                header("Location: gestao.php");
            } else {
                header("Location: index1.php");
            }
            exit();
        } else {
            echo "Login inválido. Tente novamente.";
            header("Refresh: 1; URL=Loginn.php");
            exit();
        }
    } else {
        echo "Login inválido. Tente novamente.";
        header("Refresh: 1; URL=Loginn.php");
        exit();
    }
}
?>