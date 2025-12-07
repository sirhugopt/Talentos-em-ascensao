
<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configurações do banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sql_hugo_igr05_p";

    // Estabelecendo a conexão com a base de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Processamento do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];

    // Preparando a instrução SQL para inserir os dados na tabela
    $sql = "INSERT INTO mensagens_contato (nome, email, titulo, mensagem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $titulo, $mensagem);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: contacto.php"); // Redireciona para contato.php
        exit(); // Encerra o script atual
    } else {
        echo "Erro ao inserir dados na tabela: " . $stmt->error;
    }
    // Fechando a conexão com o banco de dados
    $conn->close();
    
}
?>

