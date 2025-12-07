<?php
include_once 'Conexao.class.php';
include_once 'Manager.class.php';

$manager = new Manager();

$id_pagamento = $_POST['id_pagamento'];

if (isset($id_pagamento) && $id_pagamento!== 0) {
    $manager->deleteQuota("pagamento_quotas", $id_pagamento);
    header("Location: listaquotas.php?product_deleted");
} else {
    echo "id_pagamento não está definido ou está vazio.";
}
