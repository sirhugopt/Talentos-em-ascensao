<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Talentos em Ascensão</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<style>
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
    $sql_update = "UPDATE pagamento_quotas SET status_quotas = 'pago', data_ultimo_pagamento = CURRENT_DATE WHERE id_socio = $id_socio";
    if ($conn->query($sql_update) === TRUE) {
      echo "Pagamento registrado com sucesso.";

      // Verificar se as quotas estão atrasadas para o próximo mês
      $mes_atual = date('m');
      $ano_atual = date('Y');

      // Obter o mês e o ano do último pagamento
      $sql_last_payment_date = "SELECT MONTH(data_ultimo_pagamento) AS mes, YEAR(data_ultimo_pagamento) AS ano FROM pagamento_quotas WHERE id_socio = $id_socio";
      $result_last_payment_date = $conn->query($sql_last_payment_date);
    }
  }
}

  ?>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
           <img src="dist/img/5.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8"> Talentos em Ascensão
                    <small class="float-right">Data: <?= date_format($dueDate, 'm/d/Y');?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
<div class="col-sm-4 invoice-col">
                  De
                  <address>
                    <strong>Talentos em Ascensão.</strong><br>
                   Rua São Francisco Xavier, Alto do Forte,<br>
                    2635-195 Rio de Mouro<br>
                    Telemóvel: +351 967 845 634<br>
                    Email: talentosemascencao@afl.pt
                  </address>
                </div>
      <!-- /.col -->
                <div class="col-sm-4 invoice-col">
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
 <div class="col-sm-4 invoice-col">
  <b>Fatura #<?= sprintf("%06d", $invoiceNumber);?></b><br>

  <b>ID do Pedido:</b> <?= $orderId;?><br>
  <b>Data de Pagamento:</b> <?= date_format($dueDate, 'm/d/Y');?><br>
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
         <tr>
    <th>Quantidade</th>
    <th>Quota Mensal</th>
    <th>Total</th>
  </tr>
</thead>
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
?>
  <tr>
    <td>1</td>
    <td>1 Mês</td>
    <td><?= $quota_mensal?> €</td>
   <tr>
   
  </tr>
</tbody>
                  </table>
             <div class="row">
  <!-- accepted payments column -->
  
  <!-- /.col -->

 <div class="col-6">
  <p class="lead">Valor Devido  <?= date_format($dueDate, 'm/d/Y');?></p>

  <div class="table-responsive">
    <table class="table">
      <tr>
        <th>Nº Sócio:</th>
        <td><?php echo $id_socio;?></td>
      </tr>
      <tr>
        <th>Valor Pago:</th>
        <td><?php echo $quota_mensal;?> €</td>
      </tr>
      <tr>
        <th>Data Último Pagamento:</th>
        <td><?php echo isset($data_pagamento)? $data_pagamento : 'Não há registro';?></td>
      </tr>
      <tr>
        <th>Total:</th>
        <td><?php echo $quota_mensal;?> €</td>
      </tr>
    </table>
    <form id="payment-form" action="processar_pagamento.php" method="post" class="text-center">
      <input type="hidden" name="id_socio" value="<?php echo $id_socio;?>">
      <input type="hidden" name="valor_pago" value="<?php echo $quota_mensal;?>">
      <input type="hidden" name="data_ultimo_pagamento" value="<?php echo $data_pagamento;?>">
     
      </div>
    </form>
  </div>
</div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
