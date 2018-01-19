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

$maxRows_seleciona_pedidos_sistema = 10;
$pageNum_seleciona_pedidos_sistema = 0;
if (isset($_GET['pageNum_seleciona_pedidos_sistema'])) {
  $pageNum_seleciona_pedidos_sistema = $_GET['pageNum_seleciona_pedidos_sistema'];
}
$startRow_seleciona_pedidos_sistema = $pageNum_seleciona_pedidos_sistema * $maxRows_seleciona_pedidos_sistema;


if(isset($_POST['buscar']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];

mysql_select_db($database_conn, $conn);
$query_seleciona_pedidos_sistema = "SELECT * FROM pedidos_sistema WHERE $campo LIKE '%".$buscar."%'";
$query_limit_seleciona_pedidos_sistema = sprintf("%s LIMIT %d, %d", $query_seleciona_pedidos_sistema, $startRow_seleciona_pedidos_sistema, $maxRows_seleciona_pedidos_sistema);
$seleciona_pedidos_sistema = mysql_query($query_limit_seleciona_pedidos_sistema, $conn) or die(mysql_error());
$row_seleciona_pedidos_sistema = mysql_fetch_assoc($seleciona_pedidos_sistema);
	
	
}
else{
mysql_select_db($database_conn, $conn);
$query_seleciona_pedidos_sistema = "SELECT * FROM  pedidos_sistema ORDER BY id DESC";
$query_limit_seleciona_pedidos_sistema = sprintf("%s LIMIT %d, %d", $query_seleciona_pedidos_sistema, $startRow_seleciona_pedidos_sistema, $maxRows_seleciona_pedidos_sistema);
$seleciona_pedidos_sistema = mysql_query($query_limit_seleciona_pedidos_sistema, $conn) or die(mysql_error());
$row_seleciona_pedidos_sistema = mysql_fetch_assoc($seleciona_pedidos_sistema);
}
if (isset($_GET['totalRows_seleciona_pedidos_sistema'])) {
  $totalRows_seleciona_pedidos_sistema = $_GET['totalRows_seleciona_pedidos_sistema'];
} else {
  $all_seleciona_pedidos_sistema = mysql_query($query_seleciona_pedidos_sistema);
  $totalRows_seleciona_pedidos_sistema = mysql_num_rows($all_seleciona_pedidos_sistema);
}
$totalPages_seleciona_pedidos_sistema = ceil($totalRows_seleciona_pedidos_sistema/$maxRows_seleciona_pedidos_sistema)-1;

$queryString_seleciona_pedidos_sistema = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_pedidos_sistema") == false && 
        stristr($param, "totalRows_seleciona_pedidos_sistema") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_pedidos_sistema = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_pedidos_sistema = sprintf("&totalRows_seleciona_pedidos_sistema=%d%s", $totalRows_seleciona_pedidos_sistema, $queryString_seleciona_pedidos_sistema);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<script src="../js/funcoes.js" type="text/javascript" /></script>


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
    <th colspan="2"><img hspace="2" src="../imagens/pedidos_sistema.png" width="40" height="40" align="absmiddle" />PEDIDOS DO SISTEMA</th>
  </tr>
  <tr>
    <td width="93%" rowspan="2">
    
    <form id="form1" name="form1" method="post" action="">
      
          <label>
        <select name="campo" id="campo">
          <option value="id">id</option>
          <option value="problema" selected="selected">PROBLEMA</option>
            <option value="solucao" selected="selected">SOLUCAO</option>
        </select>
      </label>
        
          <label>
      <input name="buscar" type="text" id="buscar" size="50" />
    </label>
    <label>
      <input type="submit" name="Entrar" id="Entrar" value=".::LOCALIZAR::." />
    </label>
    </form></td>
    <th width="7%" align="center">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';"><a href="#"  onClick="displayMessage('../pedidos_sistema/cadastrar.php','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" cellpadding="1" cellspacing="1">
        <tr bgcolor="#CCCCCC" >
          <th width="2%" nowrap="nowrap">ID</th>
          <th width="10%" nowrap="nowrap">DATA</th>
          <th width="50%" nowrap="nowrap">PROBLEMA</th>
          <th width="35%" nowrap="nowrap">SOLUCAO</th>
          <th width="6%" nowrap="nowrap">ALTERAR</th>
          <th width="6%" nowrap="nowrap">EXCLUIR</th>
        </tr>
        <?php do { ?>
          <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_pedidos_sistema['id']; ?></td>
            <td><?php echo $row_seleciona_pedidos_sistema['datacadastro']; ?></td>
            <td><?php echo $row_seleciona_pedidos_sistema['problema']; ?></td>
            <td><?php echo $row_seleciona_pedidos_sistema['solucao']; ?></td>
            <td align="center"><a href=#  onClick="displayMessage('../pedidos_sistema/alterar.php?id=<?php echo $row_seleciona_pedidos_sistema['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a></td>
            <td align="center"><a href=#  onClick="displayMessage('../pedidos_sistema/excluir.php?id=<?php echo $row_seleciona_pedidos_sistema['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a></td>
          </tr>
          <?php } while ($row_seleciona_pedidos_sistema = mysql_fetch_assoc($seleciona_pedidos_sistema)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_pedidos_sistema > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_pedidos_sistema=%d%s", $currentPage, 0, $queryString_seleciona_pedidos_sistema); ?>"><img src="../imagens/First.png" border="0" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_pedidos_sistema > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_pedidos_sistema=%d%s", $currentPage, max(0, $pageNum_seleciona_pedidos_sistema - 1), $queryString_seleciona_pedidos_sistema); ?>"><img src="../imagens/Previous.png" border="0" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_pedidos_sistema < $totalPages_seleciona_pedidos_sistema) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_pedidos_sistema=%d%s", $currentPage, min($totalPages_seleciona_pedidos_sistema, $pageNum_seleciona_pedidos_sistema + 1), $queryString_seleciona_pedidos_sistema); ?>"><img src="../imagens/Next.png" border="0" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_pedidos_sistema < $totalPages_seleciona_pedidos_sistema) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_pedidos_sistema=%d%s", $currentPage, $totalPages_seleciona_pedidos_sistema, $queryString_seleciona_pedidos_sistema); ?>"><img src="../imagens/Last.png" border="0" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS: <?php echo $totalRows_seleciona_pedidos_sistema ?></th>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($seleciona_pedidos_sistema);
?>
