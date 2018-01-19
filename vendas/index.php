<?php require_once('../Connections/conn.php');

include("../funcoes/funcoes.php"); ?>
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

$maxRows_seleciona_vendas = 30;
$pageNum_seleciona_vendas = 0;
if (isset($_GET['pageNum_seleciona_vendas'])) {
  $pageNum_seleciona_vendas = $_GET['pageNum_seleciona_vendas'];
}
$startRow_seleciona_vendas = $pageNum_seleciona_vendas * $maxRows_seleciona_vendas;

mysql_select_db($database_conn, $conn);
$query_seleciona_vendas = "SELECT v.* , r.id as id_reserva, c.nome as cliente, u.login as atendente FROM vendas v


LEFT JOIN reservas r
ON v.id_cliente = r.id

INNER JOIN clientes c 
ON r.id_cliente = c.id





LEFT JOIN usuarios u
ON v.id_atendente = u.id


ORDER BY v.id DESC



";
$query_limit_seleciona_vendas = sprintf("%s LIMIT %d, %d", $query_seleciona_vendas, $startRow_seleciona_vendas, $maxRows_seleciona_vendas);
$seleciona_vendas = mysql_query($query_limit_seleciona_vendas, $conn) or die(mysql_error());
$row_seleciona_vendas = mysql_fetch_assoc($seleciona_vendas);

if (isset($_GET['totalRows_seleciona_vendas'])) {
  $totalRows_seleciona_vendas = $_GET['totalRows_seleciona_vendas'];
} else {
  $all_seleciona_vendas = mysql_query($query_seleciona_vendas);
  $totalRows_seleciona_vendas = mysql_num_rows($all_seleciona_vendas);
}
$totalPages_seleciona_vendas = ceil($totalRows_seleciona_vendas/$maxRows_seleciona_vendas)-1;

$queryString_seleciona_vendas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_vendas") == false && 
        stristr($param, "totalRows_seleciona_vendas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_vendas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_vendas = sprintf("&totalRows_seleciona_vendas=%d%s", $totalRows_seleciona_vendas, $queryString_seleciona_vendas);
?>


<link rel="stylesheet" href="../funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script><script type="text/javascript">
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

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<table width="100%">
  <tr>
    <th colspan="2">VENDAS</th>
  </tr>
  <tr>
    <td width="94%" rowspan="2"><form id="form1" name="form1" method="post" action="">
      CAMPO:
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
    </label>
    </form></td>
    <th width="6%">NOVA VENDA</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';"><span class="claro">
      <?php if ($cadastrarvendas == "1"){?>
      <a href="#"  onclick="displayMessage('../vendas/cadastrar.php?id_venda=novo','1050','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
      <?php  } else {  ?>
      <?php } ?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table width="100%">
        <tr>
          <th>ID</th>
          <th>NUMERO HOSPEDAGEM</th>
          <th>DATA CADASTRO</th>
          <th>HORA</th>
          <th>ATENDENTE</th>
          <th>SITUAÇÃO</th>
          <th>ALTERAR</th>
          <th>EXCLUIR</th>
          <th>RECIBO</th>
        </tr>
        <?php do { ?>
          <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_vendas['id']; ?></td>
            <td><?php echo $row_seleciona_vendas['id_reserva']."-".$row_seleciona_vendas['cliente']; ?></td>
            <td><?php echo databrasil($row_seleciona_vendas['datavenda']); ?></td>
            <td><?php echo $row_seleciona_vendas['hora']; ?></td>
            <td><?php echo $row_seleciona_vendas['atendente']; ?></td>
            <td><?php echo $row_seleciona_vendas['status']; ?></td>
            <td align="center"><?php if ($alterarvendas == "1"){
				
				?>
              <a href="#"  onclick="displayMessage('../vendas/alterar.php?id=<?php echo $row_seleciona_vendas['id']; ?>&id_venda=<?php echo $row_seleciona_vendas['id']; ?>','1050','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
              <?php 
			  
			  
			    } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluirvendas == "1"){?>
              <a href="#&quot;"  onclick="displayMessage('../vendas/excluir.php?id=<?php echo $row_seleciona_vendas['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><a href="../vendas/imprimir2.php?id=<?php echo $row_seleciona_vendas['id']; ?>" target="_blank"><img src="../imagens/relatorios.gif" width="17" height="15" /></a></td>
          </tr>
          <?php } while ($row_seleciona_vendas = mysql_fetch_assoc($seleciona_vendas)); ?>
      </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_vendas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_vendas=%d%s", $currentPage, 0, $queryString_seleciona_vendas); ?>"><img src="../imagens/First.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_vendas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_vendas=%d%s", $currentPage, max(0, $pageNum_seleciona_vendas - 1), $queryString_seleciona_vendas); ?>"><img src="../imagens/Previous.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_vendas < $totalPages_seleciona_vendas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_vendas=%d%s", $currentPage, min($totalPages_seleciona_vendas, $pageNum_seleciona_vendas + 1), $queryString_seleciona_vendas); ?>"><img src="../imagens/Next.png" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_vendas < $totalPages_seleciona_vendas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_vendas=%d%s", $currentPage, $totalPages_seleciona_vendas, $queryString_seleciona_vendas); ?>"><img src="../imagens/Last.png" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS : <?php echo $totalRows_seleciona_vendas ?></th>
  </tr>
</table>
<?php
mysql_free_result($seleciona_vendas);
?>
