<?php require_once('../Connections/conn.php');
include("../funcoes/funcoes.php");?>
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
  $updateSQL = sprintf("UPDATE compras_materiasprimas SET id_fornecedor=%s, datacompra=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_fornecedor'], "int"),
                       GetSQLValueString(datausa($_POST['datacompra']), "date"),                     
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
  
	$id_fornecedor = $_POST['id_fornecedor'];
	$id = $_POST['id'];
	
	$sql = "UPDATE contasapagar SET id_fornecedor = $id_fornecedor WHERE id_compra = $id";
	
	 mysql_select_db($database_conn, $conn);
     mysql_query($sql, $conn) or die(mysql_error());
	 
	 

  $updateGoTo = "../inicio/principal.php?pg=compras_materiasprimas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_compras_materiasprimas = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_compras_materiasprimas = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_compras_materiasprimas = sprintf("SELECT * FROM compras_materiasprimas WHERE id = %s", GetSQLValueString($colname_seleciona_compras_materiasprimas, "int"));
$seleciona_compras_materiasprimas = mysql_query($query_seleciona_compras_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_compras_materiasprimas = mysql_fetch_assoc($seleciona_compras_materiasprimas);
$totalRows_seleciona_compras_materiasprimas = mysql_num_rows($seleciona_compras_materiasprimas);

mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT * FROM fornecedores ORDER BY nome";
$seleciona_fornecedores = mysql_query($query_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
$totalRows_seleciona_fornecedores = mysql_num_rows($seleciona_fornecedores);



mysql_select_db($database_conn, $conn);
$query_seleciona_formasdepagamento = "SELECT * FROM formasdepagamento";
$seleciona_formasdepagamento = mysql_query($query_seleciona_formasdepagamento, $conn) or die(mysql_error());
$row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
$totalRows_seleciona_formasdepagamento = mysql_num_rows($seleciona_formasdepagamento);
?>

<script language="javascript">
 
function EnviaFormulario(e)
{
    if(OnEnter(e))
    {
       alert('O formulário pode ser enviado');
        return false;
    }
    else
    {
        return true;
    }
}
 
</script>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16">ALTERA COMPRA MATERIAS PRIMAS:</th>
      <th width="40" class="Titulo16"><a href="#" onClick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="950" align="center">
      <tr valign="baseline">
        <td width="4%" align="right" nowrap="nowrap">Id:</td>
        <td width="96%"><?php echo $row_seleciona_compras_materiasprimas['id']; ?>  | FORNECEDOR: 
           <select name="id_fornecedor" id="id_fornecedor">
           <option value="">Escolha  o Fornecedor</option>
             <?php
do {  
?>
             <option value="<?php echo $row_seleciona_fornecedores['id']?>"<?php if (!(strcmp($row_seleciona_fornecedores['id'], $row_seleciona_compras_materiasprimas['id_fornecedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_fornecedores['nome']?></option>
             <?php
} while ($row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores));
  $rows = mysql_num_rows($seleciona_fornecedores);
  if($rows > 0) {
      mysql_data_seek($seleciona_fornecedores, 0);
	  $row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);
  }
?>
          </select> 
           DATA DA COMPRA
           <input name="datacompra" type="text" id="data_1" value="<?php if($row_seleciona_compras_materiasprimas['datacompra'] == '0000-00-00' || $row_seleciona_compras_materiasprimas['datacompra'] == 'NULL'){ 
		    $data=date("d/m/Y");
			echo $data;
		  
		   } 
		   else {
		   echo databrasil($row_seleciona_compras_materiasprimas['datacompra']);
		   
		   }
		   ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <th colspan="2" align="left" nowrap="nowrap">PRODUTOS </th>
      </tr>
      <tr valign="baseline">
        <td colspan="2" align="left" nowrap="nowrap"><iframe width="950px" height="200px" frameborder="0" src="../compras_itens_materiasprimas/index.php?id_compra=<?php echo $row_seleciona_compras_materiasprimas['id']?>"></iframe></td>
      </tr>
      <tr valign="baseline">
        <th colspan="2" align="left" nowrap="nowrap">FORMA DE PAGAMENTO</th>
      </tr>
      <tr valign="baseline">
        <td colspan="2" align="left" nowrap="nowrap"><iframe width="950px" height="150px" frameborder="0" src="../compras_fechamento_materiasprimas/index.php?id_compra=<?php echo $row_seleciona_compras_materiasprimas['id']?>"></iframe></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Confirmar" onkeypress="return EnviaFormulario(event);"/>
        <input name="Entrar" type="button" class="btn1" id="Entrar" onclick="closeMessage()" value="Cancelar" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="id" value="<?php echo $row_seleciona_compras_materiasprimas['id']; ?>" />
  </form>
  <p>&nbsp;</p>
<?php
mysql_free_result($seleciona_compras_materiasprimas);

mysql_free_result($seleciona_fornecedores);

mysql_free_result($seleciona_formasdepagamento);
?>
