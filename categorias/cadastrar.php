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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1_cadcategorias")) {
  $insertSQL = sprintf("INSERT INTO categorias (id, nome, min_pax, max_pax, camas, metragem) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['min_pax'], "text"),
					   GetSQLValueString($_POST['max_pax'], "text"),
					   GetSQLValueString($_POST['camas'], "text"),
					   GetSQLValueString($_POST['metragem'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  

  $insertGoTo = "../inicio/principal.php?t=categorias";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/categorias.jpg" alt="" width="32" height="32" align="absmiddle" /></th>
      <th width="908" class="Titulo16">CADASTRA CATEGORIA:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_cadcategorias" id="form1_cadcategorias">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">NOME:</td>
            <td><input name="nome" type="text" id="nome" onkeyup="maiuscula(this.value)" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">MIN PAX:</td>
            <td><input name="min_pax" type="text" id="min_pax" onkeyup="maiuscula(this.value)" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">MAX PAX:</td>
            <td><input name="max_pax" type="text" id="max_pax" onkeyup="maiuscula(this.value)" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CAMAS:</td>
            <td><input name="camas" type="text" id="camas" onkeyup="maiuscula(this.value)" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">METRAGEM:</td>
            <td><input name="metragem" type="text" id="metragem" onkeyup="maiuscula(this.value)" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Cadastrar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1_cadcategorias" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>

<script language='JavaScript' type='text/javascript'>
  document.form1_cadcategorias.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_cadcategorias;
campo.nome.value=campo.nome.value.toUpperCase();

}


</script>

</body>
</html>
