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

<?php  
     include_once 'Conexao.class.php';
    include_once 'Manager.class.php';
    include_once 'dependencias.php';
    ?>
    
<style>
    .table-responsive {
  display: flex;
  justify-content: center;
}
.sidebar {
  overflow: hidden;
}
 .btn-custom-blue {
    background-color: blue;
    color: white; /* Opcional: ajuste a cor do texto conforme necessário */
    margin: 0 auto;
    box-shadow: none; /* Add this to remove the shadow */
}
.btn-custom-red {
    background-color: red;
    color: white; /* Opcional: ajuste a cor do texto conforme necessário */
    margin: 0 auto;
    box-shadow: none; /* Add this to remove the shadow */
}
.sidebar-text-sm {
  font-size: 0.92rem; /* Adjust the font size as needed */
}
.sideba-text-sm {
  font-size: 1.1rem; /* Adjust the font size as needed */
}
.blue-gradient {
    background: linear-gradient(to bottom, #4567b7, #6495ed, #87ceeb);
    height: 100vh; /* or any other height you want */
    width: 100vw; /* or any other width you want */
}
.profile-username {
  color: #FFFFFF; /* or simply "white" */
}

  </style>

<?php
    session_start();

    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "sql_hugo_igr05_p";

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $nomeSocio = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : '';

    if (!isset($_SESSION['nome_completo']) || $_SESSION['nome_completo'] == 'administrator') {
      // Se não estiver logado ou for o administrador, redireciona para a página de login
      header("Location:Loginn.php");
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

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["npassword"]) && isset($_POST["confirm_password"])) {
            $npassword = $_POST["npassword"];
            $confirm_password = $_POST["confirm_password"];

            if ($npassword == $confirm_password) {
                $senha = password_hash($npassword, PASSWORD_DEFAULT);

                $sql = "UPDATE socios SET senha=? WHERE id_socio=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $senha, $dadosSocio['id_socio']);
                $stmt->execute();

                // Redirecionar para a página de perfil do sócio
                header("Location: profile.php");
                exit();
            } else {
                $error = "As senhas não coincidem";
            }
        }

}
    $manager = new Manager();
    $sql = "SELECT COUNT(*) as total FROM socios WHERE data_criacao >= NOW() - INTERVAL 24 HOUR";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalSocios24h = $row['total'];
// Defina sua consulta SQL para selecionar os dados da tabela 'pagamento_quotas'

// Defina sua consulta SQL para selecionar os dados da tabela 'pagamento_quotas' usando '

