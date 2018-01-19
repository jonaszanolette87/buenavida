<?php require_once('../Connections/conn.php'); 

include('../funcoes/funcoes.php');?>
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
$valor_anterior = $row_seleciona_movimentodiario['valor'];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE movimentodiario SET datacadastro=%s, tipo=%s, valor=%s, historico=%s, id_contadespesareceita=%s, operacao=%s, id_contacaixabanco=%s, saldoatual=%s, id_centrodecusto=%s WHERE id=%s",
                       GetSQLValueString(datausa($_POST['datacadastro']), "date"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($_POST['historico'], "text"),
                       GetSQLValueString($_POST['id_contadespesareceita'], "int"),
                       GetSQLValueString($_POST['operacao'], "text"),
                       GetSQLValueString($_POST['id_contacaixabanco'], "int"),
                       GetSQLValueString($_POST['saldoatual'], "double"),
                       GetSQLValueString($_POST['id_centrodecusto'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  $resto =  $_POST['valor'] + $valor_anterior;
  
  atualizasaldodaconta($_POST['id_contadespesareceita'],$resto,$_POST['operacao']);

  $updateGoTo = "../inicio/principal.php?pg=movimentodiario";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_movimentodiario = "SELECT * FROM movimentodiario ";
$seleciona_movimentodiario = mysql_query($query_seleciona_movimentodiario, $conn) or die(mysql_error());
$row_seleciona_movimentodiario = mysql_fetch_assoc($seleciona_movimentodiario);
$totalRows_seleciona_movimentodiario = mysql_num_rows($seleciona_movimentodiario);

mysql_select_db($database_conn, $conn);
$id = $_GET['id'];
$query_seleciona_movimentodiario = "SELECT * FROM  movimentodiario WHERE id='$id'"; 
$seleciona_movimentodiario = mysql_query($query_seleciona_movimentodiario, $conn) or die(mysql_error());
$row_seleciona_movimentodiario = mysql_fetch_assoc($seleciona_movimentodiario);
$totalRows_seleciona_movimentodiario = mysql_num_rows($seleciona_movimentodiario);

mysql_select_db($database_conn, $conn);
$query_seleciona_contasdespesareceita = "SELECT * FROM planodecontas WHERE tipo ='2' or tipo='3'";
$seleciona_contasdespesareceita = mysql_query($query_seleciona_contasdespesareceita, $conn) or die(mysql_error());
$row_seleciona_contasdespesareceita = mysql_fetch_assoc($seleciona_contasdespesareceita);
$totalRows_seleciona_contasdespesareceita = mysql_num_rows($seleciona_contasdespesareceita);

mysql_select_db($database_conn, $conn);
$query_seleciona_contacaixabanco = "SELECT * FROM planodecontas WHERE tipo ='1'";
$seleciona_contacaixabanco = mysql_query($query_seleciona_contacaixabanco, $conn) or die(mysql_error());
$row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco);
$totalRows_seleciona_contacaixabanco = mysql_num_rows($seleciona_contacaixabanco);


mysql_select_db($database_conn, $conn);
$query_seleciona_centrodecustos = "SELECT * FROM centrodecustos";
$seleciona_centrodecustos = mysql_query($query_seleciona_centrodecustos, $conn) or die(mysql_error());
$row_seleciona_centrodecustos = mysql_fetch_assoc($seleciona_centrodecustos);
$totalRows_seleciona_centrodecustos = mysql_num_rows($seleciona_centrodecustos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%">
  <tr>
    <th>ALTERA MOVIMENTO DIÁRIO</th>
  </tr>
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td width="15%" align="right" nowrap="nowrap">ID:</td>
            <td width="85%"><?php echo $row_seleciona_movimentodiario['id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">DATA CADASTRO:</td>
            <td><input type="text" name="datacadastro" value="<?php echo htmlentities(databrasil($row_seleciona_movimentodiario['datacadastro']), ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">VALOR:</td>
            <td><input type="text" name="valor" value="<?php echo htmlentities($row_seleciona_movimentodiario['valor'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">HISTÓRICO:</td>
            <td><input type="text" name="historico" value="<?php echo htmlentities($row_seleciona_movimentodiario['historico'], ENT_COMPAT, 'utf-8'); ?>" size="50" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CONTA DESPESA/RECEITA::</td>
            <td><label for="id_contadespesareceita"></label>
              <select name="id_contadespesareceita" id="id_contadespesareceita">
                <?php
do {  
?>
                <option value="<?php echo $row_seleciona_movimentodiario['id_contadespesareceita']?>"<?php if (!(strcmp($row_seleciona_movimentodiario['id_contadespesareceita'], $row_seleciona_contasdespesareceita['id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_contasdespesareceita['descricao']?></option>
                <?php
} while ($row_seleciona_contasdespesareceita = mysql_fetch_assoc($seleciona_contasdespesareceita));
  $rows = mysql_num_rows($seleciona_contasdespesareceita);
  if($rows > 0) {
      mysql_data_seek($seleciona_contasdespesareceita, 0);
	  $row_seleciona_contasdespesareceita = mysql_fetch_assoc($seleciona_contasdespesareceita);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CONTA CAIXA/BANCO:</td>
            <td><select name="id_contacaixabanco" id="id_contacaixabanco">
                <?php
do {  
?>
                <option value="<?php echo $row_seleciona_movimentodiario['id_contacaixabanco']?>"<?php if (!(strcmp($row_seleciona_movimentodiario['id_contacaixabanco'], $row_seleciona_contacaixabanco['id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_contacaixabanco['descricao']?></option>
                <?php
} while ($row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco));
  $rows = mysql_num_rows($seleciona_contacaixabanco);
  if($rows > 0) {
      mysql_data_seek($seleciona_contacaixabanco, 0);
	  $row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input name="Entrar" type="submit" id="Entrar" value="CONFIRMAR" />
            <input name="Entrar2" type="button" class="btn1" id="Entrar2" onclick="closeMessage()" value="CANCELAR" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id" value="<?php echo $row_seleciona_movimentodiario['id']; ?>" />
      </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_movimentodiario);
?>
