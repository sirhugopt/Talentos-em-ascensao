<?php
// Conexão com a base de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sql_hugo_igr05_p";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para contar o número de sócios
$sql = "SELECT COUNT(*) AS total_socios FROM socios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir o número de sócios
    $row = $result->fetch_assoc();
    $total_socios = $row["total_socios"];
} else {
    $total_socios = 0;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];

    // Preparando a instrução SQL para inserir os dados na tabela
    $sql = "INSERT INTO mensagens_contato (nome, email, titulo, mensagem) VALUES ('$nome', '$email', '$titulo', '$mensagem')";

    if ($conn->query($sql) === TRUE) {
        echo "Dados inseridos com sucesso na tabela.";
    } else {
        echo "Erro ao inserir dados na tabela: " . $conn->error;
    }
    
    // Fechando a conexão com o banco de dados
    $conn->close();
}
// Fechar conexão
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

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

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="dist/img/5.png">

</head>
<style>
.blur {
  filter: blur(5px); /* ajuste o valor de blur para o efeito desejado */
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
     
            <h1 class="m-0 text-primary"><img src="img/5.png" alt="Seu Logo"style="width: 80px; height: 80px;"></i>Talentos em Ascensão</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Início</a>
                <a href="about.html" class="nav-item nav-link">Sobre Nós</a>
                <a href="feature.html" class="nav-item nav-link">Instalações</a>
                <a href="sersocio.html" class="nav-item nav-link">Ser Sócio</a>
                <a href="loja.php" class="nav-item nav-link">Loja</a>
                <a href="contacto.php" class="nav-item nav-link">Contatos</a>
                <a href="Loginn.php" class="nav-item nav-link">LOGIN</i></a>

            </div>
            

      

    </nav>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid header bg-primary p-0 mb-5">
        <div class="row g-0 align-items-center flex-column-reverse flex-lg-row">
            <div class="col-lg-6 p-5 wow fadeIn" data-wow-delay="0.1s">
                <h1 class="display-4 text-white mb-5">Juntos, elevamos talentos e construimos sonhos!</h1>
                <div class="row g-4">
                    <div class="col-sm-4">
                        <div class="border-start border-light ps-4">
                            <h2 class="text-white mb-1" data-toggle="counter-up">5</h2>
                            <p class="text-light mb-0">Titulos</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="border-start border-light ps-4">
                            <h2 class="text-white mb-1" data-toggle="counter-up">373</h2>
                            <p class="text-light mb-0">Atletas</p>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up"><?php echo $total_socios; ?></h2>
                            <p class="text-light mb-0">Sócios</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="owl-carousel header-carousel">
                    <div class="owl-carousel-item position-relative">
    <img class="img-fluid blur" src="img/3.jpg" alt="">
                        <div class="owl-carousel-text">
                            <h1 class="display-1 text-white mb-0">Amor à Camisola</h1>
                        </div>
                    </div>
                    <div class="owl-carousel-item position-relative">
                        <img class="img-fluid blur" src="img/1.jpg" alt="">
                        <div class="owl-carousel-text">
                            <h1 class="display-1 text-white mb-0">Paixão pelo Clube</h1>
                        </div>
                    </div>
                    <div class="owl-carousel-item position-relative">
                        <img class="img-fluid blur" src="img/2.jpg" alt="">
                        <div class="owl-carousel-text">
                            <h1 class="display-1 text-white mb-0">Gratos aos Adeptos</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column">
                        <img class="img-fluid rounded w-75 align-self-end" src="img/6.jpg" alt="">
                        <img class="img-fluid rounded w-50 bg-white pt-3 pe-3" src="img/7.jpg" alt="" style="margin-top: -25%;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="d-inline-block border rounded-pill py-1 px-4">Sobre Nós</p>
                    <h1 class="mb-4">O nosso compromisso com o futebol</h1>
                    <p>A cada remate, em cada golo, os Talentos em Ascensão destacam-se como um farol de dedicação ao futebol. Somos mais que um clube; somos uma familia unida pela paixão pelo futebol e pelo desejo inabalável de alcançar novos patamares de sucesso.</p>
                    <p class="mb-4">A nossa abordagem baseia-se na qualidade do cuidado com os nossos atletas, na orientação por treinadores experientes e no compromisso com o desenvolvimento contínuo.</p>
                    <div class="text-center">
                    <p><i class="far fa-check-circle text-primary me-3"></i>Paixão pela Excelência</p>
                    <p><i class="far fa-check-circle text-primary me-3"></i>Cuidado Médico Profissional</p>
                    <p><i class="far fa-check-circle text-primary me-3"></i>Inovação no Desporto</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="about.html">Ler Mais</a>
                     </div>

                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    


    <!-- Feature Start -->
    <div class="container-fluid bg-primary overflow-hidden my-5 px-lg-0">
        <div class="container feature px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="p-lg-5 ps-lg-0">
                        <p class="d-inline-block border rounded-pill text-light py-1 px-4">Novidades</p>
                        <h1 class="text-white mb-4">Porque escolher-nos</h1>
                        <p class="text-white mb-4 pb-2">Vem vestir a camisola dos Talentos em Ascensão e aprende a jogar futebol com as melhores condições desportivas e pedagógicas numa Escola de Futebol perto de ti.</p>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                    <i class="fa fa-user-tie" style="color: #007bff;"></i>                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Treinadores</p>
                                        <h5 class="text-white mb-0">Experientes</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                        <i class="fa fa-check text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Valores</p>
                                        <h5 class="text-white mb-0">Sociais e Humanos</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
<i style="color: #007bff;" class="fas fa-star"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Oportunidade</p>
                                        <h5 class="text-white mb-0">De Valorização</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                    <i class="fa fa-globe text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Atendimento</p>
                                        <h5 class="text-white mb-0">Online</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/4.jpg" style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


  

    <!-- Appointment Start -->
    <!-- Container principal -->
<div class="container-xxl py-5">
  <!-- Container interno -->
  <div class="container">
    <!-- Row com dois colunas -->
    <div class="row g-5">
      <!-- Coluna esquerda -->
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
        <!-- Conteúdo esquerdo -->
        <p class="d-inline-block border rounded-pill py-1 px-4">Apontamento</p>
                                      <p>Tem alguma questão? Contacte-nos</p>

        <div class="bg-light rounded p-5 mb-4">
          <div class="d-flex align-items-center">
            <div class="icon-circle bg-white">
              <i class="fa fa-phone-alt text-primary"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Ligue-nos agora</p>
              <h5 class="mb-0">+351 967 845 634</h5>
            </div>
          </div>
        </div>
        <div class="bg-light rounded p-5">
          <div class="d-flex align-items-center">
            <div class="icon-circle bg-white">
              <i class="fa fa-envelope-open text-primary"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Envie-nos agora</p>
              <h5 class="mb-0">talentosemascensao@gmail.com</h5>
            </div>
          </div>
        </div>
      </div>
      <!-- Coluna direita -->
     <!-- Coluna direita -->
<div class="col-lg-6">
  <!-- Espaçamento superior -->
  <div class="mb-5"></div>
  <!-- Formulário -->
  <form method="post" action="processar_formulario.php">
    <!-- Campo nome -->
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="nome" name="nome" placeholder="O seu nome">
      <label for="nome">Nome</label>
    </div>
    <!-- Campo email -->
    <div class="form-floating mb-3">
      <input type="email" class="form-control" id="email" name="email" placeholder="O seu email">
      <label for="email">Email</label>
    </div>
    <!-- Campo título -->
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo">
      <label for="titulo">Titulo</label>
    </div>
    <!-- Campo mensagem -->
    <div class="form-floating mb-3">
      <textarea class="form-control" placeholder="Deixe a sua mensagem" id="mensagem" name="mensagem" style="height: 100px"></textarea>
      <label for="mensagem">Mensagem</label>
    </div>
    <!-- Botão enviar -->
    <button class="btn btn-primary w-100 py-3" type="submit">Enviar mensagem</button>
  </form>
</div>
  </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appointment End -->





    <!-- Footer Start -->
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