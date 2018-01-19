<?php
include("../Connections/conn.php");

$sql = "CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `endereco` varchar(60) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `fone` varchar(8) DEFAULT NULL,
  `celular` varchar(8) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `setor` varchar(30) DEFAULT NULL,
  `observacoes` text,
  `foto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

mysql_select_db($database_conn);

mysql_query($sql) or die (mysql_error()." Não foi possivel instalar tabela profissionais ");
echo "Tabela <b>Funcionarios</b> instalada com sucesso!";
?>