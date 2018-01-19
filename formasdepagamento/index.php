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

$maxRows_seleciona_formasdepagamento = 10;
$pageNum_seleciona_formasdepagamento = 0;
if (isset($_GET['pageNum_seleciona_formasdepagamento'])) {
  $pageNum_seleciona_formasdepagamento = $_GET['pageNum_seleciona_formasdepagamento'];
}
$startRow_seleciona_formasdepagamento = $pageNum_seleciona_formasdepagamento * $maxRows_seleciona_formasdepagamento;


if(isset($_POST['buscar']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];

mysql_select_db($database_conn, $conn);
$query_seleciona_formasdepagamento = "SELECT * FROM formasdepagamento  
											
									WHERE $campo LIKE '%".$buscar."%'";
$query_limit_seleciona_formasdepagamento = sprintf("%s LIMIT %d, %d", $query_seleciona_formasdepagamento, $startRow_seleciona_formasdepagamento, $maxRows_seleciona_formasdepagamento);
$seleciona_formasdepagamento = mysql_query($query_limit_seleciona_formasdepagamento, $conn) or die(mysql_error());
$row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
	
	
}
else{
mysql_select_db($database_conn, $conn);
$query_seleciona_formasdepagamento = "SELECT * FROM formasdepagamento";
$query_limit_seleciona_formasdepagamento = sprintf("%s LIMIT %d, %d", $query_seleciona_formasdepagamento, $startRow_seleciona_formasdepagamento, $maxRows_seleciona_formasdepagamento);
$seleciona_formasdepagamento = mysql_query($query_limit_seleciona_formasdepagamento, $conn) or die(mysql_error());
$row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento);
}
if (isset($_GET['totalRows_seleciona_formasdepagamento'])) {
  $totalRows_seleciona_formasdepagamento = $_GET['totalRows_seleciona_formasdepagamento'];
} else {
  $all_seleciona_formasdepagamento = mysql_query($query_seleciona_formasdepagamento);
  $totalRows_seleciona_formasdepagamento = mysql_num_rows($all_seleciona_formasdepagamento);
}
$totalPages_seleciona_formasdepagamento = ceil($totalRows_seleciona_formasdepagamento/$maxRows_seleciona_formasdepagamento)-1;

$queryString_seleciona_formasdepagamento = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_formasdepagamento") == false && 
        stristr($param, "totalRows_seleciona_formasdepagamento") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_formasdepagamento = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_formasdepagamento = sprintf("&totalRows_seleciona_formasdepagamento=%d%s", $totalRows_seleciona_formasdepagamento, $queryString_seleciona_formasdepagamento);
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
    <th colspan="2"><img hspace="2" src="../imagens/formasdepagamento.jpg" width="30" height="30" align="absmiddle" />FORMAS DE PAGAMENTO</th>
  </tr>
  <tr>
    <td width="94%" rowspan="2"><form id="form1" name="form1" method="post" action="index.php">
      CAMPO:
          <label>
        <select name="campo" id="campo">
          <option value="id">id</option>
          <option value="nome" selected="selected">nome</option>
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
    <th width="6%" align="center">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <?php if ($cadastrarformasdepagamento == "1"){?>
      <a href="#"  onclick="displayMessage('../formasdepagamento/cadastrar.php','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" cellpadding="1" cellspacing="1">
        <tr bgcolor="#CCCCCC" >
          <th width="22%" height="28" nowrap="nowrap">ID</th>
          <th width="63%" nowrap="nowrap">NOME</th>
          <th width="8%" nowrap="nowrap">ALTERAR</th>
          <th width="7%" nowrap="nowrap">EXCLUIR</th>
        </tr>
        <?php do { ?>
          <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_formasdepagamento['id']; ?></td>
            <td><?php echo $row_seleciona_formasdepagamento['nome']; ?></td>
            <td align="center"><?php if ($alterarformasdepagamento == "1"){?>
              <a href=#"  onClick="displayMessage('../formasdepagamento/alterar.php?id=<?php echo $row_seleciona_formasdepagamento['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              
              
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluirformasdepagamento == "1"){?>
        <a href=#"  onClick="displayMessage('../formasdepagamento/excluir.php?id=<?php echo $row_seleciona_formasdepagamento['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
        
        
  <?php  } else {  ?>
      <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_formasdepagamento = mysql_fetch_assoc($seleciona_formasdepagamento)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_formasdepagamento > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_formasdepagamento=%d%s", $currentPage, 0, $queryString_seleciona_formasdepagamento); ?>"><img src="../imagens/First.png" border="0" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_formasdepagamento > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_formasdepagamento=%d%s", $currentPage, max(0, $pageNum_seleciona_formasdepagamento - 1), $queryString_seleciona_formasdepagamento); ?>"><img src="../imagens/Previous.png" border="0" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_formasdepagamento < $totalPages_seleciona_formasdepagamento) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_formasdepagamento=%d%s", $currentPage, min($totalPages_seleciona_formasdepagamento, $pageNum_seleciona_formasdepagamento + 1), $queryString_seleciona_formasdepagamento); ?>"><img src="../imagens/Next.png" border="0" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_formasdepagamento < $totalPages_seleciona_formasdepagamento) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_formasdepagamento=%d%s", $currentPage, $totalPages_seleciona_formasdepagamento, $queryString_seleciona_formasdepagamento); ?>"><img src="../imagens/Last.png" border="0" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS: <?php echo $totalRows_seleciona_formasdepagamento ?></th>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($seleciona_formasdepagamento);
?>
