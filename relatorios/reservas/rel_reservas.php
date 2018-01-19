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
$query_seleciona_quartos = "SELECT * FROM quartos";
$seleciona_quartos = mysql_query($query_seleciona_quartos, $conn) or die(mysql_error());
$row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
$totalRows_seleciona_quartos = mysql_num_rows($seleciona_quartos);



mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);
?>

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

<div id="rel_clientes">
  <p>RELATÓRIO DE RESERVAS</p>
  <hr>
    <br>
    
  <form id="form1" name="form1" action="../relatorios/reservas/reservas_paisagemhtml.php" method="post">
  	
    <p><br>
    </p>
    <table width="100%" border="0">
      <tbody>
        <tr>
          <td width="13%">DATA INICIAL:            </td>
          <td width="87%"><input name="data_inicial" type="date" id="data_inicial">
            a DATA FINAL:
          <input name="data_final" type="date" id="data_final"></td>
        </tr>
        <tr>
          <td> STATUS: </td>
          <td><select name="status" id="status">
            <option value="" selected="selected">TODOS</option>
            <option value="PRE RESERVADO" >PRE RESERVADO</option>
            <option value="RESERVADO">RESERVADO</option>
            <option value="HOSPEDADO">HOSPEDADO</option>
            <option value="LIMPAR">LIMPAR</option>
            <option value="CANCELADO">CANCELADO</option>
          </select></td>
        </tr>
        <tr>
          <td>FORNECEDOR:</td>
          <td><select name="id_fornecedor" id="id_fornecedor">
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
          </select></td>
        </tr>
        <tr>
          <td>APT:</td>
          <td><select name="apt">
            <option value="">TODOS</option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_quartos['id']?>"><?php echo $row_seleciona_quartos['nome']?></option>
            <?php
} while ($row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos));
  $rows = mysql_num_rows($seleciona_quartos);
  if($rows > 0) {
      mysql_data_seek($seleciona_quartos, 0);
	  $row_seleciona_quartos = mysql_fetch_assoc($seleciona_quartos);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="Enviar" id="Enviar" value="Buscar" /></td>
        </tr>
      </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><br>
      <br>
      <br>
    </p>
  </form>
  <a href="../relatorios/reservas/reservas_paisagem.php" target="_blank"><br />
  </a></div>
<?php
mysql_free_result($seleciona_quartos);
?>