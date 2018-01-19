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
  $insertSQL = sprintf("INSERT INTO contasareceber_recebimento (id,  id_formadepagamento,id_contasareceber, valortotal, datacompensacao) VALUES (%s, %s, %s, %s,  %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       
                       GetSQLValueString($_POST['id_formadepagamento'], "int"),
					   GetSQLValueString($_POST['id_contasareceber'], "int"),
                       GetSQLValueString($_POST['valortotal'], "text"),
                       GetSQLValueString(datausa($_POST['datacompensacao']), "date")
					   );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../contasareceber_recebimento/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_seleciona_contasareceber_recebimento = 10;
$pageNum_seleciona_contasareceber_recebimento = 0;
if (isset($_GET['pageNum_seleciona_contasareceber_recebimento'])) {
  $pageNum_seleciona_contasareceber_recebimento = $_GET['pageNum_seleciona_contasareceber_recebimento'];
}
$startRow_seleciona_contasareceber_recebimento = $pageNum_seleciona_contasareceber_recebimento * $maxRows_seleciona_contasareceber_recebimento;

$colname_seleciona_contasareceber_recebimento = "-1";
if (isset($_GET['id_contasareceber'])) {
  $colname_seleciona_contasareceber_recebimento = $_GET['id_contasareceber'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_contasareceber_recebimento = sprintf("SELECT vf.*, fp.nome as formadepagamento 

FROM contasareceber_recebimento  vf 

LEFT JOIN formasdepagamento fp
ON vf.id_formadepagamento = fp.id




WHERE id_contasareceber = %s", GetSQLValueString($colname_seleciona_contasareceber_recebimento, "int"));
$query_limit_seleciona_contasareceber_recebimento = sprintf("%s LIMIT %d, %d", $query_seleciona_contasareceber_recebimento, $startRow_seleciona_contasareceber_recebimento, $maxRows_seleciona_contasareceber_recebimento);
$seleciona_contasareceber_recebimento = mysql_query($query_limit_seleciona_contasareceber_recebimento, $conn) or die(mysql_error());
$row_seleciona_contasareceber_recebimento = mysql_fetch_assoc($seleciona_contasareceber_recebimento);

if (isset($_GET['totalRows_seleciona_contasareceber_recebimento'])) {
  $totalRows_seleciona_contasareceber_recebimento = $_GET['totalRows_seleciona_contasareceber_recebimento'];
} else {
  $all_seleciona_contasareceber_recebimento = mysql_query($query_seleciona_contasareceber_recebimento);
  $totalRows_seleciona_contasareceber_recebimento = mysql_num_rows($all_seleciona_contasareceber_recebimento);
}
$totalPages_seleciona_contasareceber_recebimento = ceil($totalRows_seleciona_contasareceber_recebimento/$maxRows_seleciona_contasareceber_recebimento)-1;

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
			 
				$.getJSON('../contasareceber_recebimento/valortotal.php?id_contasareceber=<?php echo $_GET['id_contasareceber']?>',
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
      <td nowrap><input type="hidden" name="id_contasareceber" value="<?php echo $_GET['id_contasareceber']?>" size="32">
        FORMA DE RECEBIMENTO:
        
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
    <th width="44%">FORMA DE RECEBIMENTO</th>
    <th width="25%">VALOR</th>
    <th width="26%">DATA COMPENSAÇÃO</th>
  </tr>
  <?php do { ?>
    <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <td><a href="../contasareceber_recebimento/excluir.php?id_contasareceber=<?php echo $row_seleciona_contasareceber_recebimento['id_contasareceber']; ?>&amp;id=<?php echo $row_seleciona_contasareceber_recebimento['id']; ?>"><img src="../imagens/del.png" alt="" width="20" height="20" /></a></td>
      <td><?php echo $row_seleciona_contasareceber_recebimento['formadepagamento']; ?></td>
      <td><?php echo $row_seleciona_contasareceber_recebimento['valortotal']; ?></td>
      <td><?php echo databrasil($row_seleciona_contasareceber_recebimento['datacompensacao']); ?></td>
    </tr>
    <?php } while ($row_seleciona_contasareceber_recebimento = mysql_fetch_assoc($seleciona_contasareceber_recebimento)); ?>
</table>
<?php
mysql_free_result($seleciona_contasareceber_recebimento);

mysql_free_result($seleciona_formasdepagamento);
?>
