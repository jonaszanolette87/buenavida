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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE materiasprimas SET nome=%s,  id_categoria=%s, referencia=%s,id_marca=%s,
     id_unidade=%s, id_tamanho=%s, estoque=%s, estoqueminimo=%s, ativo=%s, valor=%s WHERE id=%s",
  
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['id_categoria'], "int"),
					   GetSQLValueString($_POST['referencia'], "int"),                      
                       GetSQLValueString($_POST['id_marca'], "int"),				  
                       GetSQLValueString($_POST['id_unidade'], "int"),
					   
					   GetSQLValueString($_POST['id_tamanho'], "int"),
                       GetSQLValueString($_POST['estoque'], "text"),
                       GetSQLValueString($_POST['estoqueminimo'], "text"),                     
					   GetSQLValueString($_POST['ativo'], "text"),
					    GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?pg=materiasprimas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_materiasprimas = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_materiasprimas = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_materiasprimas = sprintf("SELECT * FROM materiasprimas WHERE id = %s", GetSQLValueString($colname_seleciona_materiasprimas, "int"));
$seleciona_materiasprimas = mysql_query($query_seleciona_materiasprimas, $conn) or die(mysql_error());
$row_seleciona_materiasprimas = mysql_fetch_assoc($seleciona_materiasprimas);
$totalRows_seleciona_materiasprimas = mysql_num_rows($seleciona_materiasprimas);

mysql_select_db($database_conn, $conn);
$query_seleciona_materiasprimas_estoque = sprintf("SELECT * FROM materiasprimas_estoque WHERE id_materiaprima = %s", GetSQLValueString($colname_seleciona_materiasprimas, "int"));
$seleciona_materiasprimas_estoque = mysql_query($query_seleciona_materiasprimas_estoque, $conn) or die(mysql_error());
$row_seleciona_materiasprimas_estoque = mysql_fetch_assoc($seleciona_materiasprimas_estoque);
$totalRows_seleciona_materiasprimas_estoque = mysql_num_rows($seleciona_materiasprimas_estoque);



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
$query_seleciona_categorias = "SELECT * FROM categorias";
$seleciona_categorias = mysql_query($query_seleciona_categorias, $conn) or die(mysql_error());
$row_seleciona_categorias = mysql_fetch_assoc($seleciona_categorias);
$totalRows_seleciona_categorias = mysql_num_rows($seleciona_categorias);

mysql_select_db($database_conn, $conn);
$query_seleciona_marcas = "SELECT * FROM marcas";
$seleciona_marcas = mysql_query($query_seleciona_marcas, $conn) or die(mysql_error());
$row_seleciona_marcas = mysql_fetch_assoc($seleciona_marcas);
$totalRows_seleciona_marcas = mysql_num_rows($seleciona_marcas);

mysql_select_db($database_conn, $conn);
$query_seleciona_setores = "SELECT * FROM setores";
$seleciona_setores = mysql_query($query_seleciona_setores, $conn) or die(mysql_error());
$row_seleciona_setores = mysql_fetch_assoc($seleciona_setores);
$totalRows_seleciona_setores = mysql_num_rows($seleciona_setores);
?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16">ALTERA MATERIA PRIMA :</th>
      <th width="40" class="Titulo16"><a href="#" onClick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table width="100%" align="center">
      <tr valign="baseline">
        <td width="191" align="right" nowrap>ID:</td>
        <td colspan="3"><?php echo $row_seleciona_materiasprimas['id']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">NOME:</td>
        <td width="205"><input name="nome" type="text" id="nome" value="<?php echo htmlentities($row_seleciona_materiasprimas['nome'], ENT_COMPAT, ''); ?>" size="32"></td>
        <td width="152">UNIDADE:</td>
        <td width="682"><select name="id_unidade" id="id_unidade">
           
		  <?php
do {  
?>
          <option value="<?php echo $row_seleciona_unidades['id']?>"<?php if (!(strcmp($row_seleciona_unidades['id'], $row_seleciona_materiasprimas['id_unidade']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_unidades['nome']?></option>
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
          
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_categorias['id']?>"<?php if (!(strcmp($row_seleciona_categorias['id'], $row_seleciona_materiasprimas['id_categoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_categorias['nome']?></option>
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
          
            <?php
do {  
?>
            <option value="<?php echo $row_seleciona_tamanhos['id']?>"<?php if (!(strcmp($row_seleciona_tamanhos['id'], $row_seleciona_materiasprimas['id_tamanho']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_tamanhos['nome']?></option>
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
        <td align="right" nowrap>REFERENCIA:</td>
        <td><label for="referencia"></label>
        <input type="text" name="referencia" id="referencia" /></td>
        <td>ESTOQUE :</td>
        <td><label for="id_tamanho">
          <input type="text" name="estoque" value="<?php echo htmlentities($row_seleciona_materiasprimas['estoque'], ENT_COMPAT, ''); ?>" />
        </label></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">MARCA:</td>
        <td><select name="id_marca" id="id_marca">
          <?php
do {  
?>
          <option value="<?php echo $row_seleciona_marcas['id']?>"<?php if (!(strcmp($row_seleciona_marcas['id'], $row_seleciona_materiasprimas['id_marca']))) {echo "selected=\"selected\"";} ?>><?php echo $row_seleciona_marcas['nome']?></option>
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
        <td><input name="estoqueminimo" type="text" id="estoqueminimo" value="<?php echo htmlentities($row_seleciona_materiasprimas['estoqueminimo'], ENT_COMPAT, ''); ?>" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap>ATIVO:</td>
        <td><p>
          <label>
            <input <?php if (!(strcmp($row_seleciona_materiasprimas['ativo'],"S"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="S" id="ativo_0" />
            SIM</label>
          <label>
            <input <?php if (!(strcmp($row_seleciona_materiasprimas['ativo'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="N" id="ativo_1" />
          NÃO</label>
          <br />
        </p></td>
        <td>VALOR DE CUSTO:</td>
        <td><input name="valor" type="text" id="valor" value="<?php echo htmlentities($row_seleciona_materiasprimas['valor'], ENT_COMPAT, ''); ?>" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td colspan="3"><input type="submit" value="CADASTRAR">
        <input name="Entrar2" type="button" class="btn1" id="Entrar2" onclick="closeMessage()" value="CANCELAR" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="id" value="<?php echo $row_seleciona_materiasprimas['id']; ?>">
</form>
  <p>&nbsp;</p>
<?php
mysql_free_result($seleciona_materiasprimas);


mysql_free_result($seleciona_tamanhos);

mysql_free_result($seleciona_unidades);

mysql_free_result($seleciona_categorias);

mysql_free_result($seleciona_marcas);

mysql_free_result($seleciona_setores);
?>
