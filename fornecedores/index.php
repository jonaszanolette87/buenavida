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

$maxRows_seleciona_fornecedores = 10;
$pageNum_seleciona_fornecedores = 0;
if (isset($_GET['pageNum_seleciona_fornecedores'])) {
  $pageNum_seleciona_fornecedores = $_GET['pageNum_seleciona_fornecedores'];
}
$startRow_seleciona_fornecedores = $pageNum_seleciona_fornecedores * $maxRows_seleciona_fornecedores;



if(isset($_POST['campo']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];

mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT c.*, v.nome as vendedor FROM fornecedores c
								LEFT JOIN vendedores v
								ON c.id_vendedor = v.id
								WHERE c.$campo LIKE '%".$buscar."%' ORDER BY c.nome ASC";
$query_limit_seleciona_fornecedores = sprintf("%s LIMIT %d, %d", $query_seleciona_fornecedores, $startRow_seleciona_fornecedores, $maxRows_seleciona_fornecedores);
$seleciona_fornecedores = mysql_query($query_limit_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);


$maxRows_seleciona_fornecedores = 100;

}


else {
	
	mysql_select_db($database_conn, $conn);
$query_seleciona_fornecedores = "SELECT c.*, v.nome as vendedor FROM fornecedores c
								LEFT JOIN vendedores v
								ON c.id_vendedor = v.id
								ORDER BY c.nome ASC";
$query_limit_seleciona_fornecedores = sprintf("%s LIMIT %d, %d", $query_seleciona_fornecedores, $startRow_seleciona_fornecedores, $maxRows_seleciona_fornecedores);
$seleciona_fornecedores = mysql_query($query_limit_seleciona_fornecedores, $conn) or die(mysql_error());
$row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores);

	
	
	
	}
if (isset($_GET['totalRows_seleciona_fornecedores'])) {
  $totalRows_seleciona_fornecedores = $_GET['totalRows_seleciona_fornecedores'];
} else {
  $all_seleciona_fornecedores = mysql_query($query_seleciona_fornecedores);
  $totalRows_seleciona_fornecedores = mysql_num_rows($all_seleciona_fornecedores);
}
$totalPages_seleciona_fornecedores = ceil($totalRows_seleciona_fornecedores/$maxRows_seleciona_fornecedores)-1;

$queryString_seleciona_fornecedores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_fornecedores") == false && 
        stristr($param, "totalRows_seleciona_fornecedores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_fornecedores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_fornecedores = sprintf("&totalRows_seleciona_fornecedores=%d%s", $totalRows_seleciona_fornecedores, $queryString_seleciona_fornecedores);
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
      <th width="30"><img src="../imagens/fornecedores.png" width="30" height="30" align="absmiddle" /></th>
      <th class="Titulo16"><strong><em><font color="#888888"> FORNECEDORES:</font></em></strong></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <table width="100%">
    <tr>
      <td width="93%" rowspan="2"><form id="form1" name="form1" method="post" action="">
        CAMPO:
        <label for="campo"></label>
        <select name="campo" id="campo">
          <option value="id">ID</option>
          <option value="nome" selected="selected">NOME</option>
          <option value="endereco">ENDEREÇO</option>
          <option value="fone">FONE</option>
          <option value="email">EMAIL</option>
        </select>
        BUSCAR POR:
  <label for="buscar"></label>
  <input name="buscar" type="text" id="buscar" size="44" />
  <input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" />
      </form></td>
      <th width="7%">CADASTRAR</th>
    </tr>
    <tr>
      <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';"><span class="claro">
        <?php if ($cadastrarfornecedores == "1"){?>
        <a href="#"  onclick="displayMessage('../fornecedores/cadastrar.php','800','650');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
        <?php  } else {  ?>
        <?php } ?>
      </span></td>
    </tr>
    <tr>
      <td colspan="2">
        <table width="100%">
          <tr>
            <th>ID</th>
            <th>TIPO</th>
            <th>NOME</th>
            <th>COMISSAO / COMISSAO 2</th>
            <th>FONE1</th>
            <th>FONE2</th>

            <th>EMAIL</th>
            <th>ALTERAR</th>
            <th>EXCLUIR</th>
          </tr>
          <?php do { ?>
            <tr align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
              <td><?php echo $row_seleciona_fornecedores['id']; ?></td>
              <td align="left"><?php echo $row_seleciona_fornecedores['tipo']; ?></td>
              <td align="left"><?php echo $row_seleciona_fornecedores['nome']; ?></td>
              <td align="left"><?php echo $row_seleciona_fornecedores['comissao']; ?>%  / <?php echo $row_seleciona_fornecedores['comissao2']; ?>% </td>
              <td align="left"><?php echo $row_seleciona_fornecedores['fone1']; ?></td>
              <td align="left"><?php echo $row_seleciona_fornecedores['fone2']; ?></td>

              <td align="left"><?php echo $row_seleciona_fornecedores['email']; ?></td>
              <td><?php if ($alterarfornecedores == "1"){?>
                <a href="#&quot;"  onclick="displayMessage('../fornecedores/alterar.php?id=<?php echo $row_seleciona_fornecedores['id']; ?>','800','650');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
                <?php  } else {  ?>
              <?php } ?></td>
              <td><?php if ($excluirfornecedores == "1"){?>
                <a href="#"  onclick="displayMessage('../fornecedores/excluir.php?id=<?php echo $row_seleciona_fornecedores['id']; ?>','500','450');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
                <?php  } else {  ?>
              <?php } ?></td>
            </tr>
            <?php } while ($row_seleciona_fornecedores = mysql_fetch_assoc($seleciona_fornecedores)); ?>
        </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;
        <table border="0" align="center">
          <tr>
            <td><?php if ($pageNum_seleciona_fornecedores > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_seleciona_fornecedores=%d%s", $currentPage, 0, $queryString_seleciona_fornecedores); ?>"><img src="../imagens/First.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_seleciona_fornecedores > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_seleciona_fornecedores=%d%s", $currentPage, max(0, $pageNum_seleciona_fornecedores - 1), $queryString_seleciona_fornecedores); ?>"><img src="../imagens/Previous.gif" /></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_seleciona_fornecedores < $totalPages_seleciona_fornecedores) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_seleciona_fornecedores=%d%s", $currentPage, min($totalPages_seleciona_fornecedores, $pageNum_seleciona_fornecedores + 1), $queryString_seleciona_fornecedores); ?>"><img src="../imagens/Next.gif" /></a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_seleciona_fornecedores < $totalPages_seleciona_fornecedores) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_seleciona_fornecedores=%d%s", $currentPage, $totalPages_seleciona_fornecedores, $queryString_seleciona_fornecedores); ?>"><img src="../imagens/Last.gif" /></a>
                <?php } // Show if not last page ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <th colspan="2">REGISTROS: <?php echo $totalRows_seleciona_fornecedores ?> DE : <?php echo ($startRow_seleciona_fornecedores + 1) ?> A <?php echo min($startRow_seleciona_fornecedores + $maxRows_seleciona_fornecedores, $totalRows_seleciona_fornecedores) ?></th>
    </tr>
  </table>
</body>
</html>
<?php
mysql_free_result($seleciona_fornecedores);
?>
