<?php 

  $conexao = mysqli_connect("localhost","root", "","sql_hugo_igr05_p");




  if ($conexao->connect_error) {

    die ("Falha a efetuar a ligação:".$conexao->connect_error);
  }
  // Filtra e valida o ID
  $id = filter_input(INPUT_GET, 'id' , FILTER_SANITIZE_SPECIAL_CHARS);
  // Prepara e executa a query para apagar o registro
  $queryApagar = $conexao->query("DELETE FROM loja WHERE id='$id'");
  // Verifica se algum registro foi afetado
  if(mysqli_affected_rows($conexao) > 0){
    header("Location:index.php");
  }

?>