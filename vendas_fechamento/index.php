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


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_venda_fechamento")) {

if($_POST['parcelas'] > 0) {
	
	$dias = $_POST['prazoentreparcelas'];

for ($i=1;$i <= $_POST['parcelas']; $i++) {
	
	
	$valorparcela = $_POST['valortotal']/$_POST['parcelas'];
	
	
	$datavencimento = date('Y/m/d', strtotime("+".$dias." days"));
	
	$dias = $dias + $_POST['prazoentreparcelas'];
	
  $insertSQL = sprintf("INSERT INTO vendas_fechamento (id, id_venda, id_formadepagamento, descontototal, valortotal, parcela, valorparcela, prazoentreparcelas,datavencimento  ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_venda'], "int"),
                       GetSQLValueString($_POST['id_formadepagamento'], "int"),
					   GetSQLValueString($_POST['descontototal'], "int"),
                       GetSQLValueString($_POST['valortotal'], "text"),
					   
	                   GetSQLValueString($_POST['parcelas'].'/'. $i, "text"),
					   GetSQLValueString($valorparcela, "text"),
					   GetSQLValueString($_POST['prazoentreparcelas'], "text"),
					   GetSQLValueString($datavencimento, "date")
                      );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}
}
else {
	
	$insertSQL = sprintf("INSERT INTO vendas_fechamento (id, id_venda, id_formadepagamento, descontototal, valortotal, parcela, valorparcela, prazoentreparcelas,datavencimento  ) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['id_venda'], "int"),
                       GetSQLValueString($_POST['id_formadepagamento'], "int"),
                       GetSQLValueString($_POST['descontototal'], "int"),
					   
					   GetSQLValueString($_POST['valortotal'], "text"),
	                   GetSQLValueString($_POST['parcela'], "text"),
					   GetSQLValueString($_POST['valorparcela'], "text"),
					   GetSQLValueString($_POST['prazoentreparcelas'], "text"),
					   GetSQLValueString(datausa($_POST['primeiradata']), "date")
                      );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
	
	
	
	}



  $insertGoTo = "../vendas_fechamento/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_seleciona_vendas_fechamento = 10;
$pageNum_seleciona_vendas_fechamento = 0;
if (isset($_GET['pageNum_seleciona_vendas_fechamento'])) {
  $pageNum_seleciona_vendas_fechamento = $_GET['pageNum_seleciona_vendas_fechamento'];
}
$startRow_seleciona_vendas_fechamento = $pageNum_seleciona_vendas_fechamento * $maxRows_seleciona_vendas_fechamento;

$colname_seleciona_vendas_fechamento = "-1";
if (isset($_GET['id_venda'])) {
  $colname_seleciona_vendas_fechamento = $_GET['id_venda'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_vendas_fechamento = sprintf("SELECT vf.*, fp.nome as formadepagamento FROM vendas_fechamento  vf 

LEFT JOIN formasdepagamento fp
ON vf.id_formadepagamento = fp.id




WHERE id_venda = %s", GetSQLValueString($colname_seleciona_vendas_fechamento, "int"));
$query_limit_seleciona_vendas_fechamento = sprintf("%s LIMIT %d, %d", $query_seleciona_vendas_fechamento, $startRow_seleciona_vendas_fechamento, $maxRows_seleciona_vendas_fechamento);
$seleciona_vendas_fechamento = mysql_query($query_limit_seleciona_vendas_fechamento, $conn) or die(mysql_error());
$row_seleciona_vendas_fechamento = mysql_fetch_assoc($seleciona_vendas_fechamento);

if (isset($_GET['totalRows_seleciona_vendas_fechamento'])) {
  $totalRows_seleciona_vendas_fechamento = $_GET['totalRows_seleciona_vendas_fechamento'];
} else {
  $all_seleciona_vendas_fechamento = mysql_query($query_seleciona_vendas_fechamento);
  $totalRows_seleciona_vendas_fechamento = mysql_num_rows($all_seleciona_vendas_fechamento);
}
$totalPages_seleciona_vendas_fechamento = ceil($totalRows_seleciona_vendas_fechamento/$maxRows_seleciona_vendas_fechamento)-1;

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
			 
				$.getJSON('../vendas_fechamento/valortotal.php?id_venda=<?php echo $_GET['id_venda']?>',
					{ id: $( this ).val() },
					function( json )
					{
						$( valortotal ).val( json.valortotal );
						
					}
				);
		});
	});
	</script>
    
    
    
    <script type="text/javascript">

