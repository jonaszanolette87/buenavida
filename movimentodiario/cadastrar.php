<?php require_once('../Connections/conn.php');
include ('../funcoes/funcoes.php'); ?>
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

mysql_select_db($database_conn, $conn);
$query_seleciona_centrodecustos = "SELECT * FROM centrodecustos";
$seleciona_centrodecustos = mysql_query($query_seleciona_centrodecustos, $conn) or die(mysql_error());
$row_seleciona_centrodecustos = mysql_fetch_assoc($seleciona_centrodecustos);
$totalRows_seleciona_centrodecustos = mysql_num_rows($seleciona_centrodecustos);

mysql_select_db($database_conn, $conn);
$query_seleciona_contasdespesareceita = "SELECT * FROM planodecontas WHERE tipo ='2' or tipo='3' ORDER BY descricao ASC";
$seleciona_contasdespesareceita = mysql_query($query_seleciona_contasdespesareceita, $conn) or die(mysql_error());
$row_seleciona_contasdespesareceita = mysql_fetch_assoc($seleciona_contasdespesareceita);
$totalRows_seleciona_contasdespesareceita = mysql_num_rows($seleciona_contasdespesareceita);




mysql_select_db($database_conn, $conn);
$query_seleciona_contacaixabanco = "SELECT  * FROM  planodecontas WHERE tipo='1'";
$seleciona_contacaixabanco = mysql_query($query_seleciona_contacaixabanco, $conn) or die(mysql_error());
$row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco);
$totalRows_seleciona_contacaixabanco = mysql_num_rows($seleciona_contacaixabanco);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
  $insertSQL = sprintf("INSERT INTO movimentodiario (id, datacadastro, valor, historico, 
  id_contadespesareceita, id_contacaixabanco) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString(datausa($_POST['datacadastro']), "date"),
                       GetSQLValueString($_POST['valor'], "double"),
                       GetSQLValueString($_POST['historico'], "text"),					   
                       GetSQLValueString($_POST['id_contadespesareceita'], "int"),  
					                        
                       GetSQLValueString($_POST['id_contacaixabanco'], "int")
                      );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  
  //pega o ultimo id $id = mysql_insert_id();
  
  atualizasaldodaconta($_POST['id_contadespesareceita'],$_POST['valor'],$_POST['operacao']);

  $insertGoTo = "../inicio/principal.php?pg=movimentodiario";
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
<table width="100%">
  <tr>
    <th>CADASTRAR MOVIMENTO DIÁRIO</th>
  </tr>
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td width="16%" align="right" nowrap="nowrap">DATA CADASTRO:</td>
            <td width="84%"><input type="text" name="datacadastro" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">VALOR:</td>
            <td><input type="text" name="valor" value="" size="10" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">HISTÓRICO:</td>
            <td><input type="text" name="historico" value="" size="50" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CONTA DESPESA/ RECEITA:</td>
            <td><label>
              <select name="id_contadespesareceita" id="id_contadespesareceita">
                <option></option>
				
				<?php
do {  
?>
                <option value="<?php echo $row_seleciona_contasdespesareceita['id']?>"><?php echo $row_seleciona_contasdespesareceita['descricao']?></option>
                <?php
} while ($row_seleciona_contasdespesareceita = mysql_fetch_assoc($seleciona_contasdespesareceita));
  $rows = mysql_num_rows($seleciona_contasdespesareceita);
  if($rows > 0) {
      mysql_data_seek($seleciona_contasdespesareceita, 0);
	  $row_seleciona_contasdespesareceita = mysql_fetch_assoc($seleciona_contasdespesareceita);
  }
?>
              </select>
            </label></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CONTA CAIXA/BANCO:</td>
            <td><label>
              <select name="id_contacaixabanco" id="id_contacaixabanco">
                 <option></option>
				<?php
do {  
?>
                <option value="<?php echo $row_seleciona_contacaixabanco['id']?>"><?php echo $row_seleciona_contacaixabanco['descricao']?></option>
                <?php
} while ($row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco));
  $rows = mysql_num_rows($seleciona_contacaixabanco);
  if($rows > 0) {
      mysql_data_seek($seleciona_contacaixabanco, 0);
	  $row_seleciona_contacaixabanco = mysql_fetch_assoc($seleciona_contacaixabanco);
  }
?>
              </select>
            </label></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input name="Entrar" type="submit" id="Entrar" value="CADASTRAR" />
            <input name="Entrar2" type="button" class="btn1" id="Entrar2" onclick="closeMessage()" value="CANCELAR" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
   </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_centrodecustos);

mysql_free_result($seleciona_contasdespesareceita);

mysql_free_result($seleciona_contacaixabanco);
?>
