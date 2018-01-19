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

if ((isset($_POST["exclui"])) && ($_POST["exclui"] == "f3")) {



  $deleteSQL = sprintf("DELETE FROM vendedores WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());

  $deleteGoTo = "../inicio/principal.php?t=vendedores";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
$id = $_GET['id'];

mysql_select_db($database_conn, $conn);
$seleciona_vendedores = "SELECT * FROM vendedores WHERE id = '$id'";
$vendedores = mysql_query($seleciona_vendedores , $conn) or die(mysql_error());
$row_vendedores = mysql_fetch_assoc($vendedores);
$totalRows_vendedores = mysql_num_rows($vendedores);
mysql_free_result($vendedores);
?>
<form name="f3" id="f3" method="post" action="../vendedores/excluir.php">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="30"><img src="../imagens/vendedores.jpg" alt="" width="30" height="30" align="absmiddle" /></th>
      <th ><strong><em><font >EXCLUIR VENDEDORES:</font></em></strong></th>
    </tr>
  </table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both"><table width="100%"  border="0" cellpadding="1" cellspacing="2">
  <tr>
    <td>      Confirma a Exclus&atilde;o do Vendedores:<br>
<strong> <?php echo $row_vendedores['nome']?></strong><br><br>
	      <input name="exclui" type="hidden" id="exclui" value="f3">
	  <input name="id" type="hidden" id="id" value="<?php echo $row_vendedores['id']?>">	</td>
    </tr>
  <tr>
    <td>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="Entrar" type="submit" class="btn1" id="Entrar" value="Confirmar"></td>
    <td>&nbsp;</td>
    <td><input name="Entrar" type="button" class="btn1" id="Entrar" onclick="closeMessage()" value="Cancelar"></td>
  </tr>
</table>	</td>
    </tr>
</table>
</form>
</body>
</html>