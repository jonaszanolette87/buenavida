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
  $insertSQL = sprintf("INSERT INTO compras_itens_materiasprimas (id, id_compra, id_produto, qtd, precocusto, descontopercentual, descontoreal, valortotal, datacadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
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


  $qtd= $_POST['qtd'];
  
  $id_produto =  $_POST['id_produto'];

  if($qtd != ""){
  	$updateSQL2 =  "UPDATE materiasprimas SET  estoque= estoque + '$qtd' WHERE id = '$id_produto'";
 
 	 mysql_select_db($database_conn, $conn);
  	$Result2 = mysql_query($updateSQL2, $conn) or die(mysql_error());
  }


  $insertGoTo = "../compras_itens_materiasprimas/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_materiasprimas = "SELECT * FROM materiasprimas ORDER BY nome ASC";
$seleciona_materiasprimas = mysql_query($query_seleciona_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_materiasprimas = mysql_fetch_assoc($seleciona_materiasprimas);
$totalRows_seleciona_materiasprimas = mysql_num_rows($seleciona_materiasprimas);


$maxRows_seleciona_compras_itens_materiasprimas = 10;
$pageNum_seleciona_compras_itens_materiasprimas = 0;
if (isset($_GET['pageNum_seleciona_compras_itens_materiasprimas'])) {
  $pageNum_seleciona_compras_itens_materiasprimas = $_GET['pageNum_seleciona_compras_itens_materiasprimas'];
}
$startRow_seleciona_compras_itens_materiasprimas = $pageNum_seleciona_compras_itens_materiasprimas * $maxRows_seleciona_compras_itens_materiasprimas;

$colname_seleciona_compras_itens_materiasprimas = "-1";
if (isset($_GET['id_compra'])) {
  $colname_seleciona_compras_itens_materiasprimas = $_GET['id_compra'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_compras_itens_materiasprimas = sprintf("SELECT vi.*, mp.nome as produto FROM compras_itens_materiasprimas vi

LEFT JOIN materiasprimas mp
ON vi.id_produto = mp.id



WHERE id_compra = %s", GetSQLValueString($colname_seleciona_compras_itens_materiasprimas, "int"));
$query_limit_seleciona_compras_itens_materiasprimas = sprintf("%s LIMIT %d, %d", $query_seleciona_compras_itens_materiasprimas, $startRow_seleciona_compras_itens_materiasprimas, $maxRows_seleciona_compras_itens_materiasprimas);
$seleciona_compras_itens_materiasprimas = mysql_query($query_limit_seleciona_compras_itens_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_compras_itens_materiasprimas = mysql_fetch_assoc($seleciona_compras_itens_materiasprimas);

if (isset($_GET['totalRows_seleciona_compras_itens_materiasprimas'])) {
  $totalRows_seleciona_compras_itens_materiasprimas = $_GET['totalRows_seleciona_compras_itens_materiasprimas'];
} else {
  $all_seleciona_compras_itens_materiasprimas = mysql_query($query_seleciona_compras_itens_materiasprimas);
  $totalRows_seleciona_compras_itens_materiasprimas = mysql_num_rows($all_seleciona_compras_itens_materiasprimas);
}
$totalPages_seleciona_compras_itens_materiasprimas = ceil($totalRows_seleciona_compras_itens_materiasprimas/$maxRows_seleciona_compras_itens_materiasprimas)-1;
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
form_compra_itens.valortotal.value = (form_compra_itens.qtd.value) * (form_compra_itens.valor.value) ;
}


</script>
 <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("select[name='id_produto']").change(function(){
			var valor = $("input[name='valor']");
			
 
			$( valor ).val('Carregando...');
			
 
				$.getJSON(
					'../compras_itens_materiasprimas/valorcusto.php',
					{ id: $( this ).val() },
					function( json )
					{
						$( valor ).val( json.valor );
						
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
        Mat Prima:
        
          <select name="id_produto" id="id_produto">
         <option value="0">Escolha o produto</option>
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_materiasprimas['id']?>"><?php echo $row_seleciona_materiasprimas['nome']?><?php echo "<b> R$ ".$row_seleciona_materiasprimas['precocusto']."</b>"?></option>
          <?php
} while ($row_seleciona_materiasprimas = mysql_fetch_assoc($seleciona_materiasprimas));
  $rows = mysql_num_rows($seleciona_materiasprimas);
  if($rows > 0) {
      mysql_data_seek($seleciona_materiasprimas, 0);
	  $row_seleciona_materiasprimas = mysql_fetch_assoc($seleciona_materiasprimas);
  }
?>
      </select></td>
      <td width="73%" align="left" nowrap="nowrap">QTD:
        <input type="text" id="qtd" name="qtd" value="1" size="5" onblur="soma()" />
        VALOR:
      <input type="text" id="valor" name="valor" value="" size="8" onblur="soma()" />
      VL. TOTAL:
      <input type="text" id="valortotal" name="valortotal" value="" size="5"  onblur="soma()" />
      <input type="submit" value="INSERIR" /></td>
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
    <th>VALOR TOTAL</th>
  </tr>
  <?php do { ?>
    <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <td><a href="../compras_itens_materiasprimas/excluir.php?id_compra=<?php echo $row_seleciona_compras_itens_materiasprimas['id_compra']; ?>&id=<?php echo $row_seleciona_compras_itens_materiasprimas['id']; ?>&id_produto=<?php echo $row_seleciona_compras_itens_materiasprimas['id_produto']; ?>&qtd=<?php echo $row_seleciona_compras_itens_materiasprimas['qtd']; ?>"><img src="../imagens/del.png" width="20" height="20" /></a></td>
      <td><?php echo $row_seleciona_compras_itens_materiasprimas['produto']; ?></td>
      <td><?php echo $row_seleciona_compras_itens_materiasprimas['qtd']; ?></td>
      <td><?php echo $row_seleciona_compras_itens_materiasprimas['precocusto']; ?></td>
      <td><?php echo $row_seleciona_compras_itens_materiasprimas['valortotal']; ?></td>
    </tr>
    <?php } while ($row_seleciona_compras_itens_materiasprimas = mysql_fetch_assoc($seleciona_compras_itens_materiasprimas)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_materiasprimas);

mysql_free_result($seleciona_compras_itens_materiasprimas);
?>
