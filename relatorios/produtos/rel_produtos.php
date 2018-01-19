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

mysql_select_db($database_conn, $conn);
$query_seleciona_grupos = "SELECT * FROM grupos";
$seleciona_grupos = mysql_query($query_seleciona_grupos, $conn) or die(mysql_error());
$row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos);
$totalRows_seleciona_grupos = mysql_num_rows($seleciona_grupos);
?>

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<br />
<br />
<div id="rel_produtos">
  <p>RELATÓRIO DE PROUTOS</p>
  <hr>
    <br>
    
  <form id="form1" name="form1" action="../relatorios/produtos/produtos_paisagem.php?t=apagar" method="post">
  	
    GRUPOS: 
      <select name="id_grupo" id="id_grupo">
      <option value="">TODOS</option>
      <?php
do {  
?>
      <option value="<?php echo $row_seleciona_grupos['id']?>"><?php echo $row_seleciona_grupos['nome']?></option>
      <?php
} while ($row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos));
  $rows = mysql_num_rows($seleciona_grupos);
  if($rows > 0) {
      mysql_data_seek($seleciona_grupos, 0);
	  $row_seleciona_grupos = mysql_fetch_assoc($seleciona_grupos);
  }
?>
    </select>
  
    <input type="submit" name="Enviar" id="Enviar" value="Buscar" />
  </form>
  <a href="../relatorios/produtos/produtos_paisagem.php" target="_blank"><br />
  </a></div>
<?php
mysql_free_result($seleciona_grupos);
?>
