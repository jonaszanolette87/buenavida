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
  $updateSQL = sprintf("UPDATE usuarios SET login=%s, senha=%s, email=%s, hora_entrada=%s, hora_saida=%s WHERE id=%s",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($_POST['hora_entrada'], "text"),
					   GetSQLValueString($_POST['hora_saida'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
  $updateSQL2 = sprintf("UPDATE  permissoes  SET  usuarios=%s, clientes=%s, vendedores=%s, grupos=%s, categorias=%s, marcas=%s, produtos=%s, vendas=%s, destaques=%s, configuracoes=%s, fornecedores=%s, clientesinativos=%s, preco=%s, produtosdesatualizados=%s,revendas=%s, id_usuario=%s WHERE id=%s",
                      
                                       
					   GetSQLValueString($_POST['usuarios'] , "text"),
					   GetSQLValueString($_POST['clientes'], "text"),
					   GetSQLValueString($_POST['vendedores'], "text"),                       
					   GetSQLValueString($_POST['grupos'], "text"),			   
					   GetSQLValueString($_POST['categorias'] , "text"),	
					   GetSQLValueString($_POST['marcas'] , "text"),				
					   GetSQLValueString($_POST['produtos'], "text"),			
					   GetSQLValueString($_POST['vendas'], "text"),
					   GetSQLValueString($_POST['destaques'], "text"),
					   GetSQLValueString($_POST['configuracoes'], "text"),
					   GetSQLValueString($_POST['fornecedores'], "text"),
					   GetSQLValueString($_POST['clientesinativos'], "text"),
					   GetSQLValueString($_POST['preco'], "text"),
					   GetSQLValueString($_POST['produtosdesatualizados'], "text"), 
					   GetSQLValueString($_POST['revendas'], "text"),
												
					   GetSQLValueString($_POST['id_usuario'],"int"),
					   GetSQLValueString($_POST['id'], "int"));
     
	 mysql_select_db($database_conn, $conn);
	$Result2 = mysql_query($updateSQL2, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=usuarios";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_usuarios = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_usuarios = $_GET['id'];
}

$id = $_GET['id'];

mysql_select_db($database_conn, $conn);
$query_seleciona_usuarios = sprintf("SELECT * FROM usuarios WHERE id = %s", GetSQLValueString($colname_seleciona_usuarios, "int"));
$seleciona_usuarios = mysql_query($query_seleciona_usuarios, $conn) or die(mysql_error());
$row_seleciona_usuarios = mysql_fetch_assoc($seleciona_usuarios);
$totalRows_seleciona_usuarios = mysql_num_rows($seleciona_usuarios);



mysql_select_db($database_conn, $conn);
$query_permissoes = "SELECT * FROM permissoes WHERE id_usuario = '$id'";
$permissoes = mysql_query($query_permissoes, $conn) or die(mysql_error());
$row_permissoes = mysql_fetch_assoc($permissoes);
$totalRows_permissoes = mysql_num_rows($permissoes);
mysql_free_result($permissoes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <th width="40"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="712" class="Titulo16">ALTERA USUARIO:</th>
      <th width="36" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID:</td>
            <td><?php echo $row_seleciona_usuarios['id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NOME:</td>
            <td><input type="text" name="login" value="<?php echo htmlentities($row_seleciona_usuarios['login'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">SENHA:</td>
            <td><input type="password" name="senha" value="<?php echo htmlentities($row_seleciona_usuarios['senha'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">E-MAIL:</td>
            <td><input type="text" name="email" value="<?php echo htmlentities($row_seleciona_usuarios['email'], ENT_COMPAT, 'utf-8'); ?>" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">HORA DE TRABALHO:</td>
            <td><input name="hora_entrada" type="time" id="hora_entrada" value="<?php echo htmlentities($row_seleciona_usuarios['hora_entrada'], ENT_COMPAT, 'utf-8'); ?>" size="15" />
              a
              <input name="hora_saida" type="time" id="hora_saida" value="<?php echo htmlentities($row_seleciona_usuarios['hora_saida'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap"> </td>
            <td></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>
            
            
              <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $row_seleciona_usuarios['id']?>" />
    <input name="id" type="hidden" id="id_permissao" value="<?php echo $row_permissoes['id']?>" />
    <table border="0">
      <tr bgcolor="#F0F0F0">
	    <th>PERMISSÃO</th>
	    <th>CADASTRAR</th>
	    <th>ALTERAR</th>
	    <th>EXCLUIR</th>
	    <th>VISUALIZAR</th>
	    </tr>
	  <tr>
	    <td>USUÁRIOS</td>
	    <td colspan="4"><input name="usuarios" type="text" id="usuarios" value="<?php echo $row_permissoes['usuarios']?>" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td>CLIENTES</td>
	    <td colspan="4"><label for="clientes"></label>
	      <input name="clientes" type="text" id="clientes" maxlength="4" value="<?php echo $row_permissoes['clientes']?>"/></td>
	    </tr>
	  <tr>
	    <td>VENDEDORES</td>
	    <td colspan="4"><label for="vendedores"></label>
	      <input name="vendedores" type="text" id="vendedores" maxlength="4" value="<?php echo $row_permissoes['vendedores']?>" /></td>
	    </tr>
	  <tr>
	    <td>GRUPOS</td>
	    <td colspan="4"><label for="grupos"></label>
	      <input name="grupos" type="text" id="grupos" maxlength="4" value="<?php echo $row_permissoes['grupos']?>" /></td>
	    </tr>
	  <tr>
	    <td>CATEGORIAS</td>
	    <td colspan="4"><label for="categorias"></label>
	      <input name="categorias" type="text" id="categorias" maxlength="4" value="<?php echo $row_permissoes['categorias']?>" /></td>
	    </tr>
	  <tr>
	    <td>MARCAS</td>
	    <td colspan="4"><label for="marcas"></label>
	      <input name="marcas" type="text" id="marcas" maxlength="4" value="<?php echo $row_permissoes['marcas']?>"  /></td>
	    </tr>
	  <tr>
	    <td>PRODUTOS</td>
	    <td colspan="4"><label for="produtos"></label>
	      <input name="produtos" type="text" id="produtos" maxlength="4" value="<?php echo $row_permissoes['produtos']?>" /></td>
	    </tr>
	  <tr>
	    <td>VENDAS</td>
	    <td colspan="4"><input name="vendas" type="text" id="vendas" maxlength="4" value="<?php echo $row_permissoes['vendas']?>"  /></td>
	    </tr>
	  <tr>
	    <td>DESTAQUES</td>
	    <td colspan="4"><input name="destaques" type="text" id="destaques" maxlength="4" value="<?php echo $row_permissoes['destaques']?>"  /></td>
	    </tr>
	  <tr>
	    <td>CONFIGURAÇÕES</td>
	    <td colspan="4"><input name="configuracoes" type="text" id="configuracoes" maxlength="4" value="<?php echo $row_permissoes['configuracoes']?>"  /></td>
	    </tr>
	  <tr>
	    <td>FORNECEDORES</td>
	    <td colspan="4"><input name="fornecedores" type="text" id="fornecedores" maxlength="4" value="<?php echo $row_permissoes['fornecedores']?>"  /></td>
	    </tr>
	  <tr>
	    <td>CLIENTES INATIVOS</td>
	    <td colspan="4"><input name="clientesinativos" type="text" id="clientesinativos" maxlength="4" value="<?php echo $row_permissoes['clientesinativos']?>"  /></td>
	    </tr>
	  <tr>
	    <td>APAGAR PREÇO</td>
	    <td colspan="4"><input name="preco" type="text" id="preco" maxlength="1" value="<?php echo $row_permissoes['preco']?>"  /></td>
	    </tr>
	  <tr>
	    <td>PRODUTOS DESATUALIZADOS</td>
	    <td colspan="4"><input name="produtosdesatualizados" type="text" id="produtosdesatualizados" maxlength="4" value="<?php echo $row_permissoes['produtosdesatualizados']?>"  /></td>
	    </tr>
	  <tr>
	    <td>REVENDAS</td>
	    <td colspan="4"><input name="revendas" type="text" id="revendas" maxlength="4" value="<?php echo $row_permissoes['revendas']?>"  /></td>
	    </tr>
	  </table>
            
            </td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Confirmar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id_usuario" value="<?php echo $row_seleciona_usuarios['id']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_usuarios);
?>
