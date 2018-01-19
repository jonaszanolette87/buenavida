<?php require_once('../Connections/conn.php'); 

include ("../funcoes/funcoes.php");?>
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
  $insertSQL = sprintf("INSERT INTO contasapagar (id, datacadastro, id_fornecedor, 
  id_formadepagamento,  valor, historico, valortotal, datapagamento, id_contadespesa, 
  historico_despesa, id_contacaixabanco) VALUES (%s, %s, %s, %s, %s, 
  %s, %s, %s, %s, %s, 
  %s)",
                       GetSQLValueString($_POST['id'], "int"),                       
                       GetSQLValueString(datausa($_POST['datacadastro']), "date"),
                      
                       GetSQLValueString($_POST['id_fornecedor'], "int"),     
	                   GetSQLValueString($_POST['id_formadepagamento'], "int"),                      
     
	                   GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['historico'], "text"),
                       GetSQLValueString($_POST['valortotal'], "text"),
                       GetSQLValueString(datausa($_POST['datapagamento']), "date"),
                       GetSQLValueString($_POST['id_contadespesa'], "int"),
     
	                   GetSQLValueString($_POST['historico_despesa'], "text"),
                       GetSQLValueString($_POST['id_contacaixabanco'], "int")
                      );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?t=contasapagar";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);

mysql_select_db($database_conn, $conn);
$query_seleciona_contadespesa = "SELECT *  FROM planodecontas pc 

			

WHERE tipo=2";
$seleciona_contadespesa = mysql_query($query_seleciona_contadespesa, $conn) or die(mysql_error());
$row_seleciona_contadespesa = mysql_fetch_assoc($seleciona_contadespesa);
$totalRows_seleciona_contadespesa = mysql_num_rows($seleciona_contadespesa);



mysql_select_db($database_conn, $conn);
$query_seleciona_contacaixa = "SELECT * FROM planodecontas WHERE tipo=1";
$seleciona_contacaixa = mysql_query($query_seleciona_contacaixa, $conn) or die(mysql_error());
$row_seleciona_contacaixa = mysql_fetch_assoc($seleciona_contacaixa);
$totalRows_seleciona_contacaixa = mysql_num_rows($seleciona_contacaixa);

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
</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <th width="38"><img src="img/3.gif" alt="" width="28" height="28" /></th>
    <th width="1161" class="Titulo16">CADASTRA CONTAS A PAGAR:</th>
    <th width="36" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" alt="fechar" width="25" height="25" border="0" /></a></th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both" />
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="19%" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="25%">&nbsp;</td>
      <td width="16%">&nbsp;</td>
      <td width="40%">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DATA CADASTRO:</td>
      <td><input type="text" name="datacadastro" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FORNECEDOR:</td>
      <td><label for="datavencimento"></label>
     
        <select name="id_fornecedor" id="id_fornecedor">
         <option></option>
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
      <td>FORMA DE PAGAMENTO:</td>
      <td><label for="id_formadepagamento"></label>
      
        <select name="id_formadepagamento" id="id_formadepagamento">
      <option></option>
      
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_formasdepagamento['id']?>"><?php echo $row_seleciona_formasdepagamento['nome']?></option>
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
      <td nowrap="nowrap" align="right">VALOR TOTAL:</td>
      <td><input type="text" name="valor" value="" size="32" /></td>
      <td>HISTORICO DA DESPESA:</td>
      <td><input type="text" name="historico_despesa" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4">
      
      <iframe width="950px" height="300px" frameborder="0" src="../contasapagar_pagamento/index.php"></iframe>
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="CADASTRAR" />
      <input type="button" class="btn1" onclick="closeMessage()" value="CANCELAR" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($seleciona_fornecedores);

mysql_free_result($seleciona_contadespesa);

mysql_free_result($seleciona_bancos);

mysql_free_result($seleciona_contacaixa);

mysql_free_result($seleciona_formasdepagamento);
?>
