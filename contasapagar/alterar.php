<?php require_once('../Connections/conn.php');

include("../funcoes/funcoes.php");
 ?>
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
  $updateSQL = sprintf("UPDATE contasapagar SET  datacadastro=%s,  id_fornecedor=%s, id_formadepagamento=%s, valor=%s, historico=%s,  datapagamento=%s, id_contadespesa=%s, historico_despesa=%s, id_contacaixabanco=%s WHERE id=%s",
                      
                       GetSQLValueString(datausa($_POST['datacadastro']), "date"),
                      
                       GetSQLValueString($_POST['id_fornecedor'], "int"),
                       GetSQLValueString($_POST['id_formadepagamento'], "int"),
                      
                      
                     
                       GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['historico'], "text"),
                      
                       GetSQLValueString(datausa($_POST['datapagamento']), "date"),
                       GetSQLValueString($_POST['id_contadespesa'], "int"),
                       GetSQLValueString($_POST['historico_despesa'], "text"),
                       GetSQLValueString($_POST['id_contacaixabanco'], "int"),
                       
                      
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=contasapagar";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_contasapagar = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_contasapagar = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_contasapagar = sprintf("SELECT * FROM contasapagar WHERE id = %s", GetSQLValueString($colname_seleciona_contasapagar, "int"));
$seleciona_contasapagar = mysql_query($query_seleciona_contasapagar, $conn) or die(mysql_error());
$row_seleciona_contasapagar = mysql_fetch_assoc($seleciona_contasapagar);
$totalRows_seleciona_contasapagar = mysql_num_rows($seleciona_contasapagar);

mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome ASC";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);

mysql_select_db($database_conn, $conn);
$query_seleciona_bancos = "SELECT * FROM bancos";
$seleciona_bancos = mysql_query($query_seleciona_bancos, $conn) or die(mysql_error());
$row_seleciona_bancos = mysql_fetch_assoc($seleciona_bancos);
$totalRows_seleciona_bancos = mysql_num_rows($seleciona_bancos);

mysql_select_db($database_conn, $conn);
$query_seleciona_contadespesa = "SELECT * FROM planodecontas WHERE tipo=2";
$seleciona_contadespesa = mysql_query($query_seleciona_contadespesa, $conn) or die(mysql_error());
$row_seleciona_contadespesa = mysql_fetch_assoc($seleciona_contadespesa);
$totalRows_seleciona_contadespesa = mysql_num_rows($seleciona_contadespesa);

mysql_select_db($database_conn, $conn);
$query_seleciona_contacaixabanco = "SELECT * FROM planodecontas WHERE tipo=1";
$seleciona_contacaixabanco = mysql_query($query_seleciona_contacaixabanco, $conn) or die(mysql_error());
$row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco);
$totalRows_seleciona_contacaixabanco = mysql_num_rows($seleciona_contacaixabanco);

mysql_select_db($database_conn, $conn);
$query_seleciona_formasdepagamento = "SELECT * FROM formasdepagamento";
$seleciona_formasdepagamento = mysql_query($query_seleciona_formasdepagamento, $conn) or die(mysql_error());
$row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
$totalRows_seleciona_formasdepagamento = mysql_num_rows($seleciona_formasdepagamento);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>



<script language="javascript" src="../js/mascaras.js"></script>



<script type="text/javascript">
	$(document).ready(function(){
		
		$("#datacadastro").mask("99/99/9999");
		$("#datavencimento").mask("99/99/9999");
		
	
	});
</script>

</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <th width="38"><img src="img/3.gif" alt="" width="28" height="28" /></th>
    <th width="1161" class="Titulo16">ALTERA CONTAS A PAGAR:</th>
    <th width="36" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" alt="fechar" width="25" height="25" border="0" /></a></th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both" />
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="15%" align="right" nowrap="nowrap">ID:</td>
      <td><?php echo $row_seleciona_contasapagar['id']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td width="26%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="44%">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DATA CADASTRO:</td>
      <td><input type="text" name="datacadastro" value="<?php echo htmlentities(databrasil($row_seleciona_contasapagar['datacadastro']), ENT_COMPAT, 'utf-8'); ?>" size="32" id="datacadastro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FORNECEDOR:</td>
      <td><label for="id_fornecedor"></label>
        <select name="id_fornecedor" id="id_fornecedor">
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_fornecedores['id']?>"<?php if (!(strcmp($row_seleciona_fornecedores['id'], $row_seleciona_contasapagar['id_fornecedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_fornecedores['nome']?></option>
          <?php
} while ($row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores));
  $rows = mysql_num_rows($seleciona_fornecedores);
  if($rows > 0) {
      mysql_data_seek($seleciona_fornecedores, 0);
	  $row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
  }
?>
      </select></td>
      <td>FORMA  PAGTO:</td>
      <td><label for="id_formadepagamento"></label>
        <select name="id_formadepagamento" id="id_formadepagamento">
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_formasdepagamento['id']?>"<?php if (!(strcmp($row_seleciona_formasdepagamento['id'], $row_seleciona_contasapagar['id_formadepagamento']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_formasdepagamento['nome']?></option>
          <?php
} while ($row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento));
  $rows = mysql_num_rows($seleciona_formasdepagamento);
  if($rows > 0) {
      mysql_data_seek($seleciona_formasdepagamento, 0);
	  $row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">VALOR:</td>
      <td><input type="text" name="valor" value="<?php echo htmlentities($row_seleciona_contasapagar['valor'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td> HISTORICO:</td>
      <td><input type="text" name="historico" value="<?php echo htmlentities($row_seleciona_contasapagar['historico'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="right" nowrap="nowrap"><iframe width="950px" height="300px" frameborder="0" src="../contasapagar_pagamento/index.php?id_contasapagar=<?php echo $row_seleciona_contasapagar['id']?>"></iframe></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td colspan="3"><input type="submit" value="CONFIRMAR" />
      <input type="button" class="btn1" onclick="closeMessage()" value="CANCELAR" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_seleciona_contasapagar['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($seleciona_contasapagar);

mysql_free_result($seleciona_fornecedores);

mysql_free_result($seleciona_bancos);

mysql_free_result($seleciona_contadespesa);

mysql_free_result($seleciona_contacaixabanco);

mysql_free_result($seleciona_formasdepagamento);
?>
