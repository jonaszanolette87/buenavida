<?php 
require_once('../Connections/conn.php');


$dataatual = date('Y-m-d'); 
mysql_select_db($database_conn, $conn);
$query_zera_produtos1 = "UPDATE configuracoes SET data = '$dataatual' WHERE id=1 ";


$zera_produtos1 = mysql_query($query_zera_produtos1, $conn) or die(mysql_error());



echo "FORAM APAGADOS OS PREÇOS VENDA";

echo "<script type='text/javascript'> alert('DATA ATUALIZADA com sucesso');</script>";
f
?>