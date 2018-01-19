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

$maxRows_seleciona_paginas_site = 1;
$pageNum_seleciona_paginas_site = 0;
if (isset($_GET['pageNum_seleciona_paginas_site'])) {
  $pageNum_seleciona_paginas_site = $_GET['pageNum_seleciona_paginas_site'];
}
$startRow_seleciona_paginas_site = $pageNum_seleciona_paginas_site * $maxRows_seleciona_paginas_site;

mysql_select_db($database_conn, $conn);
$query_seleciona_paginas_site = "SELECT * FROM site";
$query_limit_seleciona_paginas_site = sprintf("%s LIMIT %d, %d", $query_seleciona_paginas_site, $startRow_seleciona_paginas_site, $maxRows_seleciona_paginas_site);
$seleciona_paginas_site = mysql_query($query_limit_seleciona_paginas_site, $conn) or die(mysql_error());
$row_seleciona_paginas_site = mysql_fetch_assoc($seleciona_paginas_site);

if (isset($_GET['totalRows_seleciona_paginas_site'])) {
  $totalRows_seleciona_paginas_site = $_GET['totalRows_seleciona_paginas_site'];
} else {
  $all_seleciona_paginas_site = mysql_query($query_seleciona_paginas_site);
  $totalRows_seleciona_paginas_site = mysql_num_rows($all_seleciona_paginas_site);
}
$totalPages_seleciona_paginas_site = ceil($totalRows_seleciona_paginas_site/$maxRows_seleciona_paginas_site)-1;
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
    <th colspan="2">PAGINAS DO SITE</th>
  </tr>
  <tr>
    <td width="96%" rowspan="2">&nbsp;</td>
    <th width="4%">ALTERAR</th>
  </tr>
  <tr>
    <td align="center"><a href="/sistema/paginas/alterar.php?id=<?php echo $row_seleciona_paginas_site['id']; ?>"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%">
        <tr>
          <th>ID</th>
          <th>Pedras</th>
          <th>Midia</th>
          <th>Compras</th>
          <th>Pagamentos</th>
          <th>Privacidade</th>
          <th>&nbsp;</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_seleciona_paginas_site['id']; ?></td>
            <td><?php echo $row_seleciona_paginas_site['pedras']; ?></td>
            <td><?php echo $row_seleciona_paginas_site['midia']; ?></td>
            <td><?php echo $row_seleciona_paginas_site['compras']; ?></td>
            <td><?php echo $row_seleciona_paginas_site['pagamentos']; ?></td>
            <td><?php echo $row_seleciona_paginas_site['privacidade']; ?></td>
            <td align="center"></td>
          </tr>
          <?php } while ($row_seleciona_paginas_site = mysql_fetch_assoc($seleciona_paginas_site)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_paginas_site);
?>
