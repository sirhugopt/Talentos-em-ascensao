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
  if ($_SESSION['nome_completo'] != 'administrator') {
    // Se não for o administrador, redireciona para a página de login
    header("Location:Loginn.php");
    exit();
}
  $sql = "SELECT COUNT(*) AS total_produtos FROM loja";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // Exibir o número de sócios
    $row = $result->fetch_assoc();
    $total_produtos = $row["total_produtos"];
  } else {
    $total_produtos = 0;
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

 
  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta SQL para recuperar os últimos pagamentos da tabela pagamento_quotas
$sql = "SELECT id_pagamento, valor_pago, status_quotas, data_pagamento FROM pagamento_quotas ORDER BY data_pagamento DESC LIMIT 10";
$result = $conn->query($sql);

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
  $sql = "SELECT COUNT(*) AS total_quotas FROM pagamento_quotas";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // Exibir o número de sócios
    $row = $result->fetch_assoc();
    $total_quotas = $row["total_quotas"];
  } else {
    $total_quotas = 0;
  }
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
$sql = "SELECT COUNT(*) AS total_socios FROM socios";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // Exibir o número de sócios
    $row = $result->fetch_assoc();
    $total_socios = $row["total_socios"];
} else {
    $total_socios = 0;
}
$sql = "SELECT * FROM socios ORDER BY data_criacao DESC LIMIT 4";
$result = $conn->query($sql);
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Talentos em Ascensão  </title>

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
.img-circle {
  border-radius: 50%;
}
.card {
  margin: 0 auto;
  max-width: 800px;
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
  <a href="logout.php" class="nav-link">
    <p class="sidebar-text-sm"style="color: #fff;">Terminar Sessão</p>
  </a>
</li>
<li class="nav-item">
  <a href="gestao.php" class="nav-link" style="color: #007bff; text-decoration: none;">
    <i class="" style="color: #007bff;"></i>
    <p class="sidebar-text-sm" style="color: #daa520;">Painel de Administração</p>
  </a>
</li>
<?php if (isset($_SESSION["nome_completo"]) && $_SESSION["nome_completo"] == "administrator"): ?>

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
<h1 class="m-0" style="color: #fff;">Painel de Administração</h1>          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item light"><a href="#">Início</a></li>
              <li class="breadcrumb-item active "style="color: #fff;">Painel de Administração</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Produtos</span>
                <span class="info-box-number">
                <?php echo $total_produtos; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Encomendas</span>
                <span class="info-box-number">0</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Quotas Pagas</span>
                <span class="info-box-number"><?php echo $total_quotas; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total de Sócios</span>
                <span class="info-box-number"><?php echo $total_socios; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
            <!-- /.info-box -->
          </div>
          <div class="container">
  <div class="row">
    <div class="col-md-6">
      <!-- USERS LIST -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ultimos Sócios</h3>
        </div>
        <div class="card-body p-0">
          <ul class="users-list clearfix">
            <?php
            if ($result->num_rows > 0) {
              // Saída de dados de cada linha
              while($row = $result->fetch_assoc()) {
                echo "<li>";
                echo '<img src="' . $row["imagem"] . '" style="border-radius: 50%; width: 100px; height: 80px;" class="elevation-2" alt="User Image">';
                echo "<span class='users-list-date' style='color: white;'>" . $row["nome_completo"] . "</span>";
                echo "<span class='users-list-date' style='color: white;'>" . $row["data_criacao"] . "</span>";
                echo "</li>";
              }
            } else {
              echo "0 results";
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <!-- LATEST PAYMENTS -->
      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title">Ultimos Pagamentos</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover m-0 w-100">
              <thead>
                <tr>
                  <th>Nº Pagamento</th>
                  <th>Valor Pago</th>
                  <th>Status</th>
                  <th>Data Pagamento</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT id_pagamento, valor_pago, status_quotas, data_pagamento
                          FROM pagamento_quotas
                          ORDER BY data_pagamento DESC";

                $result = mysqli_query($conn, $query);
                if (!$result) {
                  die("Erro ao executar query: " . mysqli_error($conn));
                }
                while($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . $row["id_pagamento"] . '</td>';
                  echo '<td>' . $row["valor_pago"] . '</td>';
                  echo '<td><span class="badge badge-' . ($row["status_quotas"] == "Pago" ? "success" : "warning") . '">' . $row["status_quotas"] . '</span></td>';
                  echo '<td>' . $row["data_pagamento"] . '</td>';
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <div class="mb-4"></div>

      <!-- LATEST PRODUCTS -->
      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title">Ultimos Produtos</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover m-0 w-100">
              <thead>
                <tr>
                <th>Imagem</th>
                  <th>Nome do Produto</th>
                  <th>Descrição</th>
                  <th>Preço</th?>
                  <th>Tamanho</th>
                  <th>Cor</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT nome_produto, descricao, preco, tamanho, cor, imagem_produto
                          FROM loja
                          ORDER BY nome_produto ASC";

                $result = mysqli_query($conn, $query);
                if (!$result) {
                  die("Erro ao executar query: ". mysqli_error($conn));
                }
                while($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td><img src="'. $row["imagem_produto"]. '" alt="'. $row["nome_produto"]. '" width="250"></td>';
                  echo '<td>'. $row["nome_produto"]. '</td>';
                  echo '<td>'. substr($row["descricao"], 0, 50). '...</td>';
                  echo '<td>'. number_format($row["preco"], 2, ',', '.'). '€</td>';
                  echo '<td>'. $row["tamanho"]. '</td>';
                  echo '<td>'. $row["cor"]. '</td>';
                  echo '</tr>';
                }
               ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
               </div>
            </div>
            <!-- /.card-body -->
         </div>
      </div>
   </div>
</div>

   </div>
</div>
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
