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
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);
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


<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<br />
<br />
<div id="rel_clientes">
  <p>RELATÓRIO DE COMPRAS</p>
  <hr>
    <br>
    
  <form id="form1" name="form1" action="../relatorios/compras/compras_paisagem.php" method="post">
    <br />
PERÍODO :
<input type="text" name="data_inicial"  id="data_1" />
a
<label for="data_final"></label>
<input type="text" name="data_final"  id="data_2" />
<br />
FORNECEDOR:
<select name="id_fornecedor" id="id_fornecedor">
      <option value="">NENHUM</option>
      <?php
do {  
?>
      <option value="<?php echo $row_seleciona_fornecedores['id']?>"><?php echo $row_seleciona_fornecedores['nome']?></option>
      <?php
} while ($row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores));
  $rows = mysql_num_rows($seleciona_fornecedores);
  if($rows > 0) {
      mysql_data_seek($seleciona_fornecedores, 0);
	  $row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
  }
?>
    </select>
      <br />
      <br />
      
    <input type="submit" name="Enviar" id="Enviar" value="Buscar" />
  </form>
  <a href="../relatorios/compras/compras_paisagem.php" target="_blank"><br />
  </a></div>
<?php
mysql_free_result($seleciona_fornecedores);
?>
