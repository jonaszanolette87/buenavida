<?php
include("../Connections/conn.php");

$sql = "CREATE TABLE `movdiario` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`datacadastro` DATE NOT NULL ,
`tipo` CHAR( 1 ) NOT NULL ,
`valor` DECIMAL( 10, 2 ) NOT NULL ,
`historico` VARCHAR( 150 ) NOT NULL ,
`id_contadespesareceita` INT NOT NULL ,
`operacao` CHAR( 1 ) NOT NULL ,
`id_contacaixabanco` INT NOT NULL ,
`saldoatual` DECIMAL( 10, 2 ) NOT NULL ,
`id_centrodecusto` INT NOT NULL
) ENGINE = InnoDB;";

mysql_select_db($database_conn);

mysql_query($sql) or die (mysql_error()." Não foi possivel instalar tabela movdiario ");
echo "Tabela <b>movdiario</b> instalada com sucesso!";
?>