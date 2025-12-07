<?php
include_once 'Conexao.class.php';
include_once 'Manager.class.php';

$manager = new Manager();

// Certifique-se de que ID_Socio está definido e não está vazio
if(isset($_POST['id_socio']) && !empty($_POST['id_socio'])) {
    // Verifique se um arquivo de imagem foi enviado
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // Diretório onde as imagens serão armazenadas
        $uploadDirectory = '../crud/backend/images/';

        // Gera um nome único para o arquivo de imagem
        $imageName = uniqid('image_') . '_' . $_FILES['imagem']['name'];

        // Caminho completo para salvar a imagem
        $uploadFilePath = $uploadDirectory . $imageName;

        // Move o arquivo de imagem para o diretório de upload
        if(move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFilePath)) {
            // Atualiza o nome da imagem no banco de dados
            $update_Socio = array(
                'nome_completo' => $_POST['name'],
                'data_nascimento' => $_POST['birth'],
                'email' => $_POST['email'],
                'morada' => $_POST['morada'],
                'codigopostal' => $_POST['codigopostal'],
                'concelho' => $_POST['concelho'],
                'distrito' => $_POST['distrito'],

                'numero_telemovel' => $_POST['phone'],
                'sexualidade' => $_POST['gender'],
                'imagem' => $imageName
            );
            $id_socio = $_POST['id_socio'];

            try {
                // Tente atualizar o sócio
                $manager->updateSocio("socios", $update_Socio, $id_socio);
                echo "Sócio atualizado com sucesso.";

                // Mova a linha de header para cá, antes de qualquer saída
                header("Location: ../frontend/index.php?client_update");
                exit; // Adicione esta linha para evitar execução adicional após o redirecionamento
            } catch (PDOException $e) {
                // Em caso de erro, imprima a mensagem de erro
                echo "Erro ao atualizar o sócio: " . $e->getMessage();
            }
        } else {
            // Se houver algum erro ao mover o arquivo, exiba uma mensagem de erro
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        // Se não houver uma imagem enviada, atualize apenas os outros campos
        $update_Socio = array(
            'nome_completo' => $_POST['name'],
            'data_nascimento' => $_POST['birth'],
            'email' => $_POST['email'],
            'morada' => $_POST['morada'],
            'codigopostal' => $_POST['codigopostal'],
            'concelho' => $_POST['concelho'],
            'distrito' => $_POST['distrito'],

            'numero_telemovel' => $_POST['phone'],
            'sexualidade' => $_POST['gender']
        );
        $id_socio = $_POST['id_socio'];

        try {
            // Tente atualizar o sócio
            $manager->updateSocio("socios", $update_Socio, $id_socio);
            echo "Sócio atualizado com sucesso.";

            // Mova a linha de header para cá, antes de qualquer saída
            header("Location: atualizarsocios.php?client_update");
            exit; // Adicione esta linha para evitar execução adicional após o redirecionamento
        } catch (PDOException $e) {
            // Em caso de erro, imprima a mensagem de erro
            echo "Erro ao atualizar o sócio: " . $e->getMessage();
        }
    }
} else {
    // Se não entrar no bloco anterior, significa que ID_Socio não está definido ou está vazio
    echo "ID_Socio não está definido ou está vazio.";
}
?>