$sql = "SELECT data_pagamento, data_proximo_pagamento FROM pagamento_quotas WHERE id_socio =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $dadosSocio['id_socio']);
$stmt->execute();
$result = $stmt->get_result();
$statusQuota = $result->fetch_assoc();
// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id']; // ID do sócio sendo atualizado
  $nome = $_POST["name"];
  $dataNascimento = $_POST["birth"];
  $email = $_POST["email"];
  $morada = $_POST["morada"];
  $codigopostal = $_POST["codigopostal"];
  $concelho = $_POST["concelho"];
  $distrito = $_POST["distrito"];
  $telefone = $_POST["phone"];
  $genero = $_POST["gender"];

  $imagemAtualizada = false;
  $target_file = "";

  if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
      $target_dir = "images/socios/";
      // Adicionar um identificador único ao nome do arquivo para evitar duplicatas
      $unique_name = uniqid() . "_" . basename($_FILES["imagem"]["name"]);
      $target_file = $target_dir . $unique_name;
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      // Verifica se o arquivo é uma imagem real
      $check = getimagesize($_FILES["imagem"]["tmp_name"]);
      if ($check !== false) {
          $uploadOk = 1;
      } else {
          echo "O arquivo não é uma imagem.<br>";
          $uploadOk = 0;
      }

      // Verifica o tamanho do arquivo (opcional)
      if ($_FILES["imagem"]["size"] > 500000) { // 500KB
          echo "Desculpe, seu arquivo é muito grande.<br>";
          $uploadOk = 0;
      }

      // Permite certos formatos de arquivo
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
          echo "Desculpe, apenas arquivos JPG, JPEG, PNG & GIF são permitidos.<br>";
          $uploadOk = 0;
      }

      // Verifica se $uploadOk está configurado como 0 devido a algum erro
      if ($uploadOk == 0) {
          echo "Desculpe, seu arquivo não foi enviado.<br>";
      } else {
          if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
              // Arquivo de imagem enviado com sucesso
              echo "Imagem enviada com sucesso.<br>";
              $imagemAtualizada = true;
          } else {
              echo "Desculpe, houve um erro ao enviar seu arquivo.<br>";
          }
      }
  }

  // Atualizar os dados do sócio na base de dados
  if ($imagemAtualizada) {
      $sql = "UPDATE socios SET nome_completo = ?, data_nascimento = ?, email = ?, morada = ?, codigopostal = ?, concelho = ?, distrito = ?, numero_telemovel = ?, sexualidade = ?, imagem = ? WHERE id_socio = ?";
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
          die("Erro na preparação da consulta: " . $conn->error);
      }
      $stmt->bind_param('ssssssssssi', $nome, $dataNascimento, $email, $morada, $codigopostal, $concelho, $distrito, $telefone, $genero, $target_file, $id);
  } else {
      $sql = "UPDATE socios SET nome_completo = ?, data_nascimento = ?, email = ?, morada = ?, codigopostal = ?, concelho = ?, distrito = ?, numero_telemovel = ?, sexualidade = ? WHERE id_socio = ?";
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
          die("Erro na preparação da consulta: " . $conn->error);
      }
      $stmt->bind_param('sssssssssi', $nome, $dataNascimento, $email, $morada, $codigopostal, $concelho, $distrito, $telefone, $genero, $id);
  }

  if ($stmt->execute()) {
      echo "Dados atualizados com sucesso.<br>";
      // Redirecionar para a página de perfil do sócio
      header("Location: index.php");
      exit();
  } else {
      echo "Erro ao atualizar os dados: " . $stmt->error . "<br>";
  }

  $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();

    ?>

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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="text-white">Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" style="color: #fff;">Perfil de Sócio</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline"style="background-color: #00008B;">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $dadosSocio['imagem'];?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center text-white"><?php echo $nomeSocio;?></h3>
                <p class="text-center">
  <span class="text-white">Sócio Nº <?php echo $dadosSocio['id_socio']; ?>
</p>
                  </li>
                  </li>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary"style="background-color: #00008B;">
              <div class="card-header"style="background-color: #00008B;">
                <h3 class="card-title">Sobre Mim</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <strong class="text-white"><i class="fas fa-book mr-1"></i> Sócio desde</strong>
                <p class="text-muted">
                  <?php echo $dadosSocio['data_criacao']; ?>
                </p>

              <hr>
              <strong class="text-white"><i class="fas fa-book mr-1"></i> Ultimas Quotas Pagas</strong>

<p class="text-muted">
  <?php echo!empty($statusQuota['data_pagamento'])? $statusQuota['data_pagamento'] : 'Não pagou';?>
</p>

<hr>
<strong class="text-white"><i class="fas fa-book mr-1"></i> Proximo Pagamento</strong>

<p class="text-muted">
  <?php echo!empty($statusQuota['data_proximo_pagamento'])? $statusQuota['data_proximo_pagamento'] : 'Não há próximo pagamento';?>
