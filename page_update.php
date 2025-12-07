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
  
</head>
<?php 
 session_start();

 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "sql_hugo_igr05_p";

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $nomeSocio = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : '';

    if (!isset($_SESSION['nome_completo'])) {
        header("Location: login.php");
        exit();
    }

    $isAdmin = isset($_SESSION['administrator']) ? $_SESSION['administrator'] : false;

    $sql = "SELECT id_socio, imagem, nome_completo, data_nascimento, morada, email, numero_telemovel, sexualidade FROM socios";
    $result = $conn->query($sql);

    $persons = array();
    while ($row = $result->fetch_assoc()) {
        $persons[] = $row;
    }
    $nomeSocio = $_SESSION['nome_completo'];

    $sql = "SELECT * FROM socios WHERE nome_completo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nomeSocio);
    $stmt->execute();
    $result = $stmt->get_result();
    $dadosSocio = $result->fetch_assoc();

   

    $sql = "SELECT COUNT(*) as total FROM socios WHERE data_criacao >= NOW() - INTERVAL 24 HOUR";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalSocios24h = $row['total'];
include_once 'Conexao.class.php';
include_once 'Manager.class.php';
include_once 'dependencias.php'; 

$manager = new manager();

// Verifica se o ID do sócio foi enviado pelo formulário
if(isset($_POST['id_socio']) && !empty($_POST['id_socio'])) {
    $id_socio = $_POST['id_socio']; // Obtém o ID do sócio
    echo "ID do sócio: " . $id_socio; // Imprime o ID do sócio
} else {
    // Se o ID do sócio não estiver presente, redirecione para a página de erro ou faça outra coisa apropriada
    header("Location: error.php");
    exit();
}

if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    // Diretório onde as imagens serão armazenadas
    $uploadDirectory = '../crud/backend/images/';

    // Gera um nome único para o arquivo de imagem
    $imageName = uniqid('image_') . '_' . basename($_FILES['imagem']['name']);

    // Caminho completo para salvar a imagem
    $uploadFilePath = $uploadDirectory . $imageName;

    // Move o arquivo de imagem para o diretório de upload
   // Move o arquivo de imagem para o diretório de upload
if(move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFilePath)) {
    // Atualiza o nome da imagem no banco de dados
    $manager->updateImage("socios", $id_socio, $imageName);
    echo "Arquivo enviado com sucesso! Nome do arquivo: " . $imageName;
    echo "Caminho completo do arquivo: " . $uploadFilePath;
} else {
    // Se houver algum erro ao mover o arquivo, exiba uma mensagem de erro
    echo "Erro ao fazer upload da imagem.";
}
}

?>
    
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed
open_basedir = "/www/wwwroot/hugo.igr05.pt/:/tmp/:/www/wwwroot/hugo.igr05.pt/dist/img/"
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Início</a>
      </li>
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

      
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/5.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">Talentos em Ascensão</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
        <div class="image">
<img src="<?php echo $dadosSocio['imagem'];?>" class="img-circle elevation-2" alt="Imagem do Sócio">       </div>
                    

             <span class="nav-profile-name"><?php echo $nomeSocio;?></span>
             
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
                <i class="fa fa-dashboard"></i>
                  <p>Dashboard</p>
                </a>
              </li>
          </li>

                    <?php if (isset($_SESSION["nome_completo"]) && $_SESSION["nome_completo"] == "administrator"): ?>
            
                     <li class="nav-item">
              <a href="atualizarsocios.php" class="nav-link" style="color: #ffd700; text-decoration: none;">
                <i class="fa fa-dashboard" style="color: #ffd700;"></i>
                <p style="color: #ffd700;">Atualizar Sócios</p>
              </a>
            </li>
                    <?php endif; ?>
<?php if (isset($_SESSION["nome_completo"]) && $_SESSION["nome_completo"] == "administrator"): ?>
            
                     <li class="nav-item">
  <a href="listaquotas.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <i class="" style="color: #007bff;"></i>
    <p style="color: #007bff;">Lista de Quotas Pagas</p>
  </a>
</li>
                          <?php endif; ?>

          <li class="nav-item">
                <a href="logout.php" class="nav-link">
                <i class="fas fa-door-open"></i>
                  <p>Logout</p>
                </a>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Atualizar Sócios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Início</a></li>
              <li class="breadcrumb-item active">Atualizar Sócios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <div class="card-tools">
                 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#cpf").mask("000.000.000-00");
        $("#phone").mask("(00) 0000-0000");
    });
</script>
              </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
<h2 class="text-center">
    Atualizar Sócio <i class="fa fa-user-edit"></i>
</h2><hr>

<form method="POST" action="update_client.php" enctype="multipart/form-data">
    <div class="container">
        <div class="form-row">
        <input type="hidden" name="id_socio" value="<?php echo $id_socio; ?>">

            <?php 
            $socio_info = $manager->getInfo("socios", $id_socio);
            
            foreach($socio_info as  $Socio_info): 
            ?>
            


            <div class="col-md-6">
                Nome: <i class="fa fa-user"></i>
                <input class="form-control" type="text" name="name" required autofocus value="<?=$Socio_info['nome_completo']?>"><br>
            </div>
            <div class="col-md-4">
                Dt. de Nascimento: <i class="fa fa-calendar"></i>
                <input class="form-control" type="date" name="birth" required value="<?= $Socio_info['data_nascimento'] ?>"><br>
            </div>
            <div class="col-md-6">
                E-mail: <i class="fa fa-envelope"></i>
                <input class="form-control" type="email" name="email" required value="<?= $Socio_info['email'] ?>"><br>
            </div>
            <div class="col-md-4">
                CPF: <i class="fa fa-address-card"></i>
                <input class="form-control" type="text" name="morada" required id="morada" value="<?= $Socio_info['morada'] ?>"><br>
            </div>

            <div class="col-md-4">
                Telefone: <i class="fab fa-whatsapp"></i>
                <input class="form-control" type="text" name="phone" required id="phone" value="<?= $Socio_info['numero_telemovel'] ?>"><br>
            </div>

            <div class="col-md-4">
                Género: <i class="fa fa-venus-mars"></i>
                <select class="form-control" name="gender" required>
                    <option value="masculino" <?= ($Socio_info['sexualidade'] == 'masculino') ? 'selected' : '' ?>>Masculino</option>
                    <option value="feminino" <?= ($Socio_info['sexualidade'] == 'feminino') ? 'selected' : '' ?>>Feminino</option>
                </select>
            </div>

            <div class="col-md-12">
                Endereço: <i class="fa fa-map"></i>
                <input class="form-control" type="text" name="senha" required value="<?= $Socio_info['senha'] ?>"><br>
            </div>
            <!-- Restante do código... -->

            <?php endforeach;?>
            <button class="btn btn-warning btn-lg">
                Update Client <i class="fa fa-user-edit"></i>
            </button><br><br>

            <a href="atualizarsocios.php">
                Voltar
            </a>
        </div>
    </div>
</form>

    <section class="content">
     
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
                    <div class="mb-4"></div> 


  </div>
</div>
</div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
              <div class="card-body">
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
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy;<a href="">Reis Manuel</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
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
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
