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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1_altvendedores")) {
  $updateSQL = sprintf("UPDATE vendedores SET nome=%s, porcentagem=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['porcentagem'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
 
  $updateGoTo = "../inicio/principal.php?t=vendedores";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_vendedores = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_vendedores = $_GET['id'];
}

$id = $_GET['id'];

mysql_select_db($database_conn, $conn);
$query_seleciona_vendedores = sprintf("SELECT * FROM vendedores WHERE id = %s", GetSQLValueString($colname_seleciona_vendedores, "int"));
$seleciona_vendedores = mysql_query($query_seleciona_vendedores, $conn) or die(mysql_error());
$row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores);
$totalRows_seleciona_vendedores = mysql_num_rows($seleciona_vendedores);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="47"><img src="../imagens/vendedores.jpg" alt="" width="30" height="30" align="absmiddle" /></th>
      <th width="833" class="Titulo16">ALTERA VENDEDORES:</th>
      <th width="36" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>&nbsp;
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_altvendedores" id="form1_altvendedores">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID:</td>
            <td><?php echo $row_seleciona_vendedores['id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NOME:</td>
            <td><input name="nome" type="text" id="nome" onkeyup="maiuscula(this.value)" value="<?php echo htmlentities($row_seleciona_vendedores['nome'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">PORCENTAGEM:</td>
            <td><input name="porcentagem" type="text" id="porcentagem" value="<?php echo htmlentities($row_seleciona_vendedores['porcentagem'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>
            
            
              <input name="id" type="hidden" id="id" value="<?php echo $row_seleciona_vendedores['id']?>" />
    <input name="id_permissao" type="hidden" id="id_permissao" value="<?php echo $row_permissoes['id']?>" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Confirmar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1_altvendedores" />
        <input type="hidden" name="id" value="<?php echo $row_seleciona_vendedores['id']; ?>" />
      </form>
   </td>
  </tr>
</table>

<script language='JavaScript' type='text/javascript'>
  document.form1_altvendedores.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_altvendedores;
campo.nome.value = campo.nome.value.toUpperCase();
}


</script>
</body>
</html>
<?php
mysql_free_result($seleciona_vendedores);
?>
