<?php 
require_once('../Connections/conn.php');

mysql_select_db($database_conn, $conn);

$query_zera_produtos1 = "UPDATE produtos SET precodevenda='' ";
$query_zera_produtos2 = "UPDATE produtos SET tabela2='' ";
$query_zera_produtos3 = "UPDATE produtos SET vendadireta='' ";

$zera_produtos1 = mysql_query($query_zera_produtos1, $conn) or die(mysql_error());
$zera_produtos2 = mysql_query($query_zera_produtos2, $conn) or die(mysql_error());
$zera_produtos3 = mysql_query($query_zera_produtos3, $conn) or die(mysql_error());


echo "FORAM APAGADOS OS PREÇOS VENDA - ";
echo "FORAM APAGADOS OS PREÇOS TABELA2 - ";
echo "FORAM APAGADOS OS PREÇOS VENDA DIRETA - ";

echo "<script type='text/javascript'> alert('PREÇOS APAGADOS com sucesso');</script>";

?>