
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
    $sql_update = "UPDATE pagamento_quotas SET status_quotas = 'pago', data_ultimo_pagamento = CURRENT_DATE WHERE id_socio = $id_socio";
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
  <div class="content-wrapper"style="background: linear-gradient(to bottom,#00008B, #4169E1);">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 style="color: #FFFFFF;">Pagamento de Quotas</h1>          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"style="color: #FFFFFF;">Pagamento de Quotas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <div class="callout callout-info" style="background-color: #00008B;">
  <h5 style="color: #FFFFFF;"><i class="fas fa-info" style="color: #FFFFFF;"></i> Nota:</h5>
  <span style="color: #FFFFFF;">Apenas poderá pagar as suas quotas mês a mês.</span>
</div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3"style="background-color: #00008B;">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                <h4 style="color: #FFFFFF;">
  <img src="dist/img/5.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8 "> Talentos em Ascensão
  <small class="float-right">Data: <?= date_format($dueDate, 'd/m/Y');?></small>
</h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col" style="color: white;">
                  De
                  <address style="color: white;">
                    <strong>Talentos em Ascensão</strong><br>
                   Rua São Francisco Xavier, Alto do Forte,<br>
                    2635-195 - Rio de Mouro<br>
                    Telemóvel: +351 967 845 634<br>
                    Email: talentosemascencao@afl.pt
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col"style="color: white;">
                  Para
                 <address>
                  <strong class="white-text"><?= $dadosSocio['nome_completo'];?></strong><br>
                  <?= $dadosSocio['morada'];?><br>
                  <?= $dadosSocio['codigopostal']; ?> - <?= $dadosSocio['concelho']; ?> <br>
                  Telemóvel:  +351  <?= $dadosSocio['numero_telemovel'];?><br>
                  Email: <?= $dadosSocio['email'];?>
                </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col"style="color: white;">
  <b>Fatura #<?= sprintf("%06d", $invoiceNumber);?></b><br>

  <b>ID do Pedido:</b> <?= $orderId;?><br>
  <b>Data de Pagamento:</b> <?= date_format($dueDate, 'd/m/Y');?><br>
  <b>Nº Sócio:</b>  <?= $dadosSocio['id_socio'];?>
</div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                   <thead>
  <tr style="color: white;">
    <th>Quantidade</th>
    <th>Quota Mensal</th>
    <th>Total</th>
  </tr>
</thead>
<tbody>
 <?php
// assume que $dadosSocio é um array com os dados do sócio
$data_nascimento = $dadosSocio['data_nascimento'];
$idade = date_diff(date_create($data_nascimento), date_create('now'))->y;

if ($idade <= 13) {
    $quota_mensal = 1;
} elseif ($idade >= 14 && $idade <= 17) {
    $quota_mensal = 3;
} else {
    $quota_mensal = 5;
}

// Verifique se o pagamento já foi realizado este mês
$status_quotas = 'pendente'; // assume que este é o valor de status_quotas
if ($status_quotas === 'pago') {
    $showPaymentMessage = true;
} else {
    $showPaymentMessage = false;
}
?>
  <tr style="color: white;">
    <td>1</td>
    <td>1 Mês</td>
    <td><?= $quota_mensal?> €</td>
  </tr>
</tbody>
                  </table>
             <div class="row">
  <!-- accepted payments column -->
  <div class="col-6">
    <p class="lead" style="color: white;">Métodos de Pagamento:</p>
        <?php if (!$showPaymentMessage) {?>

    <form id="payment-form">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_method" id="visa" value="Visa">
        <label class="form-check-label" for="visa" style="color: white;">
          <img src="dist/img/credit/visa.png" alt="Visa" >
          Visa
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_method" id="mastercard" value="Mastercard">
        <label class="form-check-label" for="mastercard"style="color: white;">
          <img src="dist/img/credit/mastercard.png" alt="Mastercard">
          Mastercard
        </label>
      </div>
      
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="Paypal">
        <label class="form-check-label" for="paypal"style="color: white;">
          <img src="dist/img/credit/paypal2.png" alt="Paypal">
          Paypal
        </label>
      </div>
    </form>
<?php } else {?>
        <p>Já pagou este mês.</p>
      <?php }?>
    <div id="payment-fields" class="text-muted well well-sm shadow-none" style="margin-top: 10px; display: none;">
      <!-- Campos de entrada para os detalhes do cartão de crédito ou PayPal -->
      <div id="credit-card-fields" style="display: none;">
        <div class="form-group">
          <label for="card-number">Número do cartão</label>
          <input type="text" class="form-control" id="card-number" placeholder="Número do cartão" required>
        </div>
        <div class="form-group">
          <label for="card-expiry">Data de validade</label>
          <input type="text" class="form-control" id="card-expiry" placeholder="MM/AA" required>
        </div>
        <div class="form-group">
          <label for="card-cvv">CVV</label>
          <input type="text" class="form-control" id="card-cvv" placeholder="CVV" required>
        </div>
      </div>
      <div id="paypal-fields" style="display: none;">
        <div class="form-group">
          <label for="paypal-email">Endereço de email do PayPal</label>
          <input type="email" class="form-control" id="paypal-email" placeholder="email@example.com" required>
        </div>
      </div>
    </div>
    <script>
      // Selecione o formulário e os campos de pagamento
      const paymentForm = document.querySelector('#payment-form');
      const paymentFields = document.querySelector('#payment-fields');

      // Adicione um event listener para o formulário
      paymentForm.addEventListener('change', (event) => {
        // Selecione o método de pagamento selecionado
        const paymentMethod = event.target.value;

        // Mostre ou esconda os campos de pagamento com base no método selecionado
        if (paymentMethod === 'Paypal') {
          paymentFields.querySelector('#paypal-fields').style.display = 'block';
          paymentFields.querySelector('#credit-card-fields').style.display = 'none';
        } else {
          paymentFields.querySelector('#credit-card-fields').style.display = 'block';
          paymentFields.querySelector('#paypal-fields').style.display = 'none';
        }
        paymentFields.style.display = 'block';
      });
    </script>
  </div>
  <!-- /.col -->

 <div class="col-6">
  <p class="lead"style="color: white;">Quota Mensal</p>

  <div class="table-responsive">
    <table class="table">
      <tr>
        <th style="color: white;">Nº de Sócio:</th>
        <td style="color: white;"><?php echo $id_socio;?></td>
      </tr>
      <tr>
        <th style="color: white;">Valor Pago:</th>
        <td style="color: white;"><?php echo $quota_mensal;?> €</td>
      </tr>
      <tr>
        <th style="color: white;">Data Último Pagamento:</th>
        <?php $data_pagamento = '';?>
        <td style="color: white;"><?php echo $data_pagamento;?></td>
        
      </tr>
      <tr>
        <th style="color: white;">Total:</th>
        <td style="color: white;"><?php echo $quota_mensal;?> €</td>
      </tr>
    </table>
    <form id="payment-form" action="processar_pagamento.php" method="post" class="text-center" >
  <input type="hidden" name="id_socio" value="<?php echo $id_socio;?>">
  <input type="hidden" name="valor_pago" value="<?php echo $quota_mensal;?>">
  <input type="hidden" name="data_pagamento" value="<?php echo $data_pagamento;?>">
  
  <button type="submit" class="btn btn-success">
    <i class="far fa-credit-card"></i> Concluir Pagamento
  </button>

  <div class="text-center">
    <a href="invoice-print.php" rel="noopener" target="_blank" class="btn btn-default mx-auto">
      <i class="fas fa-download"></i> Gerar Fatura
    </a>
  </div>
</form>
  </div>
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