</p>



              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card"style="background-color: #00008B;">
              <div class="card-header p-2">
               <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab" style="color: #fff;">Definições</a></li>

                  <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab" style="color: #fff;">Alterar senha</a></li>
                  
                </ul>

              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  
                  <!-- /.tab-pane -->
                 <div class="tab-content">
    <div class="tab-pane active" id="settings"style="background-color: #00008B;">
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="form-group row" text-white>
        <label for="imagem" class="col-sm-2 col-form-label text-white">Imagem</label>
        <div class="col-sm-10">
            <input type="file" name="imagem" id="imagem"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label text-white">Nome</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="name" required autofocus value="<?=$dadosSocio['nome_completo']?>"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label text-white">Data Nascimento</label>
        <div class="col-sm-10">
            <input class="form-control" type="date" name="birth" required value="<?=$dadosSocio['data_nascimento']?>"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName2" class="col-sm-2 col-form-label text-white">Email</label>
        <div class="col-sm-10">
            <input class="form-control" type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required value="<?=$dadosSocio['email']?>"><br>
        </div>
    </div>

    <div class="form-group row">
        <label for="inputExperience" class="col-sm-2 col-form-label text-white">Morada</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="morada" required value="<?=$dadosSocio['morada']?>"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputExperience" class="col-sm-2 col-form-label text-white">Codigo Postal</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="codigopostal" required value="<?=$dadosSocio['codigopostal']?>"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputExperience" class="col-sm-2 col-form-label text-white">Concelho</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="concelho" required value="<?=$dadosSocio['concelho']?>"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputExperience" class="col-sm-2 col-form-label text-white">Distrito</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="distrito" required value="<?=$dadosSocio['distrito']?>"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label text-white">Número Telemovel</label>
        <div class="col-sm-10">
          
            <input class="form-control" type="text" name="phone"  pattern="[0-9]{9}" required value="<?=$dadosSocio['numero_telemovel']?>"><br>
            
        </div>
    </div>
    <div class="form-group row">
        <label for="inputSkills" class="col-sm-2 col-form-label text-white">Género</label>
        <div class="col-sm-10">
            <select class="form-control" name="gender" required>
                <option value="masculino" <?= ($dadosSocio['sexualidade'] == 'masculino')? 'selected' : ''?>>Masculino</option>
                <option value="feminino" <?= ($dadosSocio['sexualidade'] == 'feminino')? 'selected' : ''?>>Feminino</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="id" value="<?=$dadosSocio['id_socio']?>"> <!-- Substitua pelo ID real do sócio -->
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <button class="btn btn-primary" type="submit">Atualizar dados</button>
        </div>
    </div>
</form>
    </div>
  <div class="tab-pane" id="password">
    <form class="form-horizontal" method="post">
        <div class="form-group row">
            <label for="npassword" class="col-sm-2 col-form-label text-white">Nova Senha</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="npassword" name="npassword" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="confirm_password" class="col-sm-2 col-form-label text-white">Confirmar Nova Senha</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
        </div>
        <?php if (isset($error)):?>
            <div class="alert alert-danger"><?= $error?></div>
        <?php endif;?>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
            <button class="btn btn-primary" type="submit">Atualizar Senha</button>
            </div>
        </div>
    </form>
</div>
<div class="tab-pane" id="imagem">
    <form class="form-horizontal" method="post">
        <div class="form-group row">
        <?php
    
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <?php if (!empty($error)):?>
        <p style="color: red;"><?php echo $error;?></p>
    <?php endif;?>
    <?php if (file_exists('images/socios/'. $dadosSocio['imagem'])):?>
        <img src="<?php echo 'images/socios/'. $dadosSocio['imagem'];?>" alt="Imagem do sócio" width="100">
    <?php else:?>
        <p>Nenhuma imagem encontrada</p>
    <?php endif;?>
    <input class="form-control" type="file" name="new_image" id="new_image"><br>
    <button class="btn btn-primary" type="submit">Atualizar Imagem</button>
</form>


                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="background-color: #4169E1;">
  <strong style="color: #fff;">Copyright &copy;<a href="">Talentos em Ascensão</a>.</strong>
  <span style="color: #fff;">Todos os direitos reservados</span>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
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

