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
  $insertSQL = sprintf("INSERT INTO site (id, politicadeprivacidade, termosdeuso, regrasdeuso, perguntas, contrato) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['politicadeprivacidade'], "text"),
                       GetSQLValueString($_POST['termosdeuso'], "text"),
                       GetSQLValueString($_POST['regrasdeuso'], "text"),
                       GetSQLValueString($_POST['perguntas'], "text"),
                       GetSQLValueString($_POST['contrato'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../inicio/principal.php?t=site";
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

<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
<script src="../../ckeditor/sample.js" type="text/javascript"></script>
<link href="../../ckeditor/sample.css" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%">
  <tr>
    <th>PAGINAS</th>
  </tr>
  <tr>
    <td>&nbsp;
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td width="12%" align="right" nowrap="nowrap">Id:</td>
            <td width="88"><input type="text" name="id" value="" size="5" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Politica de privacidade:</td>
            <td><textarea class="ckeditor" name="politicadeprivacidade" cols="100" rows="10"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Regras de uso:</td>
            <td><textarea class="ckeditor" name="regrasdeuso" cols="100" rows="10"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Perguntas</td>
            <td><textarea class="ckeditor" name="perguntas" cols="100" rows="10"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Termos de uso:</td>
            <td><textarea class="ckeditor" name="termosdeuso" cols="100" rows="10"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">Contrato:</td>
            <td><textarea class="ckeditor" name="contrato" cols="100" rows="10"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Cadastrar" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
