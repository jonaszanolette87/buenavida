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

$maxRows_seleciona_produtos = 10;
$pageNum_seleciona_produtos = 0;
if (isset($_GET['pageNum_seleciona_produtos'])) {
  $pageNum_seleciona_produtos = $_GET['pageNum_seleciona_produtos'];
}
$startRow_seleciona_produtos = $pageNum_seleciona_produtos * $maxRows_seleciona_produtos;

mysql_select_db($database_conn, $conn);
$query_seleciona_produtos = "SELECT p.*, g.nome as grupo, c.nome as categoria, m.nome as marca FROM produtos p
							
							LEFT JOIN grupos g
							ON p.id_grupo = g.id
							
							LEFT JOIN categorias c
							ON p.id_categoria = c.id
							
							LEFT JOIN marcas m
							ON p.id_marca= m.id
							
							WHERE destaque='S' 
							
							ORDER BY p.nome ASC";
							
$query_limit_seleciona_produtos = sprintf("%s LIMIT %d, %d", $query_seleciona_produtos, $startRow_seleciona_produtos, $maxRows_seleciona_produtos);
$seleciona_produtos = mysql_query($query_limit_seleciona_produtos, $conn) or die(mysql_error());
$row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos);

if (isset($_GET['totalRows_seleciona_produtos'])) {
  $totalRows_seleciona_produtos = $_GET['totalRows_seleciona_produtos'];
} else {
  $all_seleciona_produtos = mysql_query($query_seleciona_produtos);
  $totalRows_seleciona_produtos = mysql_num_rows($all_seleciona_produtos);
}
$totalPages_seleciona_produtos = ceil($totalRows_seleciona_produtos/$maxRows_seleciona_produtos)-1;

$queryString_seleciona_produtos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_produtos") == false && 
        stristr($param, "totalRows_seleciona_produtos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_produtos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_produtos = sprintf("&totalRows_seleciona_produtos=%d%s", $totalRows_seleciona_produtos, $queryString_seleciona_produtos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>


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
    <th width="30"><img src="../imagens/produtos.gif" width="28" height="28" align="absmiddle" /></th>
      <th class="Titulo16"><strong><em><font color="#888888"> DESTAQUES:</font></em></strong></th>
  </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>CAMPO:
      <label for="campo"></label>
      <select name="campo" id="campo">
        <option value="id">ID</option>
        <option value="nome" selected="selected">NOME</option>
      </select>
BUSCAR POR:
<label for="buscar"></label>
<input name="buscar" type="text" id="buscar" size="44" />
<input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" /></td>
  </tr>
  <tr >
    <td>
      <table width="100%">
        <tr>
          <th>ID</th>
          <th>CODIGO</th>
          <th>NOME</th>
          <th>PREÇO VENDA</th>
          <th>GRUPO</th>
          <th>CATEGORIA</th>
          <th>MARCA</th>
          <th>GARANTIA</th>
          <th>FOTO</th>
          <th>TIRAR DESTAQUE</th>
        </tr>
        <?php do { ?>
          <tr  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_produtos['id']; ?></td>
            <td><?php echo $row_seleciona_produtos['codigo']; ?></td>
            <td><?php echo $row_seleciona_produtos['nome']; ?></td>
            <td><?php echo $row_seleciona_produtos['precodevenda']; ?></td>
            <td><?php echo $row_seleciona_produtos['grupo']; ?></td>
            <td><?php echo $row_seleciona_produtos['categoria']; ?></td>
            <td><?php echo $row_seleciona_produtos['marca']; ?></td>
            <td><?php echo $row_seleciona_produtos['garantia']; ?></td>
            <td><?php echo "<img width=30px height=30px src=../site/fotos_produtos/".$row_seleciona_produtos['foto1'].">"; ?></td>
            <td align="center"><?php if ($alterarprodutos == "1"){?>
              <a href="#&quot;"  onclick="displayMessage('../destaques/alterar.php?id=<?php echo $row_seleciona_produtos['id']; ?>','250','250');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos)); ?>
      </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;
      <table width="100" border="0">
        <tr>
          <td><?php if ($pageNum_seleciona_produtos > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, 0, $queryString_seleciona_produtos); ?>"><img src="../imagens/First.gif" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_produtos > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, max(0, $pageNum_seleciona_produtos - 1), $queryString_seleciona_produtos); ?>"><img src="../imagens/Previous.gif" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_produtos < $totalPages_seleciona_produtos) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, min($totalPages_seleciona_produtos, $pageNum_seleciona_produtos + 1), $queryString_seleciona_produtos); ?>"><img src="../imagens/Next.gif" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_produtos < $totalPages_seleciona_produtos) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, $totalPages_seleciona_produtos, $queryString_seleciona_produtos); ?>"><img src="../imagens/Last.gif" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th>REGISTROS:<?php echo $totalRows_seleciona_produtos ?> DE :<?php echo ($startRow_seleciona_produtos + 1) ?> a <?php echo min($startRow_seleciona_produtos + $maxRows_seleciona_produtos, $totalRows_seleciona_produtos) ?></th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_produtos);
?>
