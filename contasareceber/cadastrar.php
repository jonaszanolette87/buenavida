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
  $insertSQL = sprintf("INSERT INTO contasareceber (id,  datacadastro,  id_cliente, 
  id_cartao, historico, valortotal, id_contareceita, 
  historico_receita, id_contacaixabanco) VALUES (%s, %s, %s, %s, %s, 
  %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),                      
                       GetSQLValueString($_POST['datacadastro'], "date"),                       
                       GetSQLValueString($_POST['id_cliente'], "int"),     
	                   GetSQLValueString($_POST['id_cartao'], "int"),                     
                       GetSQLValueString($_POST['historico'], "text"),
					   
                       GetSQLValueString($_POST['valortotal'], "text"),                      
                       GetSQLValueString($_POST['id_contareceita'], "int"),     
	                   GetSQLValueString($_POST['historico_receita'], "text"),					   
                       GetSQLValueString($_POST['id_contacaixabanco'], "int")
                       
                      );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?t=contasareceber";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_clientes = "SELECT * FROM clientes";
$seleciona_clientes = mysql_query($query_seleciona_clientes, $conn) or die(mysql_error());
$row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
$totalRows_seleciona_clientes = mysql_num_rows($seleciona_clientes);

mysql_select_db($database_conn, $conn);
$query_seleciona_contareceita = "SELECT * FROM planodecontas pc WHERE tipo=3";
$seleciona_contareceita = mysql_query($query_seleciona_contareceita, $conn) or die(mysql_error());
$row_seleciona_contareceita = mysql_fetch_assoc($seleciona_contareceita);
$totalRows_seleciona_contareceita = mysql_num_rows($seleciona_contareceita);

mysql_select_db($database_conn, $conn);
$query_seleciona_contacaixa = "SELECT * FROM planodecontas WHERE tipo=1";
$seleciona_contacaixa = mysql_query($query_seleciona_contacaixa, $conn) or die(mysql_error());
$row_seleciona_contacaixa = mysql_fetch_assoc($seleciona_contacaixa);
$totalRows_seleciona_contacaixa = mysql_num_rows($seleciona_contacaixa);

mysql_select_db($database_conn, $conn);
$query_seleciona_cartoes = "SELECT * FROM cartoes";
$seleciona_cartoes = mysql_query($query_seleciona_cartoes, $conn) or die(mysql_error());
$row_seleciona_cartoes = mysql_fetch_assoc($seleciona_cartoes);
$totalRows_seleciona_cartoes = mysql_num_rows($seleciona_cartoes);

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
    <th width="1161" class="Titulo16">CADASTRA CONTAS A RECEBER:</th>
    <th width="36" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" alt="fechar" width="25" height="25" border="0" /></a></th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both" />
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="18%" align="right" nowrap="nowrap">DATA CADASTRO:</td>
      <td width="20%"><input type="date" name="datacadastro" value="" size="32" /></td>
      <td width="20%">&nbsp;</td>
      <td width="42%">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CLIENTE:</td>
      <td><label for="datavencimento"></label>
     
        <select name="id_cliente" id="id_cliente">
         <option></option>
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_clientes['id']?>"><?php echo $row_seleciona_clientes['nome']?></option>
          <?php
} while ($row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes));
  $rows = mysql_num_rows($seleciona_clientes);
  if($rows > 0) {
      mysql_data_seek($seleciona_clientes, 0);
	  $row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
  }
?>
      </select></td>
      <td>CARTÃO:</td>
      <td>
      
        <select name="id_cartao" id="id_cartao">
      <option></option>
      
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_cartoes['id']?>"><?php echo $row_seleciona_cartoes['nome']?></option>
          <?php 
} while ($row_seleciona_cartoes = mysql_fetch_assoc($seleciona_cartoes));
  $rows = mysql_num_rows($seleciona_cartoes);
  if($rows > 0) {
      mysql_data_seek($seleciona_cartoes, 0);
	  $row_seleciona_cartoes = mysql_fetch_assoc($seleciona_cartoes);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">VALOR TOTAL:</td>
      <td><input type="text" name="valortotal" value="" size="32" id="valortotal" /></td>
      <td>HISTORICO:</td>
      <td><input type="text" name="historico" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4"><iframe width="950px" height="300px" frameborder="0" src="../contasareceber_recebimento/index.php"></iframe></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td colspan="3"><input type="submit" value="CADASTRAR" />
      <input type="button" class="btn1" onclick="closeMessage()" value="CANCELAR" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($seleciona_clientes);

mysql_free_result($seleciona_contareceita);

mysql_free_result($seleciona_contacaixa);

mysql_free_result($seleciona_cartoes);
?>
