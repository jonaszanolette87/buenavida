<?php require_once('../Connections/conn.php');

ob_start(); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1_cadusuarios")) {
  $insertSQL = sprintf("INSERT INTO usuarios (id, login, senha, email, tipousuario,hora_entrada,hora_saida) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($_POST['tipousuario'], "text"),
					   GetSQLValueString($_POST['hora_entrada'], "text"),
					    GetSQLValueString($_POST['hora_saida'], "text")
					   );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  
  //pega o ultimo codigo cadastrado
mysql_select_db($database_conn, $conn);
$result=mysql_query("SELECT max(id) FROM usuarios ") or die ("Não foi possivel encontrar codigo do ultimo usuarios cadastrado ! Motivo:".mysql_error());
$codigo = mysql_fetch_array($result);

  

  echo $codigo[0];
  $newcodigo = $codigo[0];
  
  mysql_query("INSERT INTO permissoes(id_usuario)

				VALUES 	(".$newcodigo.");") or die ("Não foi possivel criar permissoes iniciais ! motivo: ".mysql_error()) ;

//---------------------------

  $insertGoTo = "../inicio/principal.php?t=usuarios";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
      <th width="38"><img src="../imagens/usuarios2.png" width="30" height="30"></th>
      <th width="908" class="Titulo16">CADASTRA USUÁRIO:</th>
      <th width="40" class="Titulo16"><a href="#" onclick="closeMessage()"><img src="../imagens/botao_fechar.png" width="25" height="25" alt="fechar" /></a></th>
    </tr>
</table>
  <hr align="center" width="100%" style="border:0;border-top:1px dashed #CECBBD;height:1px;clear:both">
<table width="100%">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1_cadusuarios" id="form1_cadusuarios">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NOME:</td>
            <td><input type="text" name="login" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">SENHA:</td>
            <td><input type="password" name="senha" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">E-MAIL:</td>
            <td><input type="text" name="email" value="" size="44" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap">HORARIO DE TRABALHO:</td>
            <td><input type="time" name="hora_entrada" value="" size="15" id="hora_entrada" />
              a
              <input type="time" name="hora_saida" value="" size="15" id="hora_saida" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Cadastrar" />
            <input type="button" class="btn1" onclick="closeMessage()" value="Cancelar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1_cadusuarios" />
        <input type="hidden" name="tipousuario" value="S" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
