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
      <link rel="icon" href="dist/img/5.png">

</head>

    
<style>
  body {
  overflow-x: hidden;
}
    .table-responsive {
  display: flex;
  justify-content: center;
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
.sideba-text-sm {
  font-size: 1rem; /* Adjust the font size as needed */
}
.centered-text {
    color: #FFFFFF;
    text-align: center;
  }
  </style>

<?php
 include_once 'Conexao.class.php';
 include_once 'Manager.class.php';
 include_once 'dependencias.php';

    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sql_hugo_igr05_p";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    if (!isset($_SESSION['nome_completo']) || $_SESSION['nome_completo'] != "administrator") {
      // Redireciona para a página de login ou para outra página não autorizada
      header("Location: index.php");
      exit(); // Certifique-se de sair após redirecionar
  }
    $nomeSocio = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : '';

    if ($_SESSION['nome_completo'] != 'administrator') {
      // Se não for o administrador, redireciona para a página de login
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

   

    $manager = new Manager();
    $sql = "SELECT COUNT(*) as total FROM socios WHERE data_criacao >= NOW() - INTERVAL 24 HOUR";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalSocios24h = $row['total'];

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
  <div class="content-wrapper"style="background: linear-gradient(to bottom,#00008B, #4169E1);">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 style="color: #FFFFFF;">Lista de Quotas Pagas</h1>          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index1.php">Início</a></li>
              <li class="breadcrumb-item active"style="color: #FFFFFF;">Lista de Quotas Pagas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
  <div class="container-fluid"style="background-color: #00008B;">
    <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
    <thead>
      <tr>
        <th  style="color: #FFFFFF;">NºPagamento</th>
        <th  style="color: #FFFFFF;">NºSócio</th>
        <th  style="color: #FFFFFF;">Valor Pago</th>
        <th  style="color: #FFFFFF;">Data Pagamento</th>
        <th  style="color: #FFFFFF;">Data Proximo Pagamento</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($manager->listPagamentoQuotas() as $pagamento):?>
      <tr>
        <td  style="color: #FFFFFF;"><?= $pagamento['id_pagamento']?></td>
        <td  style="color: #FFFFFF;"><?= $pagamento['id_socio']?></td>
        <td  style="color: #FFFFFF;"><?= $pagamento['valor_pago']?></td>
        <td  style="color: #FFFFFF;"><?= $pagamento['data_pagamento']?></td>
        <td  style="color: #FFFFFF;"><?= $pagamento['data_proximo_pagamento']?></td>
        <td class="text-center">
          
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>

  <!-- Modal para confirmar exclusão -->
  <?php foreach ($manager->listPagamentoQuotas() as $pagamento):?>
<div class="modal fade" id="deleteModal<?= $pagamento['id_pagamento']?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Excluir mensagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tem a certeza que deseja excluir a quota?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="delete_quotas.php">
          <input type="hidden" name="id_pagamento" value="<?= $pagamento['id_pagamento']?>">
          <button type="submit" class="btn btn-custom-red">
            Excluir
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
  <?php endforeach;?>
</div>

    
</tbody>
      </table>
    </div>
  </div>
</section>
</div>
  
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
  <footer class="main-footer footer-white-text" style="background-color: #4169E1; text-color: #FFFFFF;">  <strong style="color: #fff;">Copyright &copy;<a href="">Talentos em Ascensão</a>.</strong>
  <span style="color: #fff;">Todos os direitos reservados</span>
    </div>
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

