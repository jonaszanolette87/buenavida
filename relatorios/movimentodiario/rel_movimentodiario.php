<?php require_once('../Connections/conn.php'); 

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
mysql_select_db($database_conn, $conn);
$query_seleciona_planodecontas = "SELECT * FROM planodecontas";
$seleciona_planodecontas = mysql_query($query_seleciona_planodecontas, $conn) or die(mysql_error());
$row_seleciona_planodecontas = mysql_fetch_assoc($seleciona_planodecontas);
$totalRows_seleciona_planodecontas = mysql_num_rows($seleciona_planodecontas);


?>

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />


<link href="../calendario/_style/default.css" rel="stylesheet" type="text/css"/>
<link href="../calendario/_style/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../calendario/_scripts/jquery.js"></script>
<script type="text/javascript" src="../calendario/_scripts/jquery.click-calendario-1.0-min.js"></script>
<script type="text/javascript" src="../calendario/_scripts/exemplo-calendario.js"></script>

<br />
<br />
<div id="rel_clientes">
  <p>RELATÓRIO DE MOVIMENTO DIARIO</p>
  <hr>
    <br>
    
  <form id="form1" name="form1" action="../relatorios/movimentodiario/movimentodiario_retrato.php" method="post">
    <p><br />
      PERÍODO :<br />
      <input type="text" name="data_inicial"  id="data_1" />
      a
  <label for="data_final"></label>
  <input type="text" name="data_final"  id="data_2" />
  <br />
  <br />
      CONTA :<br />
<select name="id_planodecontas">
  <option value="">NENHUM</option>
    <?php
do {  
?>
    <option value="<?php echo $row_seleciona_planodecontas['id']?>"><?php echo $row_seleciona_planodecontas['descricao']?></option>
    <?php
} while ($row_seleciona_planodecontas = mysql_fetch_assoc($seleciona_planodecontas));
  $rows = mysql_num_rows($seleciona_planodecontas);
  if($rows > 0) {
      mysql_data_seek($seleciona_planodecontas, 0);
	  $row_seleciona_planodecontas = mysql_fetch_assoc($seleciona_planodecontas);
  }
?>
</select>
    <br />
    <br />
    FORMA :
<label>
      <input name="forma" type="radio" id="forma_3" value="0" checked="checked" />
      DETALHADO</label>
    <label>
      <input type="radio" name="forma" value="3" id="forma_4" />
      AGRUPADO</label><br />
      <br />
      TIPO :
<label>
        <input name="tipo" type="radio" id="tipo_2" value="0" checked="checked" />
      TODOS</label>
      <label>
        <input type="radio" name="tipo" value="3" id="tipo_0" />
        ENTRADAS</label>
      <label>
        <input type="radio" name="tipo" value="2" id="tipo_1" />
      SAIDA</label>S
      <br />
      <br />
      
      <input type="submit" name="Enviar" id="Enviar" value=".::GERAR RELATORIO::." />
    </p>
  </form>
  <a href="../relatorios/movimentodiario/movimentodiario_paisagem.php" target="_blank"><br />
  </a></div>

