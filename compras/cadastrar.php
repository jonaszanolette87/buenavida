<?php require_once('../Connections/conn.php');
include ("../funcoes/funcoes.php"); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") || ($_GET["id_compra"] == "novo")) {
  $insertSQL = sprintf("INSERT INTO compras ( id_fornecedor, datacompra, status) VALUES ( %s, %s, %s)",
                     
                       GetSQLValueString($_POST['id_fornecedor'], "int"),
                       GetSQLValueString(datausa($_POST['datacompra']), "date"),
                                        
					   GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

$id_compra = mysql_insert_id();

$insertGoTo = "../compras/alterar.php?id=".$id_compra."&id_compra=".$id_compra.";";

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




?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16">CADASTRA COMPRA:</th>
      <th width="40" class="Titulo16"><a href="#" onClick="closeMessage()"><img src="../imagens/botao_fechar.png" alt="fechar" width="25" height="25" border="0" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="950" align="center">
      <tr valign="baseline">
        <td width="15%" align="right" nowrap="nowrap">FORNECEDOR:</td>
        <td><label for="id_fornecedor">
          <select name="id_fornecedor" id="id_fornecedor">
            <option value=""></option>
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
          </select>
        </label>
        STATUS:
        <input type="text" name="status" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <th colspan="2" align="left" nowrap="nowrap">PRODUTOS - MATERIAS PRIMAS</th>
      </tr>
      <tr valign="baseline">
        <td colspan="2" align="left" nowrap="nowrap"><iframe width="950px" height="300px" frameborder="0" src="../compras_itens/index.php"></iframe></td>
      </tr>
      <tr valign="baseline">
        <th colspan="2" align="left" nowrap="nowrap">FECHAMENTO</th>
      </tr>
      <tr valign="baseline">
        <th colspan="2" align="left" nowrap="nowrap"><iframe width="950px" height="300px" frameborder="0" src="../compras_fechamento/index.php"></iframe></th>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Cadastrar" />
        <input name="Entrar" type="button" class="btn1" id="Entrar" onclick="closeMessage()" value="Cancelar" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
 
<?php
mysql_free_result($seleciona_fornecedores);




?>
