<?php require_once('../Connections/conn.php');
include ('../funcoes/funcoes.php') ?>
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

$maxRows_seleciona_movimentodiario = 10;
$pageNum_seleciona_movimentodiario = 0;
if (isset($_GET['pageNum_seleciona_movimentodiario'])) {
  $pageNum_seleciona_movimentodiario = $_GET['pageNum_seleciona_movimentodiario'];
}
$startRow_seleciona_movimentodiario = $pageNum_seleciona_movimentodiario * $maxRows_seleciona_movimentodiario;



if(isset($_POST['buscar']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];

mysql_select_db($database_conn, $conn);
$query_seleciona_movimentodiario = "SELECT md.*, pc.descricao as contadespesareceita, pc.tipo as tipo, pc2.descricao as   contacaixabanco , cc.nome as  centrodecusto 

								FROM movimentodiario md
								
								LEFT JOIN  planodecontas pc
								ON  md.id_contadespesareceita =  pc.id
								
	
								LEFT JOIN  planodecontas pc2
								ON  md.id_contacaixabanco =  pc2.id
								
								
								LEFT JOIN  centrodecusto cc
								ON  md.id_centrodecusto =  cc.id
					
							WHERE $campo LIKE '%".$buscar."%'";
$query_limit_seleciona_movimentodiario = sprintf("%s LIMIT %d, %d", $query_seleciona_movimentodiario, $startRow_seleciona_movimentodiario, $maxRows_seleciona_movimentodiario);
$seleciona_movimentodiario = mysql_query($query_limit_seleciona_movimentodiario, $conn) or die(mysql_error());
$row_seleciona_movimentodiario = mysql_fetch_assoc($seleciona_movimentodiario);
	
	
}
else{
mysql_select_db($database_conn, $conn);
$query_seleciona_movimentodiario = "SELECT md.*, pc.descricao as contadespesareceita, pc2.descricao as  contacaixabanco , cc.nome as  centrodecustos, pc.tipo as tipo FROM movimentodiario md
								LEFT JOIN  planodecontas pc
								ON  md.id_contadespesareceita =  pc.id
					
								LEFT JOIN  planodecontas pc2
								ON  md.id_contacaixabanco =  pc2.id
								
								LEFT JOIN  centrodecustos cc
								ON  md.id_centrodecusto =  cc.id
					
";
$query_limit_seleciona_movimentodiario = sprintf("%s LIMIT %d, %d", $query_seleciona_movimentodiario, $startRow_seleciona_movimentodiario, $maxRows_seleciona_movimentodiario);
$seleciona_movimentodiario = mysql_query($query_limit_seleciona_movimentodiario, $conn) or die(mysql_error());
$row_seleciona_movimentodiario = mysql_fetch_assoc($seleciona_movimentodiario);
}
if (isset($_GET['totalRows_seleciona_movimentodiario'])) {
  $totalRows_seleciona_movimentodiario = $_GET['totalRows_seleciona_movimentodiario'];
} else {
  $all_seleciona_movimentodiario = mysql_query($query_seleciona_movimentodiario);
  $totalRows_seleciona_movimentodiario = mysql_num_rows($all_seleciona_movimentodiario);
}
$totalPages_seleciona_movimentodiario = ceil($totalRows_seleciona_movimentodiario/$maxRows_seleciona_movimentodiario)-1;

$queryString_seleciona_movimentodiario = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_movimentodiario") == false && 
        stristr($param, "totalRows_seleciona_movimentodiario") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_movimentodiario = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_movimentodiario = sprintf("&totalRows_seleciona_movimentodiario=%d%s", $totalRows_seleciona_movimentodiario, $queryString_seleciona_movimentodiario);
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
    <th colspan="2">MOVIMENTO DIÁRIO</th>
  </tr>
  <tr>
    <td width="2175" rowspan="2"><form id="form1" name="form1" method="post" action="">
      CAMPO:
          <label>
        <select name="campo" id="campo">
          <option value="id">id</option>
          <option value="datacadastro">Data Cadastro</option>
          <option value="id_contadespesareceita">Conta Despesa/Receita</option>
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
    <th width="60">CADASTRAR</th>
  </tr>
  <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
    <td align="center" > <?php if ($cadastrarmovimentodiario == "1"){?>
    <a href="#"  onClick="displayMessage('../movimentodiario/cadastrar.php','950','600');return false"><img src="../imagens/add.png" width="20" height="20" alt="ADD" /></a>
    
    
  <?php  } else {  ?>
      <?php } ?></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellpadding="1" cellspacing="1">
      <tr>
        <th>ID</th>
        <th>DATA CADASTRO</th>
        <th>VALOR</th>
        <th>HISTORICO</th>
        <th>(+/-)CONTA DESPESA/RECEITA</th>
        <th>ALTERAR</th>
        <th>EXCLUIR</th>
      </tr>
      <?php do { ?>
      <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
        <td><?php echo $row_seleciona_movimentodiario['id']; ?></td>
        <td><?php echo databrasil($row_seleciona_movimentodiario['datacadastro']); ?></td>
        <td><?php echo $row_seleciona_movimentodiario['valor']; ?></td>
        <td><?php echo $row_seleciona_movimentodiario['historico']; ?></td>
        <td><?php if($row_seleciona_movimentodiario['tipo'] =='2'){echo "- ";}else {echo "+ ";} echo $row_seleciona_movimentodiario['contadespesareceita']; ?></td>
        <td align="center"><?php if ($alterarmovimentodiario == "1"){?>
          <a href=#  onClick="displayMessage('../movimentodiario/alterar.php?id=<?php echo $row_seleciona_movimentodiario['id']; ?>','950','600');return false"><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
           
          
          <?php  } else {  ?>
          <?php } ?>
          
          
        </td>
        <td align="center">
        
        <?php if ($excluirmovimentodiario == "1"){?>
        <a href=#  onClick="displayMessage('../movimentodiario/excluir.php?id=<?php echo $row_seleciona_movimentodiario['id']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
        
        <?php  } else {  ?>
      <?php } ?>
        </td>
      </tr>
      <?php } while ($row_seleciona_movimentodiario = mysql_fetch_assoc($seleciona_movimentodiario)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_movimentodiario > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_movimentodiario=%d%s", $currentPage, 0, $queryString_seleciona_movimentodiario); ?>"><img src="../imagens/First.png" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_movimentodiario > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_movimentodiario=%d%s", $currentPage, max(0, $pageNum_seleciona_movimentodiario - 1), $queryString_seleciona_movimentodiario); ?>"><img src="../imagens/Previous.png" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_movimentodiario < $totalPages_seleciona_movimentodiario) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_movimentodiario=%d%s", $currentPage, min($totalPages_seleciona_movimentodiario, $pageNum_seleciona_movimentodiario + 1), $queryString_seleciona_movimentodiario); ?>"><img src="../imagens/Next.png" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_movimentodiario < $totalPages_seleciona_movimentodiario) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_movimentodiario=%d%s", $currentPage, $totalPages_seleciona_movimentodiario, $queryString_seleciona_movimentodiario); ?>"><img src="../imagens/Last.png" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS :<?php echo $totalRows_seleciona_movimentodiario?></th>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_movimentodiario);
?>
