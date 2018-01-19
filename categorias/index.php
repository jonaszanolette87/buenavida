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

$currentPage = $_SERVER["PHP_SELF"];


$maxRows_seleciona_categorias = 10;
$pageNum_seleciona_categorias = 0;
if (isset($_GET['pageNum_seleciona_categorias'])) {
  $pageNum_seleciona_categorias = $_GET['pageNum_seleciona_categorias'];
}
$startRow_seleciona_categorias = $pageNum_seleciona_categorias * $maxRows_seleciona_categorias;


if(isset($_POST['campo']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];


mysql_select_db($database_conn, $conn);
$query_seleciona_categorias = "SELECT * FROM categorias WHERE $campo LIKE '%".$buscar."%' ORDER BY nome ASC";
$query_limit_seleciona_categorias = sprintf("%s LIMIT %d, %d", $query_seleciona_categorias, $startRow_seleciona_categorias, $maxRows_seleciona_categorias);
$seleciona_categorias = mysql_query($query_limit_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
}else {
	
mysql_select_db($database_conn, $conn);
$query_seleciona_categorias = "SELECT * FROM categorias ORDER BY nome ASC";
$query_limit_seleciona_categorias = sprintf("%s LIMIT %d, %d", $query_seleciona_categorias, $startRow_seleciona_categorias, $maxRows_seleciona_categorias);
$seleciona_categorias = mysql_query($query_limit_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
	
	
	}
if (isset($_GET['totalRows_seleciona_categorias'])) {
  $totalRows_seleciona_categorias = $_GET['totalRows_seleciona_categorias'];
} else {
  $all_seleciona_categorias = mysql_query($query_seleciona_categorias);
  $totalRows_seleciona_categorias = mysql_num_rows($all_seleciona_categorias);
}
$totalPages_seleciona_categorias = ceil($totalRows_seleciona_categorias/$maxRows_seleciona_categorias)-1;

$queryString_seleciona_categorias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_categorias") == false && 
        stristr($param, "totalRows_seleciona_categorias") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_categorias = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_categorias = sprintf("&totalRows_seleciona_categorias=%d%s", $totalRows_seleciona_categorias, $queryString_seleciona_categorias);
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
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="30"><img src="../imagens/categorias.jpg" width="32" height="32" align="absmiddle" /></th>
      <th class="Titulo16"><strong><em><font color="#888888"> CATEGORIAS:</font></em></strong></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  
<table width="100%">
  <tr>
    <td width="91%" rowspan="2"><form id="form1" name="form1" method="post" action="">
CAMPO:
      <label for="campo"></label>
      <select name="campo" id="campo">
        <option value="id">ID</option>
        <option value="nome" selected="selected">NOME</option>
      </select>
      BUSCAR POR:
      <label for="buscar"></label>
      <input name="buscar" type="text" id="buscar" size="44" />
      <input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" />
    </form></td>
    <th width="9%">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
    
    <?php if ($cadastrarcategorias == "1"){?>
    <a href="#"  onClick="displayMessage('../categorias/cadastrar.php','500','450');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
    
    
  <?php  } else {  ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%">
      <tr>
        <th width="1%">ID</th>
        <th width="10%">NOME</th>
        <th width="10%"> MINIMO PAX</th>
        <th width="10%">MAXIMO PAX</th>
        <th width="10%">CAMAS</th>
        <th width="10%">METRAGEM</th>
        <th width="8%">ALTERAR</th>
        <th width="8%">EXCLUIR</th>
      </tr>
      <?php do { ?>
      <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
        <td><?php echo $row_seleciona_categorias['id']; ?></td>
        <td><?php echo $row_seleciona_categorias['nome']; ?></td>
        <td><?php echo $row_seleciona_categorias['min_pax']; ?></td>
        <td><?php echo $row_seleciona_categorias['max_pax']; ?></td>
        <td><?php echo $row_seleciona_categorias['camas']; ?></td>
        <td><?php echo $row_seleciona_categorias['metragem']; ?></td>
        <td align="center">
          
          <?php if ($alterarcategorias == "1"){?>
          <a href=#"  onClick="displayMessage('../categorias/alterar.php?id=<?php echo $row_seleciona_categorias['id']; ?>','500','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
          
          
          <?php  } else {  ?>
          <?php } ?>
          
        </td>
        <td align="center">
        
        <?php if ($excluircategorias == "1"){?>
        <a href="#"  onClick="displayMessage('../categorias/excluir.php?id=<?php echo $row_seleciona_categorias['id']; ?>','500','450');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
        
        
  <?php  } else {  ?>
      <?php } ?>
        
        </td>
      </tr>
      <?php } while ($row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_categorias > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_categorias=%d%s", $currentPage, 0, $queryString_seleciona_categorias); ?>"><img src="../imagens/First.gif" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_categorias > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_categorias=%d%s", $currentPage, max(0, $pageNum_seleciona_categorias - 1), $queryString_seleciona_categorias); ?>"><img src="../imagens/Previous.gif" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_categorias < $totalPages_seleciona_categorias) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_categorias=%d%s", $currentPage, min($totalPages_seleciona_categorias, $pageNum_seleciona_categorias + 1), $queryString_seleciona_categorias); ?>"><img src="../imagens/Next.gif" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_categorias < $totalPages_seleciona_categorias) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_categorias=%d%s", $currentPage, $totalPages_seleciona_categorias, $queryString_seleciona_categorias); ?>"><img src="../imagens/Last.gif" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS:<?php echo $totalRows_seleciona_categorias ?></th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
</body>
</html>
<?php
mysql_free_result($seleciona_categorias);
?>
