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
    if ($_SESSION['nome_completo'] != 'administrator') {
      // Se não for o administrador, redireciona para a página de login
      header("Location:Loginn.php");
      exit();
  }
    $nomeSocio = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : '';

    if (!isset($_SESSION['nome_completo'])) {
        header("Location: login.php");
        exit();
    }

    $isAdmin = isset($_SESSION['administrator']) ? $_SESSION['administrator'] : false;

    $sql = "SELECT id_socio, imagem, nome_completo, data_nascimento, morada, email, codigopostal, concelho, distrito, numero_telemovel, sexualidade FROM socios";
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
  .content {
  margin-top: 10px;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
}
body {
  overflow-x: hidden; /* Esconde o transbordamento horizontal */
  box-shadow: none;
}
.product-card {
  width: 250px; /* Reduz o tamanho do cartão */
  height: 400px; /* Altura fixa para os cartões */
  margin: 5px;
  padding: 25px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out;
  margin: 10px 15px;
  overflow-y: auto;
}

        .product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.product-card h3, .product-card h4 {
    margin: 0;
    padding: 10px;
}

.actions {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.actions a {
    margin: 0 10px;
}
        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .product-card .actions {
            display: flex;
            justify-content: space-between;
        }

        .product-card a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
            display: block;
            text-align: center;
            padding: 10px;
            background-color: #00008B;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .product-card a:hover {
            background-color: #4169E1;
        }

        .welcome-message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
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
<h1 class="m-0" style="color: #fff;">Lista de Produtos</h1>          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item light"><a href="#">Início</a></li>
              <li class="breadcrumb-item active "style="color: #fff;">Lista de Produtos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
    <?php
                require_once 'ligacaoBD.php';
                $con = ligaBD();

                if ($con == TRUE) {
                    $query = $con->query("SELECT * FROM loja");
                    $linhas = mysqli_num_rows($query);

                    if ($linhas > 0) {
                        while ($resultados = $query->fetch_assoc()) {
                            echo '<div class="col-md-4">';
                            echo '<div class="product-card">';
                            echo '<img src="'. $resultados['imagem_produto']. '" alt="Imagem do Produto">';
                            echo '<h4>Nome Produto: '. $resultados['nome_produto']. '</h4>';
                            echo '<h4>Descrição: '. substr($resultados['descricao'], 0, 30). '...</h4>';
                            echo '<h4>Tamanho: '. $resultados['tamanho']. '</h4>';
                            echo '<h4>Cor: '. $resultados['cor']. '</h4>';

                            echo '<div class="actions">';

                            if (isset($_SESSION["nome_completo"]) && $_SESSION["nome_completo"] == "administrator") {
                                echo '<a href="pageupdateprod.php?id='. $resultados['id']. '">Editar</a>';
                                echo '<a href="apagar.php?id='. $resultados['id']. '" onclick="return checkdelete()">Eliminar</a>';
                            }

                            echo '</div>';

                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "\nA Lista de Produtos está vazia";
                    }

                    $con->close();
                }
              ?>
              </section>
      <div class="container-fluid">
        
      <div class="container">
    

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
  
        </div>
      </div>
    </div>
  </div>

  
        </div>
      </div>
    </div>
  </div>
</div>




    
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
