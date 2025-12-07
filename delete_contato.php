<?php
include_once 'Conexao.class.php';
include_once 'Manager.class.php';

$manager = new Manager();

$id = $_POST['id'];

if (isset($id) && $id!== 0) {
    $manager->deleteMensagem("mensagens_contato", $id);
    header("Location: listacontactos.php?product_deleted");
} else {
    echo "id não está definido ou está vazio.";
}
