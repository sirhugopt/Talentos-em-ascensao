<?php
include_once 'Conexao.class.php';
include_once 'Manager.class.php';

$manager = new Manager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se o formulário foi enviado, processar os dados aqui
    $imagem = $_FILES['imagem']['name'];
    $nome_completo = $_POST['nome_completo'];
    $NIF = $_POST['NIF'];
    $data_nascimento = $_POST['data_nascimento'];
    $morada = $_POST['morada'];
    $codigopostal = $_POST['codigopostal'];
    $concelho = $_POST['concelho'];
    $distrito = $_POST['distrito'];
    $email = $_POST['email'];
    $numero_telemovel = $_POST['numero_telemovel'];
    $sexualidade = $_POST['sexualidade'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Armazenar o hash da senha

    // Pasta onde a imagem será armazenada
    $uploadDir = 'images/socios/';

    // Certifique-se de que o diretório de upload existe
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadFile = $uploadDir . basename($imagem);

    // Verifica se o arquivo foi enviado corretamente
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {

        // Verifica se o arquivo foi enviado corretamente
        // Insira o sócio no banco de dados
        $manager->insertSocio("socios", [
            'imagem' => $uploadFile,
            'nome_completo' => $nome_completo,
            'NIF' => $NIF,
            'data_nascimento' => $data_nascimento,
            'morada' => $morada,
            'codigopostal' => $codigopostal,
            'concelho' => $concelho,       
            'distrito' => $distrito,       
            'email' => $email,
            'numero_telemovel' => $numero_telemovel,
            'sexualidade' => $sexualidade,
            'senha' => $senha // Armazenar o hash da senha
        ]);
        echo "Sócio registrado com sucesso!";
    } else {
        echo "Erro ao fazer upload do arquivo de imagem.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
    <title>Talentos em Ascensão</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="dist/img/5.png">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <?php include_once 'dependencias.php'; ?>
</head>
<style>
    body {
  overflow-x: hidden; /* Esconde o transbordamento horizontal */
  box-shadow: none;
}
</style>
<body>
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>Rua São Francisco Xavier, Alto do Forte, 2635-195 Rio de Mouro</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center py-3">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Segunda - Sexta : 09.00 - 20:00</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+351 967 845 634</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
        
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-0" href="https://www.instagram.com/talentosemascensao_/?next=%2F"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><img src="img/5.png" alt="Seu Logo"style="width: 80px; height: 80px;"></i>Talentos em Ascencão</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
  <div class="navbar-nav p-4 p-lg-0">
    <a href="index.php" class="nav-link">Início</a>
    <a href="about.html" class="nav-link">Sobre Nós</a>
    <a href="feature.html" class="nav-link">Instalações</a>
    <a href="sersocio.html" class="nav-link">Ser Sócio</a>
    <a href="loja.php" class="nav-link">Loja</a>
    <a href="contacto.php" class="nav-link">Contatos</a>
    <a href="Loginn.php" class="nav-link">LOGIN</a>
  </div>
</div>
            
           
            
    </nav>

    <div class="container mt-5">
    <h2 class="text-center">
        Registo de Sócio  <i class="fa fa-user-plus"></i>
    </h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="imagem">Imagem:</label>
            <input type="file" class="form-control" name="imagem" required>
        </div>

        <div class="mb-3">
            <label for="nome_completo">Nome Completo:</label>
            <input type="text" class="form-control" name="nome_completo" required>
        </div>

        <div class="mb-3">
            <label for="NIF">NIF:</label>
            <input type="text" class="form-control" name="NIF" required>
        </div>

        <div class="mb-3">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
        </div>

        <div class="mb-3">
            <label for="morada">Morada:</label>
            <input type="text" class="form-control" name="morada" required>
        </div>

        <div class="row mb-3">
        <div class="col-md-4">
    <label for="codigopostal">Código Postal:</label>
    <input type="text" class="form-control" name="codigopostal" title="Digite um código postal válido no formato XXXX-XXX" placeholder="XXXX-XXX" required>
</div>
            <div class="col-md-4">
                <label for="concelho">Concelho:</label>
                <input type="text" class="form-control" name="concelho" required>
            </div>
            <div class="col-md-4">
                <label for="distrito">Distrito:</label>
                <input type="text" class="form-control" name="distrito" required>
            </div>
        </div>

        

        <div class="mb-3">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required>
        </div>

        <div class="mb-3">
            <label for="numero_telemovel">Número de Telemóvel:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">+351</span>
                </div>
                <input type="tel" class="form-control" name="numero_telemovel" pattern="[0-9]{9}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="sexualidade">Género:</label>
            <select class="form-control" name="sexualidade" required>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" name="senha" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Sócio</button>
    </form>
</div>
<div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Adereço</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Rua São Francisco Xavier, Alto do Forte, 2635-195 Rio de Mouro</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+351 967 845 634</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>talentosemascensao@gmail.com</p>
                    <div class="d-flex pt-2">
                        
                    </div>
             
             
    <!-- Footer End -->

    <script>
    // Função para formatar o código postal
    function formatarCodigoPostal(input) {
        // Remove qualquer caractere que não seja número
        var valor = input.value.replace(/\D/g, '');
        
        // Adiciona o traço depois dos primeiros 4 dígitos
        if (valor.length > 4) {
            valor = valor.substring(0, 4) + '-' + valor.substring(4);
        }
        
        // Limita a quantidade de caracteres após o traço para 3
        if (valor.length > 8) {
            valor = valor.substring(0, 8);
        }
        
        // Atualiza o valor do campo
        input.value = valor;
    }
    
    // Adiciona um listener para o evento de entrada no campo do código postal
    document.getElementById('codigopostal').addEventListener('input', function() {
        formatarCodigoPostal(this);
    });
</script>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>