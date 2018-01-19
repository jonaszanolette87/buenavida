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

$maxRows_seleciona_compras_materiasprimas = 10;
$pageNum_seleciona_compras_materiasprimas = 0;
if (isset($_GET['pageNum_seleciona_compras_materiasprimas'])) {
  $pageNum_seleciona_compras_materiasprimas = $_GET['pageNum_seleciona_compras_materiasprimas'];
}
$startRow_seleciona_compras_materiasprimas = $pageNum_seleciona_compras_materiasprimas * $maxRows_seleciona_compras_materiasprimas;

mysql_select_db($database_conn, $conn);
$query_seleciona_compras_materiasprimas = "SELECT v.* , c.nome as fornecedor  FROM compras_materiasprimas v
LEFT JOIN fornecedores c
ON v.id_fornecedor = c.id







";
$query_limit_seleciona_compras_materiasprimas = sprintf("%s LIMIT %d, %d", $query_seleciona_compras_materiasprimas, $startRow_seleciona_compras_materiasprimas, $maxRows_seleciona_compras_materiasprimas);
$seleciona_compras_materiasprimas = mysql_query($query_limit_seleciona_compras_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_compras_materiasprimas = mysql_fetch_assoc($seleciona_compras_materiasprimas);

if (isset($_GET['totalRows_seleciona_compras_materiasprimas'])) {
  $totalRows_seleciona_compras_materiasprimas = $_GET['totalRows_seleciona_compras_materiasprimas'];
} else {
  $all_seleciona_compras_materiasprimas = mysql_query($query_seleciona_compras_materiasprimas);
  $totalRows_seleciona_compras_materiasprimas = mysql_num_rows($all_seleciona_compras_materiasprimas);
}
$totalPages_seleciona_compras_materiasprimas = ceil($totalRows_seleciona_compras_materiasprimas/$maxRows_seleciona_compras_materiasprimas)-1;

$queryString_seleciona_compras_materiasprimas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_compras_materiasprimas") == false && 
        stristr($param, "totalRows_seleciona_compras_materiasprimas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_compras_materiasprimas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_compras_materiasprimas = sprintf("&totalRows_seleciona_compras_materiasprimas=%d%s", $totalRows_seleciona_compras_materiasprimas, $queryString_seleciona_compras_materiasprimas);
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
    <th colspan="2">COMPRAS MATERIAS PRIMAS</th>
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
      <?php if ($cadastrarcompras_materiasprimas == "1"){?>
      <a href="#"  onclick="displayMessage('../compras_materiasprimas/cadastrar.php?id_compra=novo','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
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
            <td><?php echo $row_seleciona_compras_materiasprimas['id']; ?></td>
            <td><?php echo $row_seleciona_compras_materiasprimas['fornecedor']; ?></td>
            <td><?php echo databrasil($row_seleciona_compras_materiasprimas['datacompra']); ?></td>
            <td><?php echo $row_seleciona_compras_materiasprimas['status']; ?></td>
            <td align="center"><?php if ($alterarcompras_materiasprimas == "1"){?>
              <a href="#"  onclick="displayMessage('../compras_materiasprimas/alterar.php?id=<?php echo $row_seleciona_compras_materiasprimas['id']; ?>&id_compra=<?php echo $row_seleciona_compras_materiasprimas['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluircompras_materiasprimas == "1"){?>
              <a href="#&quot;"  onclick="displayMessage('../compras_materiasprimas/excluir.php?id=<?php echo $row_seleciona_compras_materiasprimas['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_compras_materiasprimas = mysql_fetch_assoc($seleciona_compras_materiasprimas)); ?>
      </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_compras_materiasprimas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras_materiasprimas=%d%s", $currentPage, 0, $queryString_seleciona_compras_materiasprimas); ?>"><img src="../imagens/First.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_compras_materiasprimas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras_materiasprimas=%d%s", $currentPage, max(0, $pageNum_seleciona_compras_materiasprimas - 1), $queryString_seleciona_compras_materiasprimas); ?>"><img src="../imagens/Previous.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_compras_materiasprimas < $totalPages_seleciona_compras_materiasprimas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras_materiasprimas=%d%s", $currentPage, min($totalPages_seleciona_compras_materiasprimas, $pageNum_seleciona_compras_materiasprimas + 1), $queryString_seleciona_compras_materiasprimas); ?>"><img src="../imagens/Next.png" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_compras_materiasprimas < $totalPages_seleciona_compras_materiasprimas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_compras_materiasprimas=%d%s", $currentPage, $totalPages_seleciona_compras_materiasprimas, $queryString_seleciona_compras_materiasprimas); ?>"><img src="../imagens/Last.png" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS : <?php echo $totalRows_seleciona_compras_materiasprimas ?></th>
  </tr>
</table>
<?php
mysql_free_result($seleciona_compras_materiasprimas);
?>
