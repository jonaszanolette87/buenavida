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

$maxRows_seleciona_colaboradores = 10;
$pageNum_seleciona_colaboradores = 0;
if (isset($_GET['pageNum_seleciona_colaboradores'])) {
  $pageNum_seleciona_colaboradores = $_GET['pageNum_seleciona_colaboradores'];
}
$startRow_seleciona_colaboradores = $pageNum_seleciona_colaboradores * $maxRows_seleciona_colaboradores;

//mysql_select_db($database_conn, $conn);
//$query_seleciona_colaboradores = "SELECT * FROM colaboradores";
//$query_limit_seleciona_colaboradores = sprintf("%s LIMIT %d, %d", $query_seleciona_colaboradores, //$startRow_seleciona_colaboradores, $maxRows_seleciona_colaboradores);
//$seleciona_colaboradores = mysql_query($query_limit_seleciona_colaboradores, $conn) or die(mysql_error());
//$row_seleciona_colaboradores = mysql_fetch_assoc($seleciona_colaboradores);

//if (isset($_GET['totalRows_seleciona_colaboradores'])) {
//  $totalRows_seleciona_colaboradores = $_GET['totalRows_seleciona_colaboradores'];
//} else {
//  $all_seleciona_colaboradores = mysql_query($query_seleciona_colaboradores);
//  $totalRows_seleciona_colaboradores = mysql_num_rows($all_seleciona_colaboradores);
//}
//$totalPages_seleciona_colaboradores = ceil($totalRows_seleciona_colaboradores/$maxRows_seleciona_colaboradores)-1;

//$maxRows_seleciona_colaboradores = 10;
//$pageNum_seleciona_colaboradores = 0;
if (isset($_GET['pageNum_seleciona_colaboradores'])) {
  $pageNum_seleciona_colaboradores = $_GET['pageNum_seleciona_colaboradores'];
}
$startRow_seleciona_colaboradores = $pageNum_seleciona_colaboradores * $maxRows_seleciona_colaboradores;
if(isset($_POST['buscar']) && $_POST['buscar'] != ""){

$buscar = $_POST['buscar'];
$campo = $_POST['campo'];

mysql_select_db($database_conn, $conn);
$query_seleciona_colaboradores = "SELECT * FROM colaboradores WHERE $campo LIKE '%".$buscar."%'";
$query_limit_seleciona_colaboradores = sprintf("%s LIMIT %d, %d", $query_seleciona_colaboradores, $startRow_seleciona_colaboradores, $maxRows_seleciona_colaboradores);
$seleciona_colaboradores = mysql_query($query_limit_seleciona_colaboradores, $conn) or die(mysql_error());
$row_seleciona_colaboradores = mysql_fetch_assoc($seleciona_colaboradores);
	
	
}
else{
mysql_select_db($database_conn, $conn);
$query_seleciona_colaboradores = "SELECT * FROM colaboradores ORDER BY Nome ASC";
$query_limit_seleciona_colaboradores = sprintf("%s LIMIT %d, %d", $query_seleciona_colaboradores, $startRow_seleciona_colaboradores, $maxRows_seleciona_colaboradores);
$seleciona_colaboradores = mysql_query($query_limit_seleciona_colaboradores, $conn) or die(mysql_error());
$row_seleciona_colaboradores = mysql_fetch_assoc($seleciona_colaboradores);
}
if (isset($_GET['totalRows_seleciona_colaboradores'])) {
  $totalRows_seleciona_colaboradores = $_GET['totalRows_seleciona_colaboradores'];
} else {
  $all_seleciona_colaboradores = mysql_query($query_seleciona_colaboradores);
  $totalRows_seleciona_colaboradores = mysql_num_rows($all_seleciona_colaboradores);
}
$totalPages_seleciona_colaboradores = ceil($totalRows_seleciona_colaboradores/$maxRows_seleciona_colaboradores)-1;

