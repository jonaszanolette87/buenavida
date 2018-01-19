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

$maxRows_seleciona_produtos = 2000;
$pageNum_seleciona_produtos = 0;

if (isset($_GET['pageNum_seleciona_produtos'])) {
  $pageNum_seleciona_produtos = $_GET['pageNum_seleciona_produtos'];
}
$startRow_seleciona_produtos = $pageNum_seleciona_produtos * $maxRows_seleciona_produtos;


if(isset($_POST['campo']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];


mysql_select_db($database_conn, $conn);
$query_seleciona_produtos = "SELECT p.*, sg.nome as subgrupo, g.nome as grupo, m.nome as marca FROM produtos p
							
							LEFT JOIN grupos g
							ON p.id_grupo = g.id
							
							LEFT JOIN subgrupos sg
							ON p.id_subgrupo = sg.id
							
							
							LEFT JOIN marcas m
							ON p.id_marca= m.id
							
							WHERE p.$campo LIKE '%".$buscar."%' ORDER BY p.nome ASC";
							
$query_limit_seleciona_produtos = sprintf("%s LIMIT %d, %d", $query_seleciona_produtos, $startRow_seleciona_produtos, $maxRows_seleciona_produtos);
$seleciona_produtos = mysql_query($query_limit_seleciona_produtos, $conn) or die(mysql_error());
$row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos);

$maxRows_seleciona_produtos = 2000;

}
else {
	
	mysql_select_db($database_conn, $conn);
$query_seleciona_produtos = "SELECT p.*, sg.nome as subgrupo,g.nome as grupo, m.nome as marca FROM produtos p
							
							LEFT JOIN grupos g
							ON p.id_grupo = g.id
							
							LEFT JOIN subgrupos sg
							ON p.id_subgrupo = sg.id
							
							LEFT JOIN marcas m
							ON p.id_marca= m.id
							
							ORDER BY p.nome ASC";
$query_limit_seleciona_produtos = sprintf("%s LIMIT %d, %d", $query_seleciona_produtos, $startRow_seleciona_produtos, $maxRows_seleciona_produtos);
$seleciona_produtos = mysql_query($query_limit_seleciona_produtos, $conn) or die(mysql_error());
$row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos);
	
	
	
	}

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

<script type="text/javascript" src="../js/script.js"/></script>
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
      <th class="Titulo16"><strong><em>PRODUTOS:</em></strong></th>
  </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td width="97%" rowspan="2"><form id="form1" name="form1" method="post" action="">
   
      CAMPO:
      <label for="campo"></label>
      <select name="campo" id="campo">
        <option value="id">ID</option>
        <option value="codigo">CODIGO</option>
        <option value="nome" selected="selected">NOME</option>
      </select>
BUSCAR POR:
<label for="buscar"></label>
<input name="buscar" type="text" id="buscar" size="44" />
<input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" />
 </form></td>
    <th width="3%">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center"  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';"><span class="claro">
      <?php if ($cadastrarprodutos == "1"){?>
      <a href="#"  onclick="displayMessage('../produtos/cadastrar.php','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
    </span></td>
  </tr>
  <tr >
    <td colspan="2">
      <table width="100%">
        <tr>
          <th width="2%"><strong>ID</strong></th>
          <th width="35%"><strong>NOME</strong></th>
          <th width="10%">REFERENCIA</th>
          <th width="10%">GRUPO</th>
          <th width="5%">ESTOQUE</th>
          <th width="10%">VALOR VENDA</th>
          <th width="9%"><strong>ALTERAR</strong></th>
          <th width="8%"><strong>EXCLUIR</strong></th>
        </tr>
        <?php do { ?>
          <tr  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td align="right"><?php echo $row_seleciona_produtos['id']; ?></td>
            <td><?php echo $row_seleciona_produtos['nome']; ?></td>
            <td align="right"><?php echo $row_seleciona_produtos['referencia']; ?></td>
            <td><?php echo $row_seleciona_produtos['grupo']; ?></td>
            <td align="right"><?php 
			if ( $row_seleciona_produtos['estoque'] <= $row_seleciona_produtos['estoqueminimo']) { echo "<font color='#FF0000'>".$row_seleciona_produtos['estoque']."</font>"; }
			else {
			echo $row_seleciona_produtos['estoque'];
			}
			 ?></td>
            <td align="right"><?php echo $row_seleciona_produtos['precovenda']; ?></td>
            <td align="center"><?php if ($alterarprodutos == "1"){?>
              <a href="#"  onclick="displayMessage('../produtos/alterar.php?id=<?php echo $row_seleciona_produtos['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluirprodutos == "1"){?>
              <a href="#"  onclick="displayMessage('../produtos/excluir.php?id=<?php echo $row_seleciona_produtos['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_produtos = mysql_fetch_assoc($seleciona_produtos)); ?>
      </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;
      <table width="100" border="0">
        <tr>
          <td><?php if ($pageNum_seleciona_produtos > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, 0, $queryString_seleciona_produtos); ?>"><img src="../imagens/First.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_produtos > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, max(0, $pageNum_seleciona_produtos - 1), $queryString_seleciona_produtos); ?>"><img src="../imagens/Previous.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_produtos < $totalPages_seleciona_produtos) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, min($totalPages_seleciona_produtos, $pageNum_seleciona_produtos + 1), $queryString_seleciona_produtos); ?>"><img src="../imagens/Next.png" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_produtos < $totalPages_seleciona_produtos) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_produtos=%d%s", $currentPage, $totalPages_seleciona_produtos, $queryString_seleciona_produtos); ?>"><img src="../imagens/Last.png" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS:<?php echo $totalRows_seleciona_produtos ?></th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_produtos);
?>
