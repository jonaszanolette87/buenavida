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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") || ($_GET["id_venda"] == "novo")) {
  $insertSQL = sprintf("INSERT INTO vendas (tipo, id_cliente, id_vendedor, status) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['id_cliente'], "int"),
                       GetSQLValueString($_POST['id_vendedor'], "int"),          
					   GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

$id_venda = mysql_insert_id();

$insertGoTo = "../vendas/alterar.php?id=".$id_venda."&id_venda=".$id_venda.";";

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
$query_seleciona_vendedores = "SELECT * FROM vendedores";
$seleciona_vendedores = mysql_query($query_seleciona_vendedores, $conn) or die(mysql_error());
$row_seleciona_vendedores = mysql_fetch_assoc($seleciona_vendedores);
$totalRows_seleciona_vendedores = mysql_num_rows($seleciona_vendedores);


?>

<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"/></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#telefone1").mask("(99)9999-9999");
		$("#telefone2").mask("(99)9999-9999");
		$("#cep").mask("99999-999");
		$("#datanascimento").mask("99/99/9999");
		$("#cpf").mask("999.999.999-99");
		$("#cnpj").mask("99.999.999/9999-99");
		
	    
	});
</script>


<link href="../calendario/_style/default.css" rel="stylesheet" type="text/css"/>
<link href="../calendario/_style/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../calendario/_scripts/jquery.js"></script>
<script type="text/javascript" src="../calendario/_scripts/jquery.click-calendario-1.0-min.js"></script>
<script type="text/javascript" src="../calendario/_scripts/exemplo-calendario.js"></script>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16">CADASTRA VENDAS:</th>
      <th width="40" class="Titulo16"><a href="#" onClick="closeMessage()"><img src="../imagens/botao_fechar.png" alt="fechar" width="25" height="25" border="0" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="100%" align="center">
      <tr valign="baseline">
        <td width="4%" align="right" nowrap="nowrap">TIPO:</td>
        <td width="23%"><label>
          <input name="tipo" type="radio" id="tipo_0" value="O" />
          ORCAMENTO</label>
          <label>
            <input name="tipo" type="radio" id="tipo_1" value="V" checked="checked" />
        VENDA</label></td>
        <td width="9%">STATUS:</td>
        <td width="64%"><input type="text" name="status" value="" size="32" />
        CLIENTE: <select name="id_cliente" id="id_cliente">
          <option value=""></option>
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
      </tr>
      <tr valign="baseline">
        <th colspan="4" align="left" nowrap="nowrap">PRODUTOS</th>
      </tr>
      <tr valign="baseline">
        <td colspan="4" align="left" nowrap="nowrap"><iframe width="950px" height="200px" frameborder="0" src="../vendas_itens/index.php"></iframe></td>
      </tr>
      <tr valign="baseline">
        <th colspan="4" align="left" nowrap="nowrap">FECHAMENTO</th>
      </tr>
      <tr valign="baseline">
        <th colspan="4" align="left" nowrap="nowrap"><iframe width="950px" height="150px" frameborder="0" src="../vendas_fechamento/index.php"></iframe></th>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td colspan="3"><input type="submit" value="CADASTRA" /> <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
 
<?php
mysql_free_result($seleciona_clientes);

mysql_free_result($seleciona_vendedores);


?>
