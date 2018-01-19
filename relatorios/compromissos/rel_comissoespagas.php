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
$query_seleciona_corretores = "SELECT * FROM corretores";
$seleciona_corretores = mysql_query($query_seleciona_corretores, $conn) or die(mysql_error());
$row_seleciona_corretores = mysql_fetch_assoc($seleciona_corretores);
$totalRows_seleciona_corretores = mysql_num_rows($seleciona_corretores);
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<br /><br />

<link href="../calendario/_style/default.css" rel="stylesheet" type="text/css"/>
<link href="../calendario/_style/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../calendario/_scripts/jquery.js"></script>
<script type="text/javascript" src="../calendario/_scripts/jquery.click-calendario-1.0-min.js"></script>
<script type="text/javascript" src="../calendario/_scripts/exemplo-calendario.js"></script>


<script language="javascript" src="../js/mascaras.js"></script>



<script type="text/javascript">
	$(document).ready(function(){
		$("#telefone").mask("9999-9999");
		$("#cpf").mask("999.999.999-99");
		$("#cep").mask("99999-999");
		$("#data_incial").mask("99/99/9999");
		$("#data_final").mask("99/99/9999");
		
		
		$('#data_1').focus(function(){
		$(this).calendario({
			target:'#data_1'
			});
		});
	
	$('#data_2').focus(function(){
	$(this).calendario({
		target:'#data_2'
		});
	});
	
	});
</script>

<br />

<div id="rel_clientes">
  <p>RELATÓRIO DE COMISSÕES PAGAS</p>
  <hr>
  <form id="form1" name="form1" method="post" action="../relatorios/comissoes/comissao_paisagem.php?t=pagas">
    Período :
      <label for="data_inicial"></label>
    <input type="text" name="data_inicial" id="data_1" />
  a 
  <label for="data_final"></label>
  <input type="text" name="data_final" id="data_2" />
  <br />
Corretor:
<label for="id_corretor"></label>
  <select name="id_corretor" id="id_corretor">
    <option value="">Escolha o corretor</option>
    <?php
do {  
?>
    <option value="<?php echo $row_seleciona_corretores['id']?>"><?php echo $row_seleciona_corretores['nome']?></option>
    <?php
} while ($row_seleciona_corretores = mysql_fetch_assoc($seleciona_corretores));
  $rows = mysql_num_rows($seleciona_corretores);
  if($rows > 0) {
      mysql_data_seek($seleciona_corretores, 0);
	  $row_seleciona_corretores = mysql_fetch_assoc($seleciona_corretores);
  }
?>
  </select>
  <br />
  <br />
<input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  </form>
    <br>
</div>
<?php
mysql_free_result($seleciona_corretores);
?>
