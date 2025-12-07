<?php
function base(){
  $conn = new Mysqli("localhost","sql_hugo_igr05_p", "8ABjCGmh6HA782wJ", "sql_hugo_igr05_p");
  if($conn->connect_error!=0){
    echo "Ocorreu um erro no acesso à base de dados" . $conn->connect_error;
    exit();
  }
  return $conn;
}

?>