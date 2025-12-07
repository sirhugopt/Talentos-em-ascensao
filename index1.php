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

  if (!isset($_SESSION['nome_completo']) || $_SESSION['nome_completo'] == 'administrator') {
    // Se não estiver logado ou for o administrador, redireciona para a página de login
    header("Location:Loginn.php");
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
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Talentos em Ascensão</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="cs.css">
<link rel="icon" href="dist/img/5.png">

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
body.dark-mode {
  background-color: #333;
  color: #ddd;
}

body.light-mode {
  background-color: #fff;
  color: #333;
}
  </style>

 
  <style>
.nav-item {
  border: none;
}

</style>

<body class="hold-transitio #3399ffn  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed>

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center v">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
<div class="wrapper">

  <!-- Preloader -->
  

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light" style="background-color: #00008B;">
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
  <div class="content-wrapper" style="background: linear-gradient(to bottom,#00008B, #4169E1);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
<h1 class="m-0" style="color: #fff;">Início</h1>          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item light"><a href="#">Início</a></li>
              <li class="breadcrumb-item active "style="color: #fff;">Início</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
      <div class="container">
<img id="originalImage" src="dist/img/socio.png" alt="Imagem Original">
<div class="infoo-box">
<img src="<?php echo $dadosSocio['imagem'];?>" alt="Imagem do Sócio"
              style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; overflow: hidden;">
           <a href="#" data-toggle="modal" data-target="#updateImageModal">
</a>
<div class="modal fade" id="updateImageModal" tabindex="-1" role="dialog" aria-labelledby="updateImageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateImageModalLabel">Atualizar Imagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
          <input type="file" name="new_image" accept="image/*">
          <button type="submit" class="btn btn-primary">Atualizar Imagem</button>
        </form>
      </div>
    </div>
  </div>
</div>
            <p style="color: white;"><?php echo $dadosSocio['nome_completo']; ?></p>
            <p style="color: white;">Sócio Nº <?php echo $dadosSocio['id_socio']; ?></p>

          </div>
                    <div class="mb-4"></div> 

        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">

              <div class="info-box-content">
              
              </div>
              
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">

              <div class="info-box-content">
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="d-flex justify-content-center">

        <div class="card"style="background: #00008B"> 
  <div class="mb-4"></div> 

  <div id="member-card" class="slb-profile-item">
    <div class="title" style="margin-bottom: 30px;color: #fff;" >Cartão de Sócio</div>
    <div class="card-wrapper" style="position: relative;">
      <img src="dist/img/cartao.png" class="loaded">
      <div class="card-info" style="position: absolute; top:70%; left: 15%; transform: translate(-50%, -50%);">
        <div class="card-info-img-wrapper" style="position: absolute; top: -5%; left: 35%; transform: translate(-50%, -50%);">
          <?php if ($dadosSocio):?>
            <img src="<?php echo $dadosSocio['imagem'];?>" alt="Imagem do Sócio" style="border-radius: 50%; width: 40px; height: 40px;">          <?php endif;?>
        </div>
        <div class="card-info-text-wrapper" style="margin-top: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 95px;">
    <?php if ($dadosSocio):?>
    <p style="margin-bottom: 5px;">Sócio Nº<?php echo $dadosSocio['id_socio'];?></p>
    <p style="margin-bottom: 5px;"><?php echo ''. $categoria;?></p>
    <p style="margin-bottom: 0;"><?php echo $dadosSocio['nome_completo'];?></p>
    <?php endif;?>
</div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <div class="containe">
      <div class="row">
        <div class="col-md-6">
          <div class="containe text-center">
              
            <span class="title" style="font-size: 90%;color: #fff;">Dados de Sócio</span>
            <a class="btn" href="profile.php">Editar</a>
          </div>
        </div>
        </div>
        <div class="col-md-6">
          <div class="containe text-center">
            <span class="title" style="font-size: 90%;color: #fff;">Quotas</span>
            <a class="btn" href="invoice.php">Pagar Quotas</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="d-flex justify-content-center">
        <!-- Conteúdo adicional -->
      </div>
    </div>
  </div>
</div>



    <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">

              <div class="info-box-content">
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">

              <div class="info-box-content">
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          

                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="background: #4169E1">

                <div class="row">
                  <div class="col-md-8">
                    

                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-12">
                    <p class="text-center">
                    </p>

                   
                    </div>
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
            </div>
            <!-- /.card -->
            <div class="row">
              <div class="col-md-6">
                
                  
                </div>
                <!--/.direct-chat -->
              </div>
            </div>
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
             
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" style="background-color: #4169E1;">
  <strong style="color: #fff;">Copyright &copy;<a href="">Talentos em Ascensão</a>.</strong>
  <span style="color: #fff;">Todos os direitos reservados</span>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
