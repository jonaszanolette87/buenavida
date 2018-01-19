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
$query_seleciona_fornecedores = "SELECT * FROM fornecedores";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);
?>

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<br />
<br />
<div id="rel_clientes">
  <p>RELATÓRIO DE CLIENTES</p>
  <hr>
    <br>
    
  <form id="form1" name="form1" action="../relatorios/clientes/clientes_paisagemhtml.php" method="post">
    FORNECEDOR: 
      <select name="id_fornecedor">
      <option value="">TODOS</option>
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
  
    <input type="submit" name="Enviar" id="Enviar" value="Buscar" />
  </form>
  <a href="../relatorios/clientes/clientes_paisagem.php" target="_blank"><br />
  </a></div>
<?php
mysql_free_result($seleciona_fornecedores);
?>
