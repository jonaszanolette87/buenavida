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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_compra_itens")) {
  $insertSQL = sprintf("INSERT INTO compras_itens (id, id_compra, id_produto, qtd, precocusto, descontopercentual, descontoreal, valortotal, datacadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_compra'], "int"),
                       GetSQLValueString($_POST['id_produto'], "int"),
                       GetSQLValueString($_POST['qtd'], "int"),
                       GetSQLValueString($_POST['precocusto'], "text"),
                       GetSQLValueString($_POST['descontopercentual'], "text"),
                       GetSQLValueString($_POST['descontoreal'], "double"),
                       GetSQLValueString($_POST['valortotal'], "text"),
                       GetSQLValueString($_POST['datacadastro'], "date"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  
    $qtd = $_POST['qtd']; 
 	$id_produto =  $_POST['id_produto'];  
	 
	if   (isset($_POST['deposito'])){
	$updateSQL2 =  "UPDATE produtos SET  estoque= estoque + '$qtd' WHERE id = '$id_produto'";
	}
	
	if (isset($_POST['palmas'])){
		
		$updateSQL2 =  "UPDATE produtos SET  estoquepalmas= estoquepalmas + '$qtd' WHERE id = '$id_produto'";
		}
	
	if (!isset($_POST['deposito']) && !isset($_POST['palmas']) )
	{
		$updateSQL2 =  "UPDATE produtos SET  estoque= estoque + '$qtd' WHERE id = '$id_produto'";
		}
 	mysql_select_db($database_conn, $conn);
  	$Result2 = mysql_query($updateSQL2, $conn) or die(mysql_error());
	  
	  
	 
  

  $insertGoTo = "../compras_itens/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_produtos = "SELECT * FROM produtos ORDER BY nome ASC";
$seleciona_produtos = mysql_query($query_seleciona_produtos, $conn) or die(mysql_error());
$row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos);
$totalRows_seleciona_produtos = mysql_num_rows($seleciona_produtos);

$maxRows_seleciona_compras_itens = 50;
$pageNum_seleciona_compras_itens = 0;
if (isset($_GET['pageNum_seleciona_compras_itens'])) {
  $pageNum_seleciona_compras_itens = $_GET['pageNum_seleciona_compras_itens'];
}
$startRow_seleciona_compras_itens = $pageNum_seleciona_compras_itens * $maxRows_seleciona_compras_itens;

$colname_seleciona_compras_itens = "-1";
if (isset($_GET['id_compra'])) {
  $colname_seleciona_compras_itens = $_GET['id_compra'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_compras_itens = sprintf("SELECT vi.*, p.nome as produto FROM compras_itens vi

LEFT JOIN produtos p
ON vi.id_produto = p.id



WHERE id_compra = %s", GetSQLValueString($colname_seleciona_compras_itens, "int"));
$query_limit_seleciona_compras_itens = sprintf("%s LIMIT %d, %d", $query_seleciona_compras_itens, $startRow_seleciona_compras_itens, $maxRows_seleciona_compras_itens);
$seleciona_compras_itens = mysql_query($query_limit_seleciona_compras_itens, $conn) or die(mysql_error());
$row_seleciona_compras_itens = mysql_fetch_assoc($seleciona_compras_itens);

if (isset($_GET['totalRows_seleciona_compras_itens'])) {
  $totalRows_seleciona_compras_itens = $_GET['totalRows_seleciona_compras_itens'];
} else {
  $all_seleciona_compras_itens = mysql_query($query_seleciona_compras_itens);
  $totalRows_seleciona_compras_itens = mysql_num_rows($all_seleciona_compras_itens);
}
$totalPages_seleciona_compras_itens = ceil($totalRows_seleciona_compras_itens/$maxRows_seleciona_compras_itens)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

function soma()
{
form_compra_itens.valortotal.value = (form_compra_itens.qtd.value) * (form_compra_itens.precocusto.value) ;
}

function desconto()
{
form_compra_itens.valortotal.value = (form_compra_itens.valortotal.value -(form_compra_itens.valortotal.value*(form_compra_itens.descontopercentual.value/100))) ;
}

</script>
 <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("select[name='id_produto']").change(function(){
			var precocusto = $("input[name='precocusto']");
			
 
			$( precocusto ).val('Carregando...');
			
 
				$.getJSON(
					'../compras_itens/valorcusto.php',
					{ id: $( this ).val() },
					function( json )
					{
						$( precocusto ).val( json.precocusto );
						
					}
				);
		});
	});
	</script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form_compra_itens" id="form_compra_itens">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td width="27%" align="right" nowrap="nowrap"><input type="hidden" name="id_compra" value="<?php echo $_GET['id_compra'];?>" size="32" />
        :
<select name="id_produto" id="id_produto">
         
         <option value="0">Escolha o produto</option>
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_produtos['id']?>"><?php echo $row_seleciona_produtos['nome']?></option>
          <?php
} while ($row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos));
  $rows = mysql_num_rows($seleciona_produtos);
  if($rows > 0) {
      mysql_data_seek($seleciona_produtos, 0);
	  $row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos);
  }
?>
      </select></td>
      <td width="8%" align="right" nowrap="nowrap">QTD:
      <input type="text" name="qtd" id="qtd" value="" size="3" onblur="soma()" /></td>
      <td width="65%" align="left" nowrap="nowrap">VALOR:
      <input name="precocusto" type="text" id="precocusto" value="" size="5" onblur="soma()" />
      DESC.%:
      <input name="descontopercentual" type="text" id="descontopercentual"  size="3" onblur="desconto()" />
      VL. TOTAL:
<input type="text" name="valortotal" value="" size="5" id="valortotal"  />
      <input type="submit" value="INSERIR " /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_compra_itens" />
</form>

<table width="100%">
  <tr>
    <th>&nbsp;</th>
    <th>PRODUTO</th>
    <th>QTD</th>
    <th>VALOR</th>
    <th>DESCONTO</th>
    <th>SUB TOTAL</th>
  </tr>
  <?php do { ?>
    <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <td><a href="../compras_itens/excluir.php?id_compra=<?php echo $row_seleciona_compras_itens['id_compra']; ?>&id=<?php echo $row_seleciona_compras_itens['id']; ?>&id_produto=<?php echo $row_seleciona_compras_itens['id_produto']; ?>&qtd=<?php echo $row_seleciona_compras_itens['qtd']; ?>"><img src="../imagens/del.png" width="20" height="20" /></a></td>
      <td><?php echo $row_seleciona_compras_itens['produto']; ?></td>
      <td><?php echo $row_seleciona_compras_itens['qtd']; ?></td>
      <td><?php echo $row_seleciona_compras_itens['precocusto']; ?></td>
      <td><?php echo $row_seleciona_compras_itens['descontopercentual']." % "; ?></td>
      <td><?php echo $row_seleciona_compras_itens['valortotal']; ?></td>
    </tr>
    <?php } while ($row_seleciona_compras_itens = mysql_fetch_assoc($seleciona_compras_itens)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_produtos);

mysql_free_result($seleciona_compras_itens);
?>
