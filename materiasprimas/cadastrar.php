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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO materiasprimas (id, nome, id_categoria, referencia, id_marca, id_unidade,id_tamanho, estoqueminimo,  ativo,  valor) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s, %s)",
                    
					   GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nome'], "text"),                       
					   GetSQLValueString($_POST['id_categoria'], "int"),			                       
					   GetSQLValueString($_POST['referencia'], "int"),				   
                       GetSQLValueString($_POST['id_marca'], "int"),					                       
					 
                       GetSQLValueString($_POST['id_unidade'], "int"),
					   GetSQLValueString($_POST['id_tamanho'], "int"),
                       GetSQLValueString($_POST['estoqueminimo'], "text"),			                     
                       GetSQLValueString($_POST['ativo'], "text"),
					    GetSQLValueString($_POST['valor'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?pg=materiasprimas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_seleciona_cores = "SELECT * FROM cores";
$seleciona_cores = mysql_query($query_seleciona_cores, $conn) or die(mysql_error());
$row_seleciona_cores = mysql_fetch_assoc($seleciona_cores);
$totalRows_seleciona_cores = mysql_num_rows($seleciona_cores);

mysql_select_db($database_conn, $conn);
$query_seleciona_tamanhos = "SELECT * FROM tamanhos";
$seleciona_tamanhos = mysql_query($query_seleciona_tamanhos, $conn) or die(mysql_error());
$row_seleciona_tamanhos = mysql_fetch_assoc($seleciona_tamanhos);
$totalRows_seleciona_tamanhos = mysql_num_rows($seleciona_tamanhos);

mysql_select_db($database_conn, $conn);
$query_seleciona_unidades = "SELECT * FROM unidades";
$seleciona_unidades = mysql_query($query_seleciona_unidades, $conn) or die(mysql_error());
$row_seleciona_unidades = mysql_fetch_assoc($seleciona_unidades);
$totalRows_seleciona_unidades = mysql_num_rows($seleciona_unidades);

mysql_select_db($database_conn, $conn);
$query_seleciona_marcas = "SELECT * FROM marcas";
$seleciona_marcas = mysql_query($query_seleciona_marcas, $conn) or die(mysql_error());
$row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
$totalRows_seleciona_marcas = mysql_num_rows($seleciona_marcas);

mysql_select_db($database_conn, $conn);
$query_seleciona_categorias = "SELECT * FROM categorias";
$seleciona_categorias = mysql_query($query_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
$totalRows_seleciona_categorias = mysql_num_rows($seleciona_categorias);

mysql_select_db($database_conn, $conn);
$query_seleciona_setores = "SELECT * FROM setores";
$seleciona_setores = mysql_query($query_seleciona_setores, $conn) or die(mysql_error());
$row_seleciona_setores = mysql_fetch_assoc($seleciona_setores);
$totalRows_seleciona_setores = mysql_num_rows($seleciona_setores);
?>


<link rel="stylesheet" href="../funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16">CADASTRA MATERIA PRIMA :</th>
      <th width="40" class="Titulo16"><a href="#" onClick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form method="post" class="niceform" name="form1" action="<?php echo $editFormAction; ?> ">
    <table width="100%" align="center">
      <tr valign="baseline">
        <td width="17%" align="right" nowrap>NOME:</td>
        <td width="30%"><input name="nome" type="text" id="nome" value="" size="44"></td>
        <td width="14%">UNIDADE:</td>
        <td width="39%"><select name="id_unidade" id="id_unidade">
           <option value="">Escolha a unidade</option>
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_unidades['id']?>"><?php echo $row_seleciona_unidades['nome']?></option>
          <?php
} while ($row_seleciona_unidades = mysql_fetch_assoc($seleciona_unidades));
  $rows = mysql_num_rows($seleciona_unidades);
  if($rows > 0) {
      mysql_data_seek($seleciona_unidades, 0);
	  $row_seleciona_unidades = mysql_fetch_assoc($seleciona_unidades);
  }
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap>CATEGORIA:</td>
        <td><label for="id_categoria"></label>
          <select name="id_categoria" id="id_categoria">
           <option value="">Escolha a categoria</option>
           
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_categorias['id']?>"><?php echo $row_seleciona_categorias['nome']?></option>
            <?php
} while ($row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias));
  $rows = mysql_num_rows($seleciona_categorias);
  if($rows > 0) {
      mysql_data_seek($seleciona_categorias, 0);
	  $row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
  }
?>
        </select></td>
        <td>TAMANHO:</td>
        <td><label for="id_unidade">
          <select name="id_tamanho" id="id_tamanho">
           <option value="">Escolha o tamanho</option>
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_tamanhos['id']?>"><?php echo $row_seleciona_tamanhos['nome']?></option>
            <?php
} while ($row_seleciona_tamanhos = mysql_fetch_assoc($seleciona_tamanhos));
  $rows = mysql_num_rows($seleciona_tamanhos);
  if($rows > 0) {
      mysql_data_seek($seleciona_tamanhos, 0);
	  $row_seleciona_tamanhos = mysql_fetch_assoc($seleciona_tamanhos);
  }
?>
          </select>
        </label></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap>REFERÊNCIA:</td>
        <td><label for="referencia"></label>
        <input type="text" name="referencia" id="referencia" /></td>
        <td>ESTOQUE </td>
        <td><label for="id_tamanho">
          <input name="estoque" type="text" id="estoque" value="" />
        </label></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">MARCA</td>
        <td><select name="id_marca" id="id_marca">
          <option></option>
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_marcas['id']?>"><?php echo $row_seleciona_marcas['nome']?></option>
          <?php
} while ($row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas));
  $rows = mysql_num_rows($seleciona_marcas);
  if($rows > 0) {
      mysql_data_seek($seleciona_marcas, 0);
	  $row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
  }
?>
        </select></td>
        <td>ESTOQUE MIN:</td>
        <td><input type="text" name="estoqueminimo2" value="" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap>ATIVO:</td>
        <td><p>
          <label>
            <input name="ativo" type="radio" id="ativo_0" value="S" checked="checked" />
            SIM</label>
          <label>
            <input type="radio" name="ativo" value="N" id="ativo_1" />
          NÃO</label>
          <br />
        </p></td>
        <td>VALOR DE CUSTO:</td>
        <td><input name="valor" type="text" id="valor" value="" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td colspan="3"><input type="submit" value="CADASTRAR">
        <input type="button" class="btn1" onClick="closeMessage()" value="CANCELAR" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
</form>

<?php


mysql_free_result($seleciona_tamanhos);

mysql_free_result($seleciona_unidades);

mysql_free_result($seleciona_marcas);

mysql_free_result($seleciona_categorias);

mysql_free_result($seleciona_setores);
?>
