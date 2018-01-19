<?php
include("../Connections/conn.php");

$sql = "CREATE TABLE IF NOT EXISTS `formasdepagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipopo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `diascredito` int(11) NOT NULL,
  `comissao` decimal(10,2) NOT NULL,
  `taxa` decimal(10,2) NOT NULL,
  `juros` decimal(10,2) NOT NULL,
  `intervalo` int(11) NOT NULL,
  `parcelas` int(11) NOT NULL,
  `diafaturamento` int(11) NOT NULL,
  `gerareceber` char(1) NOT NULL DEFAULT 'S',
  `baixaautomatica` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

mysql_select_db($database_conn);

mysql_query($sql) or die (mysql_error()." Não foi possivel instalar tabela Formas de Pagamento ");
echo "Tabela <b>Formas de Pagamento</b> instalada com sucesso!";
?>