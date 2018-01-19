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
  $insertSQL = sprintf("INSERT INTO contasapagar_pagamento (id,  id_formadepagamento,id_contasapagar, valortotal, datacompensacao) VALUES (%s, %s, %s, %s,  %s)",
  
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_formadepagamento'], "int"),
					   GetSQLValueString($_POST['id_contasapagar'], "int"),
                       GetSQLValueString($_POST['valortotal'], "text"),
                       GetSQLValueString(datausa($_POST['datacompensacao']), "date")
					   );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../contasapagar_pagamento/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_seleciona_contasapagar_pagamento = 10;
$pageNum_seleciona_contasapagar_pagamento = 0;
if (isset($_GET['pageNum_seleciona_contasapagar_pagamento'])) {
  $pageNum_seleciona_contasapagar_pagamento = $_GET['pageNum_seleciona_contasapagar_pagamento'];
}
$startRow_seleciona_contasapagar_pagamento = $pageNum_seleciona_contasapagar_pagamento * $maxRows_seleciona_contasapagar_pagamento;

$colname_seleciona_contasapagar_pagamento = "-1";
if (isset($_GET['id_contasapagar'])) {
  $colname_seleciona_contasapagar_pagamento = $_GET['id_contasapagar'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_contasapagar_pagamento = sprintf("SELECT vf.*, fp.nome as formadepagamento 

FROM contasapagar_pagamento  vf 

LEFT JOIN formasdepagamento fp
ON vf.id_formadepagamento = fp.id




WHERE id_contasapagar = %s", GetSQLValueString($colname_seleciona_contasapagar_pagamento, "int"));
$query_limit_seleciona_contasapagar_pagamento = sprintf("%s LIMIT %d, %d", $query_seleciona_contasapagar_pagamento, $startRow_seleciona_contasapagar_pagamento, $maxRows_seleciona_contasapagar_pagamento);
$seleciona_contasapagar_pagamento = mysql_query($query_limit_seleciona_contasapagar_pagamento, $conn) or die(mysql_error());
$row_seleciona_contasapagar_pagamento = mysql_fetch_assoc($seleciona_contasapagar_pagamento);

if (isset($_GET['totalRows_seleciona_contasapagar_pagamento'])) {
  $totalRows_seleciona_contasapagar_pagamento = $_GET['totalRows_seleciona_contasapagar_pagamento'];
} else {
  $all_seleciona_contasapagar_pagamento = mysql_query($query_seleciona_contasapagar_pagamento);
  $totalRows_seleciona_contasapagar_pagamento = mysql_num_rows($all_seleciona_contasapagar_pagamento);
}
$totalPages_seleciona_contasapagar_pagamento = ceil($totalRows_seleciona_contasapagar_pagamento/$maxRows_seleciona_contasapagar_pagamento)-1;

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
			 
				$.getJSON('../contasapagar_pagamento/valortotal.php?id_contasapagar=<?php echo $_GET['id_contasapagar']?>',
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
      <td nowrap><input type="hidden" name="id_contasapagar" value="<?php echo $_GET['id_contasapagar']?>" size="32">
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
      <input name="datacompensacao" type="date" id="datacompensacao" value="" size="10" />      <input type="submit" value="INSERIR" /></td>
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
      <td><a href="../contasapagar_pagamento/excluir.php?id_contasapagar=<?php echo $row_seleciona_contasapagar_pagamento['id_contasapagar']; ?>&amp;id=<?php echo $row_seleciona_contasapagar_pagamento['id']; ?>"><img src="../imagens/del.png" alt="" width="20" height="20" /></a></td>
      <td><?php echo $row_seleciona_contasapagar_pagamento['formadepagamento']; ?></td>
      <td><?php echo $row_seleciona_contasapagar_pagamento['valortotal']; ?></td>
      <td><?php echo databrasil($row_seleciona_contasapagar_pagamento['datacompensacao']); ?></td>
    </tr>
    <?php } while ($row_seleciona_contasapagar_pagamento = mysql_fetch_assoc($seleciona_contasapagar_pagamento)); ?>
</table>
<?php
mysql_free_result($seleciona_contasapagar_pagamento);

mysql_free_result($seleciona_formasdepagamento);
?>
