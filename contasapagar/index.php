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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_seleciona_contasapagar = 10;
$pageNum_seleciona_contasapagar = 0;
if (isset($_GET['pageNum_seleciona_contasapagar'])) {
  $pageNum_seleciona_contasapagar = $_GET['pageNum_seleciona_contasapagar'];
}
$startRow_seleciona_contasapagar = $pageNum_seleciona_contasapagar * $maxRows_seleciona_contasapagar;

mysql_select_db($database_conn, $conn);
$query_seleciona_contasapagar = "SELECT cp.*, f.nome as fornecedor, fp.nome as formadepagamento FROM contasapagar cp
								
								LEFT JOIN fornecedores f 
								ON cp.id_fornecedor = f.id
								
								
								LEFT JOIN formasdepagamento fp 
								ON cp.id_formadepagamento = fp.id 
";
$query_limit_seleciona_contasapagar = sprintf("%s LIMIT %d, %d", $query_seleciona_contasapagar, $startRow_seleciona_contasapagar, $maxRows_seleciona_contasapagar);
$seleciona_contasapagar = mysql_query($query_limit_seleciona_contasapagar, $conn) or die(mysql_error());
$row_seleciona_contasapagar = mysql_fetch_assoc($seleciona_contasapagar);

if (isset($_GET['totalRows_seleciona_contasapagar'])) {
  $totalRows_seleciona_contasapagar = $_GET['totalRows_seleciona_contasapagar'];
} else {
  $all_seleciona_contasapagar = mysql_query($query_seleciona_contasapagar);
  $totalRows_seleciona_contasapagar = mysql_num_rows($all_seleciona_contasapagar);
}
$totalPages_seleciona_contasapagar = ceil($totalRows_seleciona_contasapagar/$maxRows_seleciona_contasapagar)-1;

$queryString_seleciona_contasapagar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_contasapagar") == false && 
        stristr($param, "totalRows_seleciona_contasapagar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_contasapagar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_contasapagar = sprintf("&totalRows_seleciona_contasapagar=%d%s", $totalRows_seleciona_contasapagar, $queryString_seleciona_contasapagar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />


<link rel="stylesheet" href="../funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script>

<script type="text/javascript">
messageObj = new DHTML_modalMessage();	// We only create one object of this class
messageObj.setShadowOffset(5);	// Large shadow


function displayMessage(url,xx,yy)
{
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(xx,yy);
	messageObj.setShadowDivVisible(false);	// Enable shadow for these boxes
	messageObj.display();

}

function closeMessage()
{
	messageObj.close();	

}


</script>
</head>

<body>
<table width="100%">
  <tr>
    <th colspan="2"><img src="../imagens/financeiro.png" width="62" height="51" align="absmiddle" />CONTAS A PAGAR</th>
  </tr>
  <tr>
    <td width="96%" rowspan="2">CAMPO:
      <label>
        <select name="campo" id="campo">
          <option value="id">id</option>
          <option value="nome" selected="selected">NOME</option>
        </select>
      </label>
BUSCAR:
<label>
  <input name="buscar" type="text" id="buscar" size="50" />
</label>
<label>
  <input type="submit" name="Entrar" id="Entrar" value="Pesquisar" />
</label></td>
    <th width="4%">CADASTRAR</th>
  </tr>
  <tr  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
    <td align="center"><span class="claro">
      <?php if ($cadastrarcontasapagar == "1"){?>
      <a href="#"  onclick="displayMessage('../contasapagar/cadastrar.php','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%">
      <tr>
        <th>ID</th>
        <th>N COMPRA</th>
        <th>DATA CADASTRO</th>
        <th>DATA VENCIMENTO</th>
        <th>FORNECEDOR</th>
        <th>FORMA DE PAGAMENTO</th>
        <th>VALOR</th>
        <th>HISTORICO</th>
        <th>OBSERVAÇÕES</th>
        <th>ALTERAR</th>
        <th>EXCLUIR</th>
      </tr>
      <?php do { ?>
      <tr  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
        <td><?php echo $row_seleciona_contasapagar['id']; ?></td>
        <td><?php echo $row_seleciona_contasapagar['id_compra']; ?></td>
        <td><?php echo databrasil($row_seleciona_contasapagar['datacadastro']); ?></td>
        <td><?php echo databrasil($row_seleciona_contasapagar['datavencimento']); ?></td>
        <td><?php echo $row_seleciona_contasapagar['fornecedor']; ?></td>
        <td><?php echo $row_seleciona_contasapagar['formadepagamento']; ?></td>
        <td><?php echo $row_seleciona_contasapagar['valor']; ?></td>
        <td><?php echo $row_seleciona_contasapagar['historico']; ?></td>
        <td><?php echo $row_seleciona_contasapagar['observacoes']; ?></td>
        <td align="center"><?php if ($alterarcontasapagar == "1"){?>
          <a href="#&quot;"  onclick="displayMessage('../contasapagar/alterar.php?id=<?php echo $row_seleciona_contasapagar['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
          <?php  } else {  ?>
          <?php } ?></td>
        <td align="center"><?php if ($excluircontasapagar == "1"){?>
          <a href="#&quot;"  onclick="displayMessage('../contasapagar/excluir.php?id=<?php echo $row_seleciona_contasapagar['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
          <?php  } else {  ?>
          <?php } ?></td>
      </tr>
      <?php } while ($row_seleciona_contasapagar = mysql_fetch_assoc($seleciona_contasapagar)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_contasapagar > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasapagar=%d%s", $currentPage, 0, $queryString_seleciona_contasapagar); ?>"><img src="../imagens/First.png" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_contasapagar > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasapagar=%d%s", $currentPage, max(0, $pageNum_seleciona_contasapagar - 1), $queryString_seleciona_contasapagar); ?>"><img src="../imagens/Previous.png" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_contasapagar < $totalPages_seleciona_contasapagar) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasapagar=%d%s", $currentPage, min($totalPages_seleciona_contasapagar, $pageNum_seleciona_contasapagar + 1), $queryString_seleciona_contasapagar); ?>"><img src="../imagens/Next.png" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_contasapagar < $totalPages_seleciona_contasapagar) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasapagar=%d%s", $currentPage, $totalPages_seleciona_contasapagar, $queryString_seleciona_contasapagar); ?>"><img src="../imagens/Last.png" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS : <?php echo $totalRows_seleciona_contasapagar ?></th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_contasapagar);
?>
