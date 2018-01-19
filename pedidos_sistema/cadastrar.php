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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pedidos_sistema (id,problema,solucao,observacoes) VALUES (%s,%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['problema'], "text"), 
					   GetSQLValueString($_POST['solucao'], "text"),
                       GetSQLValueString($_POST['observacoes'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?t=pedidos_sistema";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  
  
  
  mysql_select_db($database_conn, $conn);
$query_seleciona_grupos = "SELECT * FROM grupos_manutencao ORDER BY nome";
$seleciona_grupos = mysql_query($query_seleciona_grupos, $conn) or die(mysql_error());
$row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos);
$totalRows_seleciona_grupos = mysql_num_rows($seleciona_grupos);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilo1.css" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%">
  <tr>
    <th><img src="../imagens/pedidos_sistema.jpg" alt="" width="30" height="30" hspace="2" align="absmiddle" />CADASTRA PEDIDOS DO SISTEMA</th>
  </tr>
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td width="11%" valign="top" nowrap="nowrap">PROBLEMA:</td>
            <td width="89%" valign="baseline"><textarea name="problema" cols="100" rows="7" id="problema"></textarea>
            </td>
          </tr>
          <tr valign="baseline">
            <td valign="top" nowrap="nowrap">SOLUCAO:</td>
            <td valign="baseline"><textarea name="solucao" cols="100" rows="7" id="solucao"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap">OBSERVAÇÕES:</td>
            <td valign="baseline"><textarea name="observacoes" cols="100" rows="7" id="observacoes"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input name="Entrar" type="submit" id="Entrar" value="CADASTRAR" />
          <input name="Entrar" type="button" class="btn1" id="Entrar" onclick="closeMessage()" value="CANCELAR"></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    </td>
  </tr>
</table>

</body>
</html>