<?php require_once('../Connections/conn.php'); 

require_once('../funcoes/funcoes.php');
?>
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


$maxRows_seleciona_reservas = 300;
$pageNum_seleciona_reservas = 0;
if (isset($_GET['pageNum_seleciona_reservas'])) {
  $pageNum_seleciona_reservas = $_GET['pageNum_seleciona_reservas'];
}
$startRow_seleciona_reservas = $pageNum_seleciona_reservas * $maxRows_seleciona_reservas;


if(isset($_POST['campo']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];


mysql_select_db($database_conn, $conn);
$query_seleciona_reservas = "SELECT r.* , q.nome as nome_apt, f.nome as fornecedor, c.nome as cliente FROM reservas r

LEFT JOIN quartos q
							ON r.id_quarto= q.id
							
							LEFT JOIN fornecedores f
							ON r.id_fornecedor= f.id
  
                            LEFT JOIN clientes c
							ON r.id_cliente = c.id



WHERE $campo LIKE '%".$buscar."%' AND r.chegada >= CURDATE( )

ORDER BY r.chegada ASC";
$query_limit_seleciona_reservas = sprintf("%s LIMIT %d, %d", $query_seleciona_reservas, $startRow_seleciona_reservas, $maxRows_seleciona_reservas);
$seleciona_reservas = mysql_query($query_limit_seleciona_reservas, $conn) or die(mysql_error());
$row_seleciona_reservas = mysql_fetch_assoc($seleciona_reservas);
}else {
	
mysql_select_db($database_conn, $conn);
$query_seleciona_reservas = "SELECT  r.* , q.nome as nome_apt, f.nome as fornecedor, c.nome as cliente FROM reservas r

LEFT JOIN quartos q
							ON r.id_quarto= q.id
  
LEFT JOIN fornecedores f
							ON r.id_fornecedor= f.id
                                            LEFT JOIN clientes c
							ON r.id_cliente = c.id
WHERE  r.chegada >= CURDATE( )
ORDER BY r.chegada ASC";
$query_limit_seleciona_reservas = sprintf("%s LIMIT %d, %d", $query_seleciona_reservas, $startRow_seleciona_reservas, $maxRows_seleciona_reservas);
$seleciona_reservas = mysql_query($query_limit_seleciona_reservas, $conn) or die(mysql_error());
$row_seleciona_reservas = mysql_fetch_assoc($seleciona_reservas);
	
	
	}
if (isset($_GET['totalRows_seleciona_reservas'])) {
  $totalRows_seleciona_reservas = $_GET['totalRows_seleciona_reservas'];
} else {
  $all_seleciona_reservas = mysql_query($query_seleciona_reservas);
  $totalRows_seleciona_reservas = mysql_num_rows($all_seleciona_reservas);
}
$totalPages_seleciona_reservas = ceil($totalRows_seleciona_reservas/$maxRows_seleciona_reservas)-1;

$queryString_seleciona_reservas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_reservas") == false && 
        stristr($param, "totalRows_seleciona_reservas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_reservas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_reservas = sprintf("&totalRows_seleciona_reservas=%d%s", $totalRows_seleciona_reservas, $queryString_seleciona_reservas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">

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
      <th width="30"><img src="../imagens/campainha.png" width="30" height="30" align="absmiddle" /></th>
      <th class="Titulo16"><strong><em><font color="#888888"> CHECKIN:</font></em></strong></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  
<table width="100%">
  <tr>
    <td width="97%" rowspan="2"><form id="form1" name="form1" method="post" action="">
CAMPO:
      <label for="campo"></label>
      <select name="campo" id="campo">
        <option value="id_reserva" selected="selected">ID RESERVA</option>
        <option value="fornecedor" >FORNECEDOR</option>
        <option value="hospede" >HOSPEDE</option>
        <option value="chegada" >DATA CHEGADA</option>
        <option value="saida" >DATA SAIDA</option>
        <option value="local_realocado" >LOCAL REALOCADO</option>
        <option value="status" >STATUS</option>
      </select>
      BUSCAR POR:
      <label for="buscar"></label>
      <input name="buscar" type="text" id="buscar" size="44" />
      <input type="submit" name="Pesquisar" id="Pesquisar" value="PESQUISAR" />
    </form></td>
    <th width="1%">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
    
    <?php if ($cadastrarreservas == "1"){?>
    <a href="#"  onClick="displayMessage('../reservas/cadastrar.php','990','640');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
    
    
  <?php  } else {  ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%">
      <tr>
        <th width="1%">ID</th>
        <th width="6%">FORNECEDOR</th>
        <th width="6%">ID RESERVA</th>
        <th width="1%">DATA RESERVA</th>
        <th width="6%">NOME DO CLIENTE</th>
        <th width="6%">DATA DA CHEGADA</th>
        <th width="6%">DATA DA SAÍDA</th>
        <th width="6%">N DE NOITES</th>
        <th width="6%">APT</th>
        <th width="6%">PESSOAS</th>
        <th width="6%">VALOR A RECEBER NO CHECK IN</th>
        <th width="6%">STATUS</th>
        <th width="6%">USER</th>
        <th width="1%">ALTERAR</th>
        <th width="1%">EXCLUIR</th>
        <th width="1%">VOUCHER</th>
      </tr>
      <?php do { ?>
      <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
        <td><?php echo $row_seleciona_reservas['id']; ?></td>
        <td><?php echo $row_seleciona_reservas['fornecedor']; ?></td>
        <td><?php echo $row_seleciona_reservas['id_reserva']; ?></td>
        <td><?php echo $row_seleciona_reservas['data_reserva']; ?></td>
        <td><?php echo $row_seleciona_reservas['cliente']; ?></td>
        <td>
		
		<?php echo substr($row_seleciona_reservas['chegada'],8,2)."/".substr($row_seleciona_reservas['chegada'],5,2)."/".substr($row_seleciona_reservas['chegada'],0,4);
		 ?></td>
        <td><?php echo substr($row_seleciona_reservas['saida'],8,2)."/".substr($row_seleciona_reservas['saida'],5,2)."/".substr($row_seleciona_reservas['saida'],0,4);
		 ?></td>
        <td><?php echo $row_seleciona_reservas['n_noites']; ?></td>
        <td><?php echo $row_seleciona_reservas['nome_apt']; ?></td>
        <td><?php echo $row_seleciona_reservas['qtd_pass']; ?></td>
        <td>R$ <?php echo number_format($row_seleciona_reservas['cobro_adiantamento'], 2, ',', '.');
	?></td>
        <td><?php echo $row_seleciona_reservas['status']; ?></td>
        <td><?php echo substr($row_seleciona_reservas['usuario'],0,4); ?></td>
        <td align="center">
          
          <?php if ($alterarreservas == "1"){?>
          <a href=#"  onClick="displayMessage('../reservas/alterar.php?id=<?php echo $row_seleciona_reservas['id']; ?>','990','690');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
          
          
          <?php  } else {  ?>
          <?php } ?>
          
        </td>
        <td align="center">
        
        <?php if ($excluirreservas == "1"){?>
        <a href="#"  onClick="displayMessage('../reservas/excluir.php?id=<?php echo $row_seleciona_reservas['id']; ?>','990','450');return false"><img src="../imagens/del.png" width="20" height="20" alt="exc" /></a>
        
        
  <?php  } else {  ?>
      <?php } ?>
        
        </td>
        <td align="center"><a href="../voucher/index.php?ID=<?php echo $row_seleciona_reservas['id']; ?>" target="_blank"><img src="../imagens/configuracoes.gif" width="28" height="28" alt=""/></a></td>
      </tr>
      <?php } while ($row_seleciona_reservas = mysql_fetch_assoc($seleciona_reservas)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_reservas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_reservas=%d%s", $currentPage, 0, $queryString_seleciona_reservas); ?>"><img src="../imagens/First.gif" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_reservas > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_reservas=%d%s", $currentPage, max(0, $pageNum_seleciona_reservas - 1), $queryString_seleciona_reservas); ?>"><img src="../imagens/Previous.gif" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_reservas < $totalPages_seleciona_reservas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_reservas=%d%s", $currentPage, min($totalPages_seleciona_reservas, $pageNum_seleciona_reservas + 1), $queryString_seleciona_reservas); ?>"><img src="../imagens/Next.gif" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_reservas < $totalPages_seleciona_reservas) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_reservas=%d%s", $currentPage, $totalPages_seleciona_reservas, $queryString_seleciona_reservas); ?>"><img src="../imagens/Last.gif" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS:<?php echo $totalRows_seleciona_reservas ?></th>
  </tr>
</table>
<hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
</body>
</html>
<?php
mysql_free_result($seleciona_reservas);
?>