function soma()
{
form_venda_fechamento.valortotal.value = form_venda_fechamento.valortotal.value - form_venda_fechamento.descontototal.value ;
}

function desconto()
{
form_venda_itens.valortotal.value = (form_venda_itens.valortotal.value -(form_venda_itens.valortotal.value*(form_venda_itens.descontopercentual.value/100))) ;
}

</script>

<form method="post" name="form_venda_fechamento" action="<?php echo $editFormAction; ?>">
  <table width="100%" align="center">
    <tr valign="baseline">
      <td nowrap><label for="id_formadepagamento"></label>
        <input type="hidden" name="id_venda" value="<?php echo $_GET['id_venda'];?>" size="32" />
        <select name="id_formadepagamento" id="id_formadepagamento">
        <option value="">Escolha a Forma</option> 
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
      </select>   
        DESC.:
        <input name="descontototal" type="text" id="descontototal" value="" size="8" maxlength="8" onblur="soma()">      VALOR:
      <input name="valortotal" type="text" id="valortotal" value="" size="8" maxlength="8">
        PARCELAS:
        <input name="parcelas" type="text" id="parcelas" value="" size="1" maxlength="1" />
        PRAZO:
        <input name="prazoentreparcelas" type="text" id="prazoentreparcelas" value="30" size="2" maxlength="2" />
        dias 1a DATA: 
      <input name="primeiradata" type="text" id="primeiradata" value="<?php echo date('d/m/Y')?>" size="10" maxlength="10" />      <input type="submit" value="PAGAR" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form_venda_fechamento">
</form>
<table width="100%">
  <tr>
    <th width="1%">&nbsp;</th>
    <th width="19%">FORMA DE PAGAMENTO</th>
    <th width="10%">DESC.</th>
    <th width="10%">VALOR TOTAL</th>
    <th width="20%">VALOR DA PARCELA</th>
    <th width="10%">PARCELA</th>
    <th width="10%">PRAZO</th>
    <th width="20%">DATA VENC.</th>
  </tr>
  <?php do { ?>
    <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <td><a href="../vendas_fechamento/excluir.php?id_venda=<?php echo $row_seleciona_vendas_fechamento['id_venda']; ?>&amp;id=<?php echo $row_seleciona_vendas_fechamento['id']; ?>"><img src="../imagens/del.png" alt="" width="20" height="20" /></a></td>
      <td><?php echo $row_seleciona_vendas_fechamento['formadepagamento']; ?></td>
      <td><?php echo $row_seleciona_vendas_fechamento['descontototal']; ?></td>
      <td><?php echo $row_seleciona_vendas_fechamento['valortotal']; ?></td>
      <td><?php echo $row_seleciona_vendas_fechamento['valorparcela']; ?></td>
      <td><?php echo $row_seleciona_vendas_fechamento['parcela']; ?></td>
      <td><?php echo $row_seleciona_vendas_fechamento['prazoentreparcelas']; ?></td>
      <td><?php echo databrasil($row_seleciona_vendas_fechamento['datavencimento']); ?></td>
    </tr>
    <?php } while ($row_seleciona_vendas_fechamento = mysql_fetch_assoc($seleciona_vendas_fechamento)); ?>
</table>
<?php
mysql_free_result($seleciona_vendas_fechamento);

mysql_free_result($seleciona_formasdepagamento);
?>
