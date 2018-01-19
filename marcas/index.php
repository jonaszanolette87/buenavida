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


$maxRows_seleciona_marcas = 10;
$pageNum_seleciona_marcas = 0;
if (isset($_GET['pageNum_seleciona_marcas'])) {
  $pageNum_seleciona_marcas = $_GET['pageNum_seleciona_marcas'];
}
$startRow_seleciona_marcas = $pageNum_seleciona_marcas * $maxRows_seleciona_marcas;


if(isset($_POST['campo']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];


mysql_select_db($database_conn, $conn);
$query_seleciona_marcas = "SELECT * FROM marcas WHERE $campo LIKE '%".$buscar."%' ORDER BY nome ASC";
$query_limit_seleciona_marcas = sprintf("%s LIMIT %d, %d", $query_seleciona_marcas, $startRow_seleciona_marcas, $maxRows_seleciona_marcas);
$seleciona_marcas = mysql_query($query_limit_seleciona_marcas, $conn) or die(mysql_error());
$row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
}else {
	
mysql_select_db($database_conn, $conn);
$query_seleciona_marcas = "SELECT * FROM marcas ORDER BY nome ASC";
$query_limit_seleciona_marcas = sprintf("%s LIMIT %d, %d", $query_seleciona_marcas, $startRow_seleciona_marcas, $maxRows_seleciona_marcas);
$seleciona_marcas = mysql_query($query_limit_seleciona_marcas, $conn) or die(mysql_error());
$row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
	
	
	}
if (isset($_GET['totalRows_seleciona_marcas'])) {
  $totalRows_seleciona_marcas = $_GET['totalRows_seleciona_marcas'];
} else {
  $all_seleciona_marcas = mysql_query($query_seleciona_marcas);
  $totalRows_seleciona_marcas = mysql_num_rows($all_seleciona_marcas);
}
$totalPages_seleciona_marcas = ceil($totalRows_seleciona_marcas/$maxRows_seleciona_marcas)-1;

$queryString_seleciona_marcas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_marcas") == false && 
        stristr($param, "totalRows_seleciona_marcas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_marcas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_marcas = sprintf("&totalRows_seleciona_marcas=%d%s", $totalRows_seleciona_marcas, $queryString_seleciona_marcas);
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
      <th width="30"><img src="../imagens/marcas.jpg" width="35" height="38" align="absmiddle" /></th>
      <th class="Titulo16"><strong><em><font color="#888888"> MARCAS:</font></em></strong></th>
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
        <option value="nome">NOME</option>
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
    
    <?php if ($cadastrarmarcas == "1"){?>
    <a href="#"  onClick="displayMessage('../marcas/cadastrar.php','500','450');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
    
    
  <?php  } else {  ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%">
      <tr>
        <th width="30%">ID</th>
        <th width="55%">NOME</th>
        <th width="8%">ALTERAR</th>
        <th width="7%">EXCLUIR</th>
      </tr>
      <?php do { ?>
      <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
        <td><?php echo $row_seleciona_marcas['id']; ?></td>
        <td><?php echo $row_seleciona_marcas['nome']; ?></td>
        <td align="center">
          
          <?php if ($alterarmarcas == "1"){?>
          <a href=#"  onClick="displayMessage('../marcas/alterar.php?id=<?php echo $row_seleciona_marcas['id']; ?>','500','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
          
          
          <?php  } else {  ?>
          <?php } ?>
          
        </td>
        <td align="center">
        
        <?php if ($excluirmarcas == "1"){?>
        <a href="#"  onClick="displayMessage('../marcas/excluir.php?id=<?php echo $row_seleciona_marcas['id']; ?>','500','450');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
        
        
  <?php  } else {  ?>
      <?php } ?>
        
        </td>
      </tr>
      <?php } while ($row_seleciona_marcas = mysql_fe