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
  $updateSQL = sprintf("UPDATE contasareceber SET  datacadastro=%s,  id_cliente=%s, id_cartao=%s,  valor=%s, historico=%s, valortotal=%s, datapagamento=%s, id_contareceita=%s, historico_receita=%s, id_contacaixabanco=%s WHERE id=%s",
                       GetSQLValueString($_POST['noc'], "text"),
                       GetSQLValueString(datausa($_POST['datacadastro']), "date"),                       
                       GetSQLValueString($_POST['id_cliente'], "int"),
                       GetSQLValueString($_POST['id_cartao'], "int"),                       
                       GetSQLValueString($_POST['valor'], "text"),
					   
                       GetSQLValueString($_POST['historico'], "text"),
                       GetSQLValueString($_POST['valortotal'], "text"),
                       GetSQLValueString(datausa($_POST['datapagamento']), "date"),
                       GetSQLValueString($_POST['id_contareceita'], "int"),
                       GetSQLValueString($_POST['historico_receita'], "text"),
					   
                       GetSQLValueString($_POST['id_contacaixabanco'], "int"),                      
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=contasareceber";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_contasareceber = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_contasareceber = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_contasareceber = sprintf("SELECT * FROM contasareceber WHERE id = %s", GetSQLValueString($colname_seleciona_contasareceber, "int"));
$seleciona_contasareceber = mysql_query($query_seleciona_contasareceber, $conn) or die(mysql_error());
$row_seleciona_contasareceber = mysql_fetch_assoc($seleciona_contasareceber);
$totalRows_seleciona_contasareceber = mysql_num_rows($seleciona_contasareceber);

mysql_select_db($database_conn, $conn);
$query_seleciona_clientes = "SELECT * FROM clientes";
$seleciona_clientes = mysql_query($query_seleciona_clientes, $conn) or die(mysql_error());
$row_seleciona_clientes = mysql_fetch_assoc($seleciona_clientes);
$totalRows_seleciona_clientes = mysql_num_rows($seleciona_clientes);



mysql_select_db($database_conn, $conn);
$query_seleciona_contareceita = "SELECT * FROM planodecontas WHERE tipo=3";
$seleciona_contareceita = mysql_query($query_seleciona_contareceita, $conn) or die(mysql_error());
$row_seleciona_contareceita = mysql_fetch_assoc($seleciona_contareceita);
$totalRows_seleciona_contareceita = mysql_num_rows($seleciona_contareceita);

mysql_select_db($database_conn, $conn);
$query_seleciona_contacaixabanco = "SELECT * FROM planodecontas WHERE tipo=1";
$seleciona_contacaixabanco = mysql_query($query_seleciona_contacaixabanco, $conn) or die(mysql_error());
$row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco);
$totalRows_seleciona_contacaixabanco = mysql_num_rows($seleciona_contacaixabanco);

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
    <th width="1161" class="Titulo16">ALTERA CONTAS A RECEBER:</th>
    <th width="36" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" alt="fechar" width="25" height="25" border="0" /></a></th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both" />
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="15%" align="right" nowrap="nowrap">ID:</td>
      <td width="18%"><?php echo $row_seleciona_contasareceber['id']; ?></td>
      <td width="17%">&nbsp;</td>
      <td width="50%">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DATA CADASTRO:</td>
      <td><input type="date" name="datacadastro" value="<?php echo htmlentities($row_seleciona_contasareceber['datacadastro'], ENT_COMPAT, 'utf-8'); ?>" size="32" id="datacadastro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CLIENTE:</td>
      <td>
        <select name="id_cliente" id="id_cliente">
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_clientes['id']?>"<?php if (!(strcmp($row_seleciona_clientes['id'], $row_seleciona_contasareceber['id_cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_clientes['nome']?></option>
          <?php
} while ($row_seleciona_clientes= mysql_fetch_assoc($seleciona_clientes));
  $rows = mysql_num_rows($seleciona_clientes);
  if($rows > 0) {
      mysql_data_seek($seleciona_clientes, 0);
	  $row_seleciona_clientes= mysql_fetch_assoc($seleciona_clientes);
  }
?>
      </select></td>
      <td>CARTÃO:</td>
      <td>
      
        <select name="id_cartao" id="id_cartao">
        
        <option value="" <?php if (!(strcmp("", $row_seleciona_contasareceber['id_cartao']))) {echo "selected=\"selected\"";} ?>></option>
      
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_cartoes['id']?>"
		  
		  <?php if (!(strcmp($row_seleciona_cartoes['id'], $row_seleciona_contasareceber['id_cartao']))) {echo "selected=\"selected\"";} ?>>
		  <?php echo $row_seleciona_cartoes['nome']?>
          
          </option>
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
      <td><input name="valortotal" type="text" id="valortotal" value="<?php echo htmlentities($row_seleciona_contasareceber['valortotal'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>HISTORICO:</td>
      <td><input type="text" name="historico" value="<?php echo htmlentities($row_seleciona_contasareceber['historico'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4"><iframe width="950px" height="300px" frameborder="0" src="../contasareceber_recebimento/index.php?id_contasareceber=<?php echo $row_seleciona_contasareceber['id']?>"></iframe></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td colspan="3"><input type="submit" value="CONFIRMAR" />
      <input type="button" class="btn1" onclick="closeMessage()" value="CANCELAR" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_seleciona_contasareceber['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($seleciona_contasareceber);

mysql_free_result($seleciona_clientes);

mysql_free_result($seleciona_contareceita);

mysql_free_result($seleciona_contacaixabanco);

mysql_free_result($seleciona_cartoes);
?>
