<?php
include_once 'Conexao.class.php';
include_once 'Manager.class.php';

$manager = new Manager();

// Certifique-se de que ID está definido e não está vazio
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Inicialize o array de dados a serem atualizados
    $update_Prod = array(
        'nome_produto' => $_POST['nome_produto'],
        'descricao' => $_POST['descricao'],
        'preco' => $_POST['preco'],
        'tamanho' => $_POST['tamanho'],
        'cor' => $_POST['cor']
    );

    // Verifique se um arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // Diretório onde as imagens serão armazenadas
        $uploadDirectory = '../crud/backend/images/';

        // Gera um nome único para o arquivo de imagem
        $imageName = uniqid('image_') . '_' . basename($_FILES['imagem']['name']);

        // Caminho completo para salvar a imagem
        $uploadFilePath = $uploadDirectory . $imageName;

        // Move o arquivo de imagem para o diretório de upload
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFilePath)) {
            // Adicione o nome da imagem ao array de dados
            $update_Prod['imagem'] = $imageName;
        } else {
            // Se houver algum erro ao mover o arquivo, exiba uma mensagem de erro
            echo "Erro ao fazer upload da imagem.";
            exit;
        }
    }

    try {
        // Tente atualizar o produto
        $manager->updateProd("loja", $update_Prod, $id);
        echo "Produto atualizado com sucesso.";

        // Redirecione após a atualização
        header("Location: ../frontend/index.php?client_update");
        exit; // Adicione esta linha para evitar execução adicional após o redirecionamento
    } catch (PDOException $e) {
        // Em caso de erro, imprima a mensagem de erro
        echo "Erro ao atualizar o produto: " . $e->getMessage();
    }
} else {
    // Se não entrar no bloco anterior, significa que ID não está definido ou está vazio
    echo "ID não está definido ou está vazio.";
}
?>
