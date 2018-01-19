<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../funcoes/funcoes.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_compra_fechamento")) {
  $insertSQL = sprintf("INSERT INTO compras_fechamento_materiasprimas (id, id_compra, id_formadepagamento, valortotal, datacompensacao) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_compra'], "int"),
                       GetSQLValueString($_POST['id_formadepagamento'], "int"),
                       GetSQLValueString($_POST['valortotal'], "text"),
                       GetSQLValueString(datausa($_POST['datacompensacao']), "date")
					   );
					   
					   

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  
  if ($_POST['id_formadepagamento'] == "1" OR "2" OR "3"){
  	
	$id_compra = $_POST['id_compra'];
    $id_formadepagamento = $_POST['id_formadepagamento'];
    $valor = $_POST['valortotal'];
	$datacompensacao = datausa($_POST['datacompensacao']);
	//$id_fornecedor = $_POST['id_fornecedor'];
	
	$sql = "INSERT INTO contasapagar (datacompensacao, id_compra, id_formadepagamento,valor ) VALUES($datacompensacao,$id_compra,$id_formadepagamento,$valor )";
	
	 mysql_select_db($database_conn, $conn);
     mysql_query($sql, $conn) or die(mysql_error());
  
  }
  if ($_POST['id_formadepagamento'] == "4" OR "5" OR "6"){
	  
  	$id_compra = $_POST['id_compra'];
    $id_formadepagamento = $_POST['id_formadepagamento'];
    $valortotal = $_POST['valortotal'];
	
  }
  
  
  
	$id_fornecedor = $_POST['id_fornecedor'];
	
  

  $insertGoTo = "../compras_fechamento_materiasprimas/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_seleciona_compras_fechamento_materiasprimas = 10;
$pageNum_seleciona_compras_fechamento_materiasprimas = 0;
if (isset($_GET['pageNum_seleciona_compras_fechamento_materiasprimas'])) {
  $pageNum_seleciona_compras_fechamento_materiasprimas = $_GET['pageNum_seleciona_compras_fechamento_materiasprimas'];
}
$startRow_seleciona_compras_fechamento_materiasprimas = $pageNum_seleciona_compras_fechamento_materiasprimas * $maxRows_seleciona_compras_fechamento_materiasprimas;

$colname_seleciona_compras_fechamento_materiasprimas = "-1";
if (isset($_GET['id_compra'])) {
  $colname_seleciona_compras_fechamento_materiasprimas = $_GET['id_compra'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_compras_fechamento_materiasprimas = sprintf("SELECT vf.*, fp.nome as formadepagamento FROM compras_fechamento_materiasprimas  vf 

LEFT JOIN formasdepagamento fp
ON vf.id_formadepagamento = fp.id




WHERE id_compra = %s", GetSQLValueString($colname_seleciona_compras_fechamento_materiasprimas, "int"));
$query_limit_seleciona_compras_fechamento_materiasprimas = sprintf("%s LIMIT %d, %d", $query_seleciona_compras_fechamento_materiasprimas, $startRow_seleciona_compras_fechamento_materiasprimas, $maxRows_seleciona_compras_fechamento_materiasprimas);
$seleciona_compras_fechamento_materiasprimas = mysql_query($query_limit_seleciona_compras_fechamento_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_compras_fechamento_materiasprimas = mysql_fetch_assoc($seleciona_compras_fechamento_materiasprimas);

if (isset($_GET['totalRows_seleciona_compras_fechamento_materiasprimas'])) {
  $totalRows_seleciona_compras_fechamento_materiasprimas = $_GET['totalRows_seleciona_compras_fechamento_materiasprimas'];
} else {
  $all_seleciona_compras_fechamento_materiasprimas = mysql_query($query_seleciona_compras_fechamento_materiasprimas);
  $totalRows_seleciona_compras_fechamento_materiasprimas = mysql_num_rows($all_seleciona_compras_fechamento_materiasprimas);
}
$totalPages_seleciona_compras_fechamento_materiasprimas = ceil($totalRows_seleciona_compras_fechamento_materiasprimas/$maxRows_seleciona_compras_fechamento_materiasprimas)-1;

mysql_select_db($database_conn, $conn);
$query_seleciona_formasdepagamento = "SELECT * FROM formasdepagamento";
$seleciona_formasdepagamento = mysql_query($query_seleciona_formasdepagamento, $conn) or die(mysql_error());
$row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
$totalRows_seleciona_formasdepagamento = mysql_num_rows($seleciona_formasdepagamento);
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
		$("select[name='id_formadepagamento']").change(function(){
			var valortotal = $("input[name='valortotal']");			
 
			$( valortotal ).val('Carregando...');
			 
				$.getJSON('../compras_fechamento_materiasprimas/valortotal.php',
					{ id: $( this ).val() },
					function( json )
					{
						$( valortotal ).val( json.valortotal );
						
					}
				);
		});
	});
	</script>

<form method="post" name="form_compra_fechamento" action="<?php echo $editFormAction; ?>">
  <table width="100%">
    <tr valign="baseline">
      <td nowrap><input type="hidden" name="id_compra" value="<?php echo $_GET['id_compra']?>" size="32">
        FORMA DE PAGAMENTO:
        
        <select name="id_formadepagamento" id="id_formadepagamento">
        <option value="0"> Escolha a forma</option>
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
      </select>        VALOR:
      <input type="text" name="valortotal" id="valortotal" value="" size="10" >      
      DATA COMPENSAÇÃO 
      <input name="datacompensacao" type="text" id="datacompensacao" value="<?php echo date('d/m/y')?>" size="10" />      <input type="submit" value="INSERIR" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_compra_fechamento">
</form>
<table width="100%">
  <tr>
    <th width="5%">&nbsp;</th>
    <th width="44%">FORMA DE PAGAMENTO</th>
    <th width="25%">VALOR</th>
    <th width="26%">DATA COMPENSAÇÃO</th>
  </tr>
  <?php do { ?>
    <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <td><a href="../compras_fechamento_materiasprimas/excluir.php?id_compra=<?php echo $row_seleciona_compras_fechamento_materiasprimas['id_compra']; ?>&amp;id=<?php echo $row_seleciona_compras_fechamento_materiasprimas['id']; ?>"><img src="../imagens/del.png" alt="" width="20" height="20" /></a></td>
      <td><?php echo $row_seleciona_compras_fechamento_materiasprimas['formadepagamento']; ?></td>
      <td><?php echo $row_seleciona_compras_fechamento_materiasprimas['valortotal']; ?></td>
      <td><?php echo databrasil($row_seleciona_compras_fechamento_materiasprimas['datacompensacao']); ?></td>
    </tr>
    <?php } while ($row_seleciona_compras_fechamento_materiasprimas = mysql_fetch_assoc($seleciona_compras_fechamento_materiasprimas)); ?>
</table>
<?php
mysql_free_result($seleciona_compras_fechamento_materiasprimas);

mysql_free_result($seleciona_formasdepagamento);
?>
