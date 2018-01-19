<?php require_once('../Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn, $conn);
$query_seleciona_favorecidos = "SELECT * FROM favorecidos";
$seleciona_favorecidos = mysql_query($query_seleciona_favorecidos, $conn) or die(mysql_error());
$row_seleciona_favorecidos = mysql_fetch_assoc($seleciona_favorecidos);
$totalRows_seleciona_favorecidos = mysql_num_rows($seleciona_favorecidos);

mysql_select_db($database_conn, $conn);
$query_seleciona_bancos = "SELECT * FROM bancos";
$seleciona_bancos = mysql_query($query_seleciona_bancos, $conn) or die(mysql_error());
$row_seleciona_bancos = mysql_fetch_assoc($seleciona_bancos);
$totalRows_seleciona_bancos = mysql_num_rows($seleciona_bancos);

mysql_select_db($database_conn, $conn);
$query_seleciona_custodias = "SELECT * FROM custodias";
$seleciona_custodias = mysql_query($query_seleciona_custodias, $conn) or die(mysql_error());
$row_seleciona_custodias = mysql_fetch_assoc($seleciona_custodias);
$totalRows_seleciona_custodias = mysql_num_rows($seleciona_custodias);

mysql_select_db($database_conn, $conn);
$query_seleciona_sacados = "SELECT * FROM sacados";
$seleciona_sacados = mysql_query($query_seleciona_sacados, $conn) or die(mysql_error());
$row_seleciona_sacados = mysql_fetch_assoc($seleciona_sacados);
$totalRows_seleciona_sacados = mysql_num_rows($seleciona_sacados);
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

<link href="../calendario/_style/default.css" rel="stylesheet" type="text/css"/>
<link href="../calendario/_style/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../calendario/_scripts/jquery.js"></script>
<script type="text/javascript" src="../calendario/_scripts/jquery.click-calendario-1.0-min.js"></script>
<script type="text/javascript" src="../calendario/_scripts/exemplo-calendario.js"></script>


<script language="javascript" src="../js/mascaras.js"></script>



<script type="text/javascript">
	$(document).ready(function(){
		$("#telefone").mask("9999-9999");
		$("#cpf").mask("999.999.999-99");
		$("#cep").mask("99999-999");
		$("#data_incial").mask("99/99/9999");
		$("#data_final").mask("99/99/9999");
		
		
		$('#data_1').focus(function(){
		$(this).calendario({
			target:'#data_1'
			});
		});
	
	$('#data_2').focus(function(){
	$(this).calendario({
		target:'#data_2'
		});
	});
	
	});
</script>
<br /><br />

<div id="rel_clientes">
  <p>RELATÓRIO DE CARTOES</p><hr>
  <form id="form1" name="form1" method="post" action="../relatorios/cartoes/cartoes_paisagem.php?t=apagar">
   PERÍODO :
      <label for="data_incial"></label>
      &nbsp;&nbsp;&nbsp;
      <input type="text" name="data_inicial"  id="data_1" />
    a
    <label for="data_final"></label>
  <input type="text" name="data_final"  id="data_2" />
  <br />
<br />
      <br />
  <br />
      <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
    
</form>
</div>
<?php
mysql_free_result($seleciona_favorecidos);

mysql_free_result($seleciona_bancos);

mysql_free_result($seleciona_custodias);

mysql_free_result($seleciona_sacados);
?>
