<?php
include_once 'Conexao.class.php';
include_once 'Manager.class.php';

$manager = new Manager();

$id_socio = $_POST['id_socio'];

if (isset($id_socio) && !empty($id_socio)) {
    $manager->deleteSocio("socios", $id_socio);
    header("Location: atualizarsocios.php?product_deleted");
} else {
    echo "id_socio não está definido ou está vazio.";
}
?>
