<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Talentos em Ascensão | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="icon" href="dist/img/5.png">
      <link rel="stylesheet" href="cs.css">
</head>
<style>
.responsive-image {
  width: 100%;
  height: auto;
}
/* Para telas maiores */
@media (min-width: 1200px) {
 .responsive-image {
    width: 50%; /* ou qualquer outro valor que você prefira */
    height: auto;
  }
}

/* Para telas menores */
@media (max-width: 768px) {
 .responsive-image {
    width: 100%; /* ou qualquer outro valor que você prefira */
    height: auto;
  }
}
    .card {
      background-color: #007bff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 400px;
      position: relative;
    }

    .symbol {
      position: absolute;
      top: 10px;
      left: 10px;
      width: 50px;
      height: 50px;
    }

    .symbol img {
      width: 100%;
      height: 100%;
    }

    .card-header {
      background-color: #0056b3;
      color: #fff;
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #fff;
    }

    .card-body {
      padding: 20px;
      color: #333;
    }

    .card-body img {
      max-width: 50%;
      height: auto;
      border-radius: 50%;
    }

    .text-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 0 0 12px 12px;
    }

    .card-body p {
      margin: 5px 0;
    }

    .container {
      position: relative;
      display: inline-block;
    }

    .infoo-box {
      position: absolute;
      text-align: center;
      /* Centraliza o texto horizontalmente */
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    #originalImage {
      display: block;
    }

    #infoBoxCampo1 {
      top: 30px;
      left: 10px;
    }

    #infoBoxCampo2 {
      top: 80px;
      left: 10px;
    }
    .member-tab,
    .slb-profile-item {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
    }
    .title {
        font-size: 24px; /* Tamanho da fonte ajustável conforme necessário */
    }
    #originalImage {
        width: 100vw; /* 100% da largura da viewport */
        height: auto; /* Mantém a proporção da imagem */
        display: block; /* Garante que a imagem seja exibida como um bloco */
        margin: 0 auto; /* Centraliza a imagem horizontalmente */
    }
    .btn {
      background-color: blue;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    
    .containe {
        width: 300px; /* largura fixa para cada contêiner */
        margin-bottom: 10px; /* espaço entre os contêineres */
    }

    .btn {
        display: block; /* torna os botões blocos */
        width: 100%; /* preenche todo o espaço disponível */
        text-align: center; /* centraliza o texto dentro dos botões */
        margin-top: 5px; /* espaço acima do botão */
    }
    #originalImage {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto;
}
.button {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
 .brand-image {
  width: 45px; /* or height: 30px; */
}

  </style>

<?php
  session_start();

  // Supondo que você já tenha uma conexão ao banco de dados (substitua os valores conforme sua configuração)
  $host = "localhost";
  $usuario = "root";
  $senha = "";
  $banco = "sql_hugo_igr05_p";


  $conn = new mysqli($host, $usuario, $senha, $banco);

  // Verifica se a conexão foi estabelecida com sucesso
  if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
  }

  // Supondo que o nome do sócio está armazenado na variável de sessão 'nome_completo' após o login
  $nomeSocio = $_SESSION['nome_completo'];

  // Consulta para obter os dados do sócio (substitua 'socios' pelo nome correto da sua tabela)
  $sql = "SELECT * FROM socios WHERE nome_completo = ?";
  $stmt = $conn->prepare($sql);

  $stmt->bind_param('s', $nomeSocio);

  $stmt->execute();
  $result = $stmt->get_result();

  // Obtém os dados do sócio
  $dadosSocio = $result->fetch_assoc();

  if (!isset($_SESSION['nome_completo'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: ../crud/Frontend/index.php");
    exit();
  }

  // Verifica se o usuário é um administrador (você deve ter essa informação no seu sistema)

  if ($dadosSocio) {
    // Calcula a idade com base na data de nascimento
    $dataNascimento = new DateTime($dadosSocio['data_nascimento']);
    $hoje = new DateTime();
    $idade = $dataNascimento->diff($hoje)->y;

    // Determina a categoria do sócio
    $categoria = '';
    if ($idade >= 0 && $idade <= 13) {
      $categoria = 'Sócio Infantil';
    } elseif ($idade >= 14 && $idade <= 17) {
      $categoria = 'Sócio Juvenil';
    } else {
      $categoria = 'Sócio Efetivo';
    }
  }
  $id_socio = $dadosSocio['id_socio'];

  // Defina a chave 'id_socio' na sessão
 $imagemPath = 'images/socios/';

// Verifica se o nome do sócio está armazenado na variável de sessão 'nome_completo'
$nomeSocio = $_SESSION['nome_completo'];

// Busca a imagem do sócio com base no nome do sócio
if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
  $imageName = basename($_FILES["new_image"]["name"]);
  $uploadDirectory = '../crud/backend/images/';
  $newImagePath = $uploadDirectory. $imageName;

  if (move_uploaded_file($_FILES['new_image']['tmp_name'], $newImagePath)) {
    $manager->updateImage("socios", $socioId, $newImagePath);

    $oldImagePath = $uploadDirectory. $socioInfo[0]['imagem'];
    if (file_exists($oldImagePath)) {
      unlink($oldImagePath);
    }
  } else {
    echo "Erro: Falha ao enviar a nova imagem.";
    exit;
  }
}
function obterValorPago() {
  // implement the logic to retrieve the payment value
  // for example, you could query a database or use a payment gateway API
  $valor_pago = 100.00; // example value
  return $valor_pago;
}
$invoiceNumber = 1; // ou use uma variável que incremente a cada nova invoice
$orderId = uniqid(); // gera um ID único
$dueDate = new DateTime(); // current date and time          
          
$valor_pago = obterValorPago();

// Processar o pagamento
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Verificar se o ID do sócio e o valor pago foram obtidos automaticamente
  if (!empty($dadosSocio) &&!empty($valor_pago)) {
    // Atualizar o status do sócio para 'pago' e definir a data do último pagamento como a data atual
    $sql_update = "UPDATE pagamento_quotas SET status_quotas = 'pago', data_pagamento = CURRENT_DATE WHERE id_socio = $id_socio";
    if ($conn->query($sql_update) === TRUE) {
      echo "Pagamento registrado com sucesso.";

      // Verificar se as quotas estão atrasadas para o próximo mês
      $mes_atual = date('m');
      $ano_atual = date('Y');

      // Obter o mês e o ano do último pagamento
      $sql_last_payment_date = "SELECT MONTH(data_pagamento) AS mes, YEAR(data_pagamento) AS ano FROM pagamento_quotas WHERE id_socio = $id_socio";
      $result_last_payment_date = $conn->query($sql_last_payment_date);
    }
  }
}

// Verifica se o socio é novo e não tem nenhum registro de pagamento
$sql_check_new_socio = "SELECT COUNT(*) AS num_pagamentos
                        FROM pagamento_quotas
                        WHERE id_socio = ?";
$stmt_check_new_socio = $conn->prepare($sql_check_new_socio);
$stmt_check_new_socio->bind_param("i", $id_socio);
$stmt_check_new_socio->execute();
$result_check_new_socio = $stmt_check_new_socio->get_result();
$row_check_new_socio = $result_check_new_socio->fetch_assoc();
$num_pagamentos = $row_check_new_socio['num_pagamentos'];


  ?>
  <style>nav.main-header {
  margin: 0;
  padding: 0;
  width: 100%;
}

nav.main-header ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

nav.main-header .nav-link {
  padding: 0;
  margin: 0;
}

/* Adicione essas regras para garantir que todos os elementos tenham margens e padding removidos */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  background-color: #00008B; /* Cor desejada */
}
/* Define o estilo do body */

</style>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center v">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
<div class="wrapper">

  <!-- Preloader -->
  

  <!-- Navbar -->
  nav class="main-header navbar navbar-expand navbar-light" style="background-color: #00008B;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li c<nav class="main-header navbar navbar-expand navbar-light" style="background-color: #00008B;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" style="color: #FFFFFF;" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a href="index.php" class="nav-link" style="color: #FFFFFF;">Início</a>      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      
      

    </ul>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color: #00008B;">
    <a href="index.php" class="brand-link"style="background-color: #00008B;">
      <img src="dist/img/5.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
<span class="sideba-text-sm" style="color: #fff;">Talentos em Ascensão</span>    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
        <div class="image">
        <a href="profile.php">

<img src="<?php echo $dadosSocio['imagem'];?>" class="img-circle elevation-2" alt="Imagem do Sócio">       </div>
<span class="nav-profile-name sidebar-text-sm  text-white"><?php echo $nomeSocio;?></span>             
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          
          <div class="input-group-append">
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
  <a href="./index1.php" class="nav-link">
    <p class="sidebar-text-sm"style="color: #fff;">Início</p>
  </a>
</li>
              </li>
              <li class="nav-item">
  <a href="profile.php" class="nav-link">
    <p class="sidebar-text-sm"style="color: #fff;">Perfil de Sócio</p>
  </a>
</li>

<li class="nav-item">
  <a href="invoice.php" class="nav-link">
    <p class="sidebar-text-sm"style="color: #fff;">Pagamento de Quotas</p>
  </a>
</li>

<li class="nav-item">
  <a href="logout.php" class="nav-link">
    <p class="sidebar-text-sm"style="color: #fff;">Terminar Sessão</p>
  </a>
</li>

<?php if (isset($_SESSION["nome_completo"]) && $_SESSION["nome_completo"] == "administrator"): ?>
  <li class="nav-item">
  <a href="gestao.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <i class="" style="color: #007bff;"></i>
    <p class="sidebar-text-sm" style="color: #daa520;">Painel de Administração</p>
  </a>
</li>
  <li class="nav-item">
  <a href="adicionar_produto.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <p class="sidebar-text-sm" style="color: #daa520;">Adicionar Produtos</p>
  </a>
</li>

<li class="nav-item">
  <a href="atualizarsocios.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <p class="sidebar-text-sm" style="color: #daa520;">Lista de Sócios</p>
  </a>
</li>

<li class="nav-item">
  <a href="listacontactos.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <p class="sidebar-text-sm" style="color: #daa520;">Lista de Contactos</p>
  </a>
</li>

<li class="nav-item">
  <a href="listaquotas.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <i class="" style="color: #007bff;"></i>
    <p class="sidebar-text-sm" style="color: #daa520;">Lista de Quotas Pagas</p>
  </a>
</li>
<li class="nav-item">
  <a href="ListaProdutos.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <p class="sidebar-text-sm" style="color: #daa520;">Lista de Produtos</p>
  </a>
</li>

<?php endif; ?>

              </li>
          </li>
                            
          <li class="nav-item">
              <p>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buttons</p>
                </a>
              </li>
              <li class="nav-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sliders</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <p>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <p>
              </p>
            </a>
          </li>
          <li class="nav-item">
              <p>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                </a>
              </li>
              <li class="nav-item">
                </a>
              </li>
              <li class="nav-item">
                </a>
              </li>
            </ul>
            
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"style="background: linear-gradient(to bottom,#00008B, #4169E1);">
    <!-- Content Header (Page header) -->
    <h1 style='color: #FFFFFF;'>Pagamento de Quotas</h1>            <br>

<div class="container-fluid" >
  <div class="row mb-2">
    <div class="col-sm-6">

    </div>
  <?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sql_hugo_igr05_p";

// Conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
die("Erro de conexão: ". $conn->connect_error);
}
if (!isset($_SESSION['nome_completo']) || $_SESSION['nome_completo'] == 'administrator') {
  // Se não estiver logado ou for o administrador, redireciona para a página de login
  header("Location:Loginn.php");
  exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Obtém os dados do formulário
$id_socio = $_POST["id_socio"];
$valor_pago = $_POST["valor_pago"];
$data_pagamento = $_POST["data_pagamento"]?? null; // Trata como opcional

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Obtém os dados do formulário
$id_socio = $_POST["id_socio"];
$valor_pago = $_POST["valor_pago"];
$data_pagamento = $_POST["data_pagamento"]?? null; // Trata como opcional

if ($data_pagamento) {
  $data_atual = date("Y-m-d");

  // Calcula a data do próximo pagamento
  $data_pagamento = new DateTime($data_pagamento);
  $proximo_pagamento = clone $data_pagamento;
  $proximo_pagamento->add(new DateInterval('P1M')); // Adiciona 1 mês
  $data_proximo_pagamento = $proximo_pagamento->format('Y-m-d');

  //...
} else {
  // Trata o caso em que o campo data_pagamento está vazio
}


  $data_atual = date("Y-m-d");

  // Calcula a data do próximo pagamento
  $data_pagamento = new DateTime($data_pagamento);
  $proximo_pagamento = clone $data_pagamento;
  $proximo_pagamento->add(new DateInterval('P1M')); // Adiciona 1 mês
  $data_proximo_pagamento = $proximo_pagamento->format('Y-m-d');

  // Validação dos dados (pode ser adicionada conforme necessário)

  // Verifica se o utilizador já pagou este mês
  $sql_check_payment = "SELECT COUNT(*) AS status_quotas FROM pagamento_quotas WHERE id_socio =? AND MONTH(data_pagamento) = MONTH(NOW()) AND YEAR(data_pagamento) = YEAR(NOW())";
  $stmt_check_payment = $conn->prepare($sql_check_payment);
  $stmt_check_payment->bind_param("i", $id_socio);
  $stmt_check_payment->execute();
  $result_check_payment = $stmt_check_payment->get_result();
  $row_check_payment = $result_check_payment->fetch_assoc();
  $pagamentos_feitos = $row_check_payment['status_quotas'];

  if ($pagamentos_feitos > 0) {
    echo "<span style='color: #FFFFFF;'>Você já pagou este mês. O próximo pagamento só poderá ser feito no próximo mês.</span>";        } else {
      // Consulta SQL para registrar o pagamento
      $sql = "INSERT INTO pagamento_quotas (id_socio, valor_pago, data_pagamento, data_proximo_pagamento, status_quotas) VALUES (?,?,?,?, 'Pago')";
      
      // Prepara e executa a consulta
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("idss", $id_socio, $valor_pago, $data_atual, $data_proximo_pagamento);
      $stmt->execute();

      // Verifica se o pagamento foi registrado com sucesso
      if ($stmt->affected_rows > 1) {
        echo '<div style="text-align: center; color: #FFFFFF;"><h2>Pagamento registrado com sucesso!</h2></div>';
        header('Location: index1.php');
        exit;
      } else {
        echo '<div style="text-align: center; color: #FFFFFF;"><h2>Pagamento feito com sucesso.</h2></div>';
      }

      // Fecha a consulta
      $stmt->close();
  }
  // Fecha a consulta
  $stmt_check_payment->close();
} else {
  // Trata o caso em que o campo data_pagamento está vazio
  echo "Erro: O campo data_pagamento está vazio.";
}
}

// Fecha a conexão e libera recursos
$conn->close();
?>
    <section class="content-header">
   
  
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer footer-white-text" style="background-color: #4169E1; text-color: #FFFFFF;">
  <strong style="color: #fff;">Copyright &copy;<a href="">Talentos em Ascensão</a>.</strong>
  <span style="color: #fff;">Todos os direitos reservados</span>
</footer>

  <!-- Control Sidebar -->
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
</body>
</html>

