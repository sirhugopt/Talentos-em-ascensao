<html>
<meta charset = "UTF-8">

<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sql_hugo_igr05_p";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<p/>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS ".$dbname;
if ($conn->query($sql) == TRUE) {
    echo "Base de dados criada com sucesso";
} else {
    echo "Erro a criar a base de dados: " . $conn->error;
}

echo "<p/>";

mysqli_select_db($conn,$dbname);

// Cria Tabela socios
$cria = "CREATE TABLE IF NOT EXISTS `socios` (
    `id_socio` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `imagem` VARCHAR(255) NOT NULL,
    `nome_completo` VARCHAR(100) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `morada` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `numero_telemovel` VARCHAR(15) NOT NULL,
    `sexualidade` ENUM('masculino', 'feminino') NOT NULL
) ENGINE = InnoDB;";

if ($conn->query($cria) == TRUE) {
    echo "Tabela socios criada com sucesso <p />";
} else {
    echo "Erro: Não foi possível criar a tabela socios " . $conn->error."<p />";
}
mysqli_close($conn);
?>
</body>
</html>