$queryString_seleciona_colaboradores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_seleciona_colaboradores") == false && 
        stristr($param, "totalRows_seleciona_colaboradores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_seleciona_colaboradores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_seleciona_colaboradores = sprintf("&totalRows_seleciona_colaboradores=%d%s", $totalRows_seleciona_colaboradores, $queryString_seleciona_colaboradores);
?>


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

<table width="100%" >
  <tr>
    <th colspan="2"> <img src="../imagens/colaboradores.png" width="45" height="50" align="absmiddle" />COLABORADORES</th>
  </tr>
  <tr>
    <td width="1034" rowspan="2"><form id="form1" name="form1" method="post" action="">
        <label>
          <select name="campo" id="campo">
          <option value="ID">ID</option>
          <option value="nome" selected="selected">Nome</option>
          </select>
          <input name="buscar" type="text" id="buscar" size="50" />
        <input type="submit" name="Entrar" id="Entrar" value=".::LOCALIZAR::." />
        </label>
    </form></td>
    <th width="57">CADASTRAR</th>
  </tr>
  <tr>
    <td align="center" class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
      <?php if ($cadastrarcolaboradores == "1"){?>
      
      
       <a href="../inicio/principal.php?t=colaboradores_cadastrar&ID=<?php echo $row_seleciona_colaboradores['ID']; ?> "><img src="../imagens/add.png" width="20" height="20" alt="alt" /></a>
      
      
      
      <?php  } else {  ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" cellpadding="1" cellspacing="1">
        <tr>
          <th width="3%">ID</th>
          <th width="25%">NOME</th>
          <th width="15%">E-MAIL</th>
          <th width="16%">TELEFONE MOVEL</th>
          <th width="15%">TELEFONE RECADOS</th>
          <th width="6%">ALTERAR</th>
          <th width="6%">EXCLUIR</th>
        </tr>
        <?php do { ?>
          <tr class="claro" onmouseover="this.className='ativo';" onmouseout="this.className='claro';">
            <td><?php echo $row_seleciona_colaboradores['ID']; ?></td>
            <td><?php echo $row_seleciona_colaboradores['Nome']; ?></td>
            <td><?php echo $row_seleciona_colaboradores['Mail']; ?></td>
            <td><?php echo $row_seleciona_colaboradores['Tel_Movel']; ?></td>
            <td><?php echo $row_seleciona_colaboradores['Tel_Recados']; ?></td>
            <td align="center"><?php if ($alterarcolaboradores == "1"){?>
            
             <a href="../inicio/principal.php?t=colaboradores_alterar&ID=<?php echo $row_seleciona_colaboradores['ID']; ?> "><img src="../imagens/alterar.png" width="20" height="20" alt="alt" /></a>
            
            
            
             
              
              
              <?php  } else {  ?>
            <?php } ?></td>
            <td align="center"><?php if ($excluircolaboradores == "1"){?>
        <a href=#"  onClick="displayMessage('../colaboradores/excluir.php?ID=<?php echo $row_seleciona_colaboradores['ID']; ?>','950','600');return false"><img src="../imagens/del.png" width="20" height="20" alt="alt" /></a>
        
        
  <?php  } else {  ?>
      <?php } ?></td>
          </tr>
          <?php } while ($row_seleciona_colaboradores = mysql_fetch_assoc($seleciona_colaboradores)); ?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_seleciona_colaboradores > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_colaboradores=%d%s", $currentPage, 0, $queryString_seleciona_colaboradores); ?>"><img src="../imagens/First.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_colaboradores > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_seleciona_colaboradores=%d%s", $currentPage, max(0, $pageNum_seleciona_colaboradores - 1), $queryString_seleciona_colaboradores); ?>"><img src="../imagens/Previous.png" /></a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_seleciona_colaboradores < $totalPages_seleciona_colaboradores) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_colaboradores=%d%s", $currentPage, min($totalPages_seleciona_colaboradores, $pageNum_seleciona_colaboradores + 1), $queryString_seleciona_colaboradores); ?>"><img src="../imagens/Next.png" /></a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_seleciona_colaboradores < $totalPages_seleciona_colaboradores) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_seleciona_colaboradores=%d%s", $currentPage, $totalPages_seleciona_colaboradores, $queryString_seleciona_colaboradores); ?>"><img src="../imagens/Last.png" /></a>
          <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th colspan="2">REGISTROS:<?php echo $totalRows_seleciona_colaboradores ?></th>
  </tr>
</table>

<?php
mysql_free_result($seleciona_colaboradores);
?>
