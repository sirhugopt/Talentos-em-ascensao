<?php  

 

class conexao {

 

    public static $instance;

 

    public static function get_instance() { //get_intance é uma função que vai executar o que está em baixo

        if(!isset(self::$instance)) { //!isset é se não estiver inserido

            self::$instance = new PDO("mysql:host=localhost;dbname=sql_hugo_igr05_p;", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); //Se não conectar, vai tentar novamente

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //atribuir os erros e as exceções à variável

        }

 

        return self::$instance;

 

    }

 

}

 

?>