<?php require_once('../Connections/conn.php');

include("../funcoes/funcoes.php"); ?>
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

$maxRows_seleciona_compras = 10;
$pageNum_seleciona_compras = 0;
if (isset($_GET['pageNum_seleciona_compras'])) {
  $pageNum_seleciona_compras = $_GET['pageNum_seleciona_compras'];
}
$startRow_seleciona_compras = $pageNum_seleciona_compras * $maxRows_seleciona_compras;

mysql_select_db($database_conn, $conn);
$query_seleciona_compras = "SELECT v.* , c.nome as fornecedor  FROM compras v
LEFT JOIN fornecedores c
ON v.id_fornecedor = c.id







";
$query_limit_seleciona_compras = sprintf("%s LIMIT %d, %d", $query_seleciona_compras, $startRow_seleciona_compras, $maxRows_seleciona_compras);
$seleciona_compras = mysql_query($query_limit_seleciona_compras, $conn) or die(mysql_error());
$row_seleciona_compras = mysql_fetch_assoc($seleciona_compras);

if (isset($_GET['totalRows_seleciona_compras'])) {
  $totalRows_seleciona_compras = $_GET['totalRows_seleciona_compras'];
} else {
  $all_seleciona_compras = mysql_query($query_seleciona_compras);
  $totalRows_seleciona_compras = mysql_num_rows($all_seleciona_compras);
}
$totalPages_seleciona_compras = ceil($totalRows_seleciona_compras/$maxRows_seleciona_compras)-1;

$queryString_seleciona_compras = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_compras") == false && 
        stristr($param, "totalRows_seleciona_compras") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_compras = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_compras = sprintf("&totalRows_seleciona_compras=%d%s", $totalRows_seleciona_compras, $queryString_seleciona_compras);
?>


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
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<table width="100%">
  <tr>
    <th colspan="2">COMPRAS</th>
  </tr>
  <tr>
    <td width="94%" rowspan="2"><form id="form1" name="form1" method="post" action="">
      CAMPO:
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
    </label>
    </form></td>
    <th width="6%">CADASTRA</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';"><span class="claro">
      <?php if ($cadastrarcompras == "1"){?>
      <a href="#"  onclick="displayMessage('../compras/cadastrar.php?id_compra=novo','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table width="100%">
        <tr>
          <th>ID</th>
          <th>FORNECEDOR</th>
          <th>DATA COMPRA</th>
          <th>STATUS</th>
          <th>ALTERAR</th>
          <th>EXCLUIR</th>
        </tr>
        <?php do { ?>
          <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_compras['id']; ?></td>
            <td><?php echo $row_seleciona_compras['fornecedor']; ?></td>
            <td><?php echo databrasil($row_seleciona_compras['datacompra']); ?></td>
            <td><?php echo $row_seleciona_compras['status']; ?></td>
            <td align="center"><?php if ($alterarcompras == "1"){?>
              <a href="#"  onclick="displayMessage('../compras/alterar.php?id=<?php echo $row_seleciona_compras['id']; ?>&id_compra=<?php echo $row_seleciona_compras['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluircompras == "1"){?>
              <a href="#&quot;"  onclick="displayMessage('../compras/excluir.php?id=<?php echo $row_seleciona_compras['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_compras = mysql_fetch_assoc($seleciona_compras)); ?>
      </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_compras > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras=%d%s", $currentPage, 0, $queryString_seleciona_compras); ?>"><img src="../imagens/First.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_compras > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras=%d%s", $currentPage, max(0, $pageNum_seleciona_compras - 1), $queryString_seleciona_compras); ?>"><img src="../imagens/Previous.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_compras < $totalPages_seleciona_compras) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras=%d%s", $currentPage, min($totalPages_seleciona_compras, $pageNum_seleciona_compras + 1), $queryString_seleciona_compras); ?>"><img src="../imagens/Next.png" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_compras < $totalPages_seleciona_compras) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras=%d%s", $currentPage, $totalPages_seleciona_compras, $queryString_seleciona_compras); ?>"><img src="../imagens/Last.png" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS : <?php echo $totalRows_seleciona_compras ?></th>
  </tr>
</table>
<?php
mysql_free_result($seleciona_compras);
?>
