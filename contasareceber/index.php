<?php require_once('../Connections/conn.php'); 

include("../funcoes/funcoes.php");?>
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

$maxRows_seleciona_contasareceber = 10;
$pageNum_seleciona_contasareceber = 0;
if (isset($_GET['pageNum_seleciona_contasareceber'])) {
  $pageNum_seleciona_contasareceber = $_GET['pageNum_seleciona_contasareceber'];
}
$startRow_seleciona_contasareceber = $pageNum_seleciona_contasareceber * $maxRows_seleciona_contasareceber;

mysql_select_db($database_conn, $conn);
$query_seleciona_contasareceber = "SELECT cp.*, f.nome as cliente, fp.nome as cartao FROM contasareceber cp
								
								LEFT JOIN clientes f 
								ON cp.id_cliente = f.id
								
								
								LEFT JOIN cartoes fp 
								ON cp.id_cartao = fp.id 
";
$query_limit_seleciona_contasareceber = sprintf("%s LIMIT %d, %d", $query_seleciona_contasareceber, $startRow_seleciona_contasareceber, $maxRows_seleciona_contasareceber);
$seleciona_contasareceber = mysql_query($query_limit_seleciona_contasareceber, $conn) or die(mysql_error());
$row_seleciona_contasareceber = mysql_fetch_assoc($seleciona_contasareceber);

if (isset($_GET['totalRows_seleciona_contasareceber'])) {
  $totalRows_seleciona_contasareceber = $_GET['totalRows_seleciona_contasareceber'];
} else {
  $all_seleciona_contasareceber = mysql_query($query_seleciona_contasareceber);
  $totalRows_seleciona_contasareceber = mysql_num_rows($all_seleciona_contasareceber);
}
$totalPages_seleciona_contasareceber = ceil($totalRows_seleciona_contasareceber/$maxRows_seleciona_contasareceber)-1;

$queryString_seleciona_contasareceber = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_contasareceber") == false && 
        stristr($param, "totalRows_seleciona_contasareceber") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_contasareceber = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_contasareceber = sprintf("&totalRows_seleciona_contasareceber=%d%s", $totalRows_seleciona_contasareceber, $queryString_seleciona_contasareceber);
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
    <th colspan="2"><img src="../imagens/contasapagar.jpg" width="50" height="50" align="absmiddle" />CONTAS A RECEBER</th>
  </tr>
  <tr>
    <td width="96%" rowspan="2">CAMPO:
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
</label></td>
    <th width="4%">CADASTRAR</th>
  </tr>
  <tr  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
    <td align="center"><span class="claro">
      <?php if ($cadastrarcontasareceber == "1"){?>
      <a href="#"  onclick="displayMessage('../contasareceber/cadastrar.php','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%">
      <tr>
        <th>ID</th>
        <th>N OC</th>
        <th>DATA CADASTRO</th>
        <th>DATA VENCIMENTO</th>
        <th>CLIENTE</th>
        <th>FORMA DE PAGAMENTO</th>
        <th>VALOR</th>
        <th>ALTERAR</th>
        <th>EXCLUIR</th>
      </tr>
      <?php do { ?>
      <tr  class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
        <td><?php echo $row_seleciona_contasareceber['id']; ?></td>
        <td><?php echo $row_seleciona_contasareceber['noc']; ?></td>
        <td><?php echo databrasil($row_seleciona_contasareceber['datacadastro']); ?></td>
        <td><?php echo databrasil($row_seleciona_contasareceber['datavencimento']); ?></td>
        <td><?php echo $row_seleciona_contasareceber['cliente']; ?></td>
        <td><?php echo $row_seleciona_contasareceber['cartao']; ?></td>
        <td><?php echo $row_seleciona_contasareceber['valortotal']; ?></td>
        <td align="center"><?php if ($alterarcontasareceber == "1"){?>
          <a href="#&quot;"  onclick="displayMessage('../contasareceber/alterar.php?id=<?php echo $row_seleciona_contasareceber['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
          <?php  } else {  ?>
          <?php } ?></td>
        <td align="center"><?php if ($excluircontasareceber == "1"){?>
          <a href="#&quot;"  onclick="displayMessage('../contasareceber/excluir.php?id=<?php echo $row_seleciona_contasareceber['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
          <?php  } else {  ?>
          <?php } ?></td>
      </tr>
      <?php } while ($row_seleciona_contasareceber = mysql_fetch_assoc($seleciona_contasareceber)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_contasareceber > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasareceber=%d%s", $currentPage, 0, $queryString_seleciona_contasareceber); ?>"><img src="../imagens/First.png" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_contasareceber > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasareceber=%d%s", $currentPage, max(0, $pageNum_seleciona_contasareceber - 1), $queryString_seleciona_contasareceber); ?>"><img src="../imagens/Previous.png" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_contasareceber < $totalPages_seleciona_contasareceber) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasareceber=%d%s", $currentPage, min($totalPages_seleciona_contasareceber, $pageNum_seleciona_contasareceber + 1), $queryString_seleciona_contasareceber); ?>"><img src="../imagens/Next.png" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_contasareceber < $totalPages_seleciona_contasareceber) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_contasareceber=%d%s", $currentPage, $totalPages_seleciona_contasareceber, $queryString_seleciona_contasareceber); ?>"><img src="../imagens/Last.png" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS : <?php echo $totalRows_seleciona_contasareceber ?></th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_contasareceber);
?>
