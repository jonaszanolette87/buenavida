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

$maxRows_seleciona_materiasprimas = 10;
$pageNum_seleciona_materiasprimas = 0;
if (isset($_GET['pageNum_seleciona_materiasprimas'])) {
  $pageNum_seleciona_materiasprimas = $_GET['pageNum_seleciona_materiasprimas'];
}
$startRow_seleciona_materiasprimas = $pageNum_seleciona_materiasprimas * $maxRows_seleciona_materiasprimas;

mysql_select_db($database_conn, $conn);
$query_seleciona_materiasprimas = "SELECT mp.*, c.nome as categoria, u.nome as unidade, m.nome as marca FROM materiasprimas mp

								LEFT JOIN categorias c
								ON mp.id_categoria = c.id
								
								LEFT JOIN unidades u
								ON mp.id_unidade = u.id
								
								LEFT JOIN marcas m
								ON mp.id_marca = m.id
								

";
$query_limit_seleciona_materiasprimas = sprintf("%s LIMIT %d, %d", $query_seleciona_materiasprimas, $startRow_seleciona_materiasprimas, $maxRows_seleciona_materiasprimas);
$seleciona_materiasprimas = mysql_query($query_limit_seleciona_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_materiasprimas = mysql_fetch_assoc($seleciona_materiasprimas);




if (isset($_GET['totalRows_seleciona_materiasprimas'])) {
  $totalRows_seleciona_materiasprimas = $_GET['totalRows_seleciona_materiasprimas'];
} else {
  $all_seleciona_materiasprimas = mysql_query($query_seleciona_materiasprimas);
  $totalRows_seleciona_materiasprimas = mysql_num_rows($all_seleciona_materiasprimas);
}
$totalPages_seleciona_materiasprimas = ceil($totalRows_seleciona_materiasprimas/$maxRows_seleciona_materiasprimas)-1;

$queryString_seleciona_materiasprimas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_materiasprimas") == false && 
        stristr($param, "totalRows_seleciona_materiasprimas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_materiasprimas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_materiasprimas = sprintf("&totalRows_seleciona_materiasprimas=%d%s", $totalRows_seleciona_materiasprimas, $queryString_seleciona_materiasprimas);
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
    <th width="30"><img src="../imagens/materiasprimas2.png" alt="" width="30" height="30" align="absmiddle" /></th>
    <th > MATERIAS PRIMAS:</th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both" /><table width="100%">
  <tr>
    <td width="97%" rowspan="2"><form id="form1" name="form1" method="post" action="" class="niceform">
CAMPO:
      <label for="campo"></label>
      <select name="campo" id="campo">
        <option value="nome">NOME</option>
        <option value="email">E-MAIL</option>
      </select>
      BUSCAR POR:
      <label for="buscar"></label>
      <input name="buscar" type="text" id="buscar" size="44" />
      <input type="submit" name="Pesquisar" id="Pesquisar" value="LOCALIZAR" />
    </form></td>
    <th width="3%">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <?php if ($cadastrarmateriasprimas == "1"){?>
      <a href="#"  onclick="displayMessage('../materiasprimas/cadastrar.php','900','450');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
   </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table width="100%">
        <tr>
          <th>ID</th>
          <th>DESCRIÇÃO</th>
          <th>CATEGORIA</th>
          <th>MARCA</th>
          <th>UNIDADE</th>
          <th>ESTOQUE </th>
          <th>ATIVO</th>
          <th>ALTERAR</th>
          <th>EXCLUIR</th>
        </tr>
        <?php do { ?>
          <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_materiasprimas['id']; ?></td>
            <td><?php echo $row_seleciona_materiasprimas['nome']; ?></td>
            <td><?php echo $row_seleciona_materiasprimas['categoria']; ?></td>
            <td><?php echo $row_seleciona_materiasprimas['marca']; ?></td>
            <td><?php echo $row_seleciona_materiasprimas['unidade']; ?></td>
            <td><?php echo $row_seleciona_materiasprimas['estoque']; ?></td>
            <td><?php echo $row_seleciona_materiasprimas['ativo']; ?></td>
            <td align="center"><?php if ($alterarmateriasprimas == "1"){?>
              <a href="#"  onclick="displayMessage('../materiasprimas/alterar.php?id=<?php echo $row_seleciona_materiasprimas['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluirmateriasprimas == "1"){?>
              <a href="#"  onclick="displayMessage('../materiasprimas/excluir.php?id=<?php echo $row_seleciona_materiasprimas['id']; ?>','500','450');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_materiasprimas = mysql_fetch_assoc($seleciona_materiasprimas)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_materiasprimas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_materiasprimas=%d%s", $currentPage, 0, $queryString_seleciona_materiasprimas); ?>"><img src="../imagens/First.png" /></a>
            <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_materiasprimas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_materiasprimas=%d%s", $currentPage, max(0, $pageNum_seleciona_materiasprimas - 1), $queryString_seleciona_materiasprimas); ?>"><img src="../imagens/Previous.png" /></a>
            <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_materiasprimas < $totalPages_seleciona_materiasprimas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_materiasprimas=%d%s", $currentPage, min($totalPages_seleciona_materiasprimas, $pageNum_seleciona_materiasprimas + 1), $queryString_seleciona_materiasprimas); ?>"><img src="../imagens/Next.png" /></a>
            <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_materiasprimas < $totalPages_seleciona_materiasprimas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_materiasprimas=%d%s", $currentPage, $totalPages_seleciona_materiasprimas, $queryString_seleciona_materiasprimas); ?>"><img src="../imagens/Last.png" /></a>
            <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS : <?php echo $totalRows_seleciona_materiasprimas ?></th>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($seleciona_materiasprimas);
?>
