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
  $insertSQL = sprintf("INSERT INTO hoteis (id, nome, email, contato, telefone, endereco, observacoes) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($_POST['contato'], "text"),
					   GetSQLValueString($_POST['telefone'], "text"),
					    GetSQLValueString($_POST['endereco'], "text"),
						GetSQLValueString($_POST['observacoes'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  


  $insertGoTo = "../inicio/principal.php?t=hoteis";
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
      <th width="40"><img src="../imagens/hoteis.jpg" alt="" width="30" height="30" align="absmiddle" /></th>
      <th width="1134" class="Titulo16">CADASTRAR HOTEIS:</th>
      <th width="149" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_cadhoteis" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NOME DO HOTEL:</td>
            <td><input name="nome" type="text" id="nome" value="" size="44" onkeyup="maiuscula(this.value)" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">EMAIL:</td>
            <td><input name="email" type="text" id="email" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">CONTATO:</td>
            <td><input name="contato" type="text" id="contato" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">TELEFONE:</td>
            <td><input name="telefone" type="text" id="telefone" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">ENDEREÇO:</td>
            <td><input name="endereco" type="text" id="endereco" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">OBSERVAÇÕES:</td>
            <td><input name="observacoes" type="text" id="observacoes" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Cadastrar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>

<script language='JavaScript' type='text/javascript'>
  document.form1_cadhoteis.nome.focus()
  
</script>
<script>


function maiuscula(valor) {
var campo=document.form1_cadhoteis;
campo.nome.value=campo.nome.value.toUpperCase();
}


</script>
</body>
</html>
