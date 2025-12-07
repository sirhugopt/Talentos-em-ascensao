<?php  

class Manager extends conexao {    

    public function insertSocio($table, $data) {
        $pdo = parent::get_instance();
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        
        $statement = $pdo->prepare($sql);
    
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
    
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Erro ao inserir cliente: " . $e->getMessage();
            // Ou você pode logar o erro, redirecionar para uma página de erro, etc.
        }
    }
    public function   insertLoja($table, $data) {
        $pdo = parent::get_instance();
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        
        $statement = $pdo->prepare($sql);
    
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
    
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Erro ao inserir cliente: " . $e->getMessage();
            // Ou você pode logar o erro, redirecionar para uma página de erro, etc.
        }
    }
  
    public function listSocio($table) {
        $pdo = parent::get_instance();
        $sql = "SELECT * FROM $table ORDER BY Nome_Completo ASC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listProdutos($table) {
        $pdo = parent::get_instance();
        $sql = "SELECT * FROM $table ORDER BY nome_produto ASC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function deleteSocio($table, $id_socio){
        $pdo = parent::get_instance();
        $sql = "DELETE FROM $table WHERE id_socio = :id_socio";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id_socio", $id_socio, PDO::PARAM_INT);
        $statement->execute();
    }
    
     public function deleteMensagem($table, $id_socio){
    $pdo = parent::get_instance();
    $sql = "DELETE FROM $table WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":id", $id_socio, PDO::PARAM_INT);
    $statement->execute();
}


    public function getInfo($table, $id_socio) {
        $pdo = parent::get_instance();
        $sql = "SELECT * FROM $table WHERE id_socio = :id_socio";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id_socio", $id_socio, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoprod($table, $id) {
        $pdo = parent::get_instance();
        $sql = "SELECT * FROM $table WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateSocio($table, $data, $id_socio) {
        $pdo = parent::get_instance();
    
        $set_values = [];
        foreach ($data as $key => $value) {
            // Evite adicionar colunas que não existem na tabela
            $stmtCheck = $pdo->query("DESCRIBE $table");
            $columns = $stmtCheck->fetchAll(PDO::FETCH_COLUMN);
            if (in_array($key, $columns)) {
                $set_values[] = "$key=:$key";
            }
        }
    
        $set_values = implode(", ", $set_values);
        $sql = "UPDATE $table SET $set_values WHERE id_socio = :id_socio";
    
        try {
            $statement = $pdo->prepare($sql);
            foreach ($data as $key => $value) {
                // Apenas associe valores para as colunas existentes
                if (in_array($key, $columns)) {
                    $statement->bindValue(":$key", $value, PDO::PARAM_STR);
                }
            }
            $statement->bindValue(":id_socio", $id_socio, PDO::PARAM_INT);
            $statement->execute();
            echo "Statement executado com sucesso.";
        } catch (PDOException $e) {
            // Em caso de erro, imprima a mensagem de erro
            echo "Erro ao executar o statement: " . $e->getMessage();
        }
    }
    public function updateImage($table, $id_socio, $imagem) {
        $pdo = parent::get_instance();
        $sql = "UPDATE $table SET imagem = :imagem WHERE id_socio = :id_socio";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":imagem", $imagem, PDO::PARAM_STR);
        $statement->bindValue(":id_socio", $id_socio, PDO::PARAM_INT);
        
        try {
            $statement->execute();
            echo "Imagem atualizada com sucesso.";
        } catch (PDOException $e) {
            echo "Erro ao atualizar a imagem: " . $e->getMessage();
        }
    }
    public function updateProd($table, $data, $id) {
        $pdo = parent::get_instance();
    
        $set_values = [];
        foreach ($data as $key => $value) {
            // Evite adicionar colunas que não existem na tabela
            $stmtCheck = $pdo->query("DESCRIBE $table");
            $columns = $stmtCheck->fetchAll(PDO::FETCH_COLUMN);
            if (in_array($key, $columns)) {
                $set_values[] = "$key=:$key";
            }
        }
    
        $set_values = implode(", ", $set_values);
        $sql = "UPDATE $table SET $set_values WHERE id = :id";
    
        try {
            $statement = $pdo->prepare($sql);
            foreach ($data as $key => $value) {
                // Apenas associe valores para as colunas existentes
                if (in_array($key, $columns)) {
                    $statement->bindValue(":$key", $value, PDO::PARAM_STR);
                }
            }
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            echo "Statement executado com sucesso.";
        } catch (PDOException $e) {
            // Em caso de erro, imprima a mensagem de erro
            echo "Erro ao executar o statement: " . $e->getMessage();
        }
    }
    

    public function listQuotas($table) {
        $pdo = parent::get_instance();
        $sql = "SELECT * FROM $table ORDER BY data_pagamento DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
      public function listMensagensContato($table = 'mensagens_contato') {
    $pdo = parent::get_instance();
    $sql = "SHOW TABLES LIKE '$table'";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $sql = "SELECT * FROM $table ORDER BY nome DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        throw new Exception("Table $table does not exist");
    }
}
  public function listPagamentoQuotas($table = 'pagamento_quotas') {
    $pdo = parent::get_instance();
    $sql = "SHOW TABLES LIKE '$table'";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $sql = "SELECT * FROM $table ORDER BY id_pagamento DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        throw new Exception("Table $table does not exist");
    }
}

    public function deleteQuota($table, $id_pagamento){
        $pdo = parent::get_instance();
        $sql = "DELETE FROM $table WHERE id_pagamento = :id_pagamento";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id_pagamento", $id_pagamento, PDO::PARAM_INT);
        $statement->execute();
    }

    public function updateQuota($table, $data, $id_quota) {
        $pdo = parent::get_instance();
    
        $set_values = [];
        foreach ($data as $key => $value) {
            // Evite adicionar colunas que não existem na tabela
            $stmtCheck = $pdo->query("DESCRIBE $table");
            $columns = $stmtCheck->fetchAll(PDO::FETCH_COLUMN);
            if (in_array($key, $columns)) {
                $set_values[] = "$key=:$key";
            }
        }
    
        $set_values = implode(", ", $set_values);
        $sql = "UPDATE $table SET $set_values WHERE id_quota = :id_quota";
    
        try {
            $statement = $pdo->prepare($sql);
            foreach ($data as $key => $value) {
                // Apenas associe valores para as colunas existentes
                if (in_array($key, $columns)) {
                    $statement->bindValue(":$key", $value, PDO::PARAM_STR);
                }
            }
            $statement->bindValue(":id_quota", $id_quota, PDO::PARAM_INT);
            $statement->execute();
            echo "Statement executado com sucesso.";
        } catch (PDOException $e) {
            // Em caso de erro, imprima a mensagem de erro
            echo "Erro ao executar o statement: " . $e->getMessage();
        }
    }
}
