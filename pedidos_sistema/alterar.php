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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pedidos_sistema SET problema=%s,solucao=%s, observacoes=%s WHERE id=%s",
                       GetSQLValueString($_POST['problema'], "text"),
					   GetSQLValueString($_POST['solucao'], "text"),				
					   GetSQLValueString($_POST['observacoes'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=pedidos_sistema";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$id = $_GET['id'];
mysql_select_db($database_conn, $conn);
$query_seleciona_pedidos_sistema = "SELECT * FROM pedidos_sistema WHERE id='$id'";
$seleciona_pedidos_sistema = mysql_query($query_seleciona_pedidos_sistema, $conn) or die(mysql_error());
$row_seleciona_pedidos_sistema = mysql_fetch_assoc($seleciona_pedidos_sistema);
$totalRows_seleciona_pedidos_sistema = mysql_num_rows($seleciona_pedidos_sistema);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>


<table width="100%">
  <tr>
    <th>ALTERA PEDIDOS DO SISTEMA</th>
  </tr>
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="6%" align="right" nowrap="nowrap">ID:</td>
      <td width="94%"><?php echo $row_seleciona_pedidos_sistema['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td valign="top" nowrap="nowrap">PROBLEMA:</td>
      <td><textarea name="problema" cols="100" rows="7" id="problema"><?php echo htmlentities($row_seleciona_pedidos_sistema['problema'], ENT_COMPAT); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td valign="top" nowrap="nowrap">SOLUÇÃO:</td>
      <td><textarea name="solucao" cols="100" rows="7" id="solucao"><?php echo htmlentities($row_seleciona_pedidos_sistema['solucao'], ENT_COMPAT ); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">OBSERVAÇÕES:</td>
      <td><textarea name="observacoes" cols="100" rows="7"><?php echo htmlentities($row_seleciona_pedidos_sistema['observacoes'], ENT_COMPAT ); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input name="Entrar" type="submit" id="Entrar" value="CONFIRMAR" />
       <input name="Entrar" type="button" class="btn1" id="Entrar" onclick="closeMessage()" value="CANCELAR"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_seleciona_pedidos_sistema['id']; ?>" />
</form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($seleciona_pedidos_sistema);
?>
