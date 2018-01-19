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
  $updateSQL = sprintf("UPDATE site SET 
  pedras =%s, midia=%s, compras=%s, pagamentos=%s, privacidade=%s, 
  entrega=%s, troca=%s, garantia=%s, institucional=%s WHERE id=%s",
  
   GetSQLValueString($_POST['pedras'], "text"),
   GetSQLValueString($_POST['midia'], "text"),   
   GetSQLValueString($_POST['compras'], "text"),  
   GetSQLValueString($_POST['pagamentos'], "text"),   
   GetSQLValueString($_POST['privacidade'], "text"),
   
   GetSQLValueString($_POST['entrega'], "text"),   
   GetSQLValueString($_POST['troca'], "text"),
   GetSQLValueString($_POST['garantia'], "text"),   
   GetSQLValueString($_POST['institucional'], "text"),   
     
   
   GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "../inicio/principal.php?t=paginas";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_seleciona_paginas_site = "-1";
if (isset($_GET['id'])) {
  $colname_seleciona_paginas_site = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_seleciona_paginas_site = sprintf("SELECT * FROM site WHERE id = %s", GetSQLValueString($colname_seleciona_paginas_site, "int"));
$seleciona_paginas_site = mysql_query($query_seleciona_paginas_site, $conn) or die(mysql_error());
$row_seleciona_paginas_site = mysql_fetch_assoc($seleciona_paginas_site);
$totalRows_seleciona_paginas_site = mysql_num_rows($seleciona_paginas_site);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

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
            <td width="88%"><?php echo $row_seleciona_paginas_site['id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">INSTITUCIONAL</td>
            <td><textarea name="institucional" cols="100" rows="10" class="ckeditor" id="institucional" ><?php echo htmlentities($row_seleciona_paginas_site['institucional'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <th colspan="2" align="right" valign="middle" nowrap="nowrap">&nbsp;</th>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">PEDRAS</td>
            <td><textarea name="pedras" cols="100" rows="10" class="ckeditor" id="pedras" ><?php echo htmlentities($row_seleciona_paginas_site['pedras'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">MIDIA</td>
            <td><textarea name="midia" cols="100" rows="10" class="ckeditor" id="midia" ><?php echo htmlentities($row_seleciona_paginas_site['midia'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">COMPRAS</td>
            <td><textarea name="compras" cols="100" rows="10" class="ckeditor" id="compras" ><?php echo htmlentities($row_seleciona_paginas_site['compras'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">PAGAMENTOS</td>
            <td><textarea name="pagamentos" cols="100" rows="10" class="ckeditor" id="pagamentos" ><?php echo htmlentities($row_seleciona_paginas_site['pagamentos'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">PRIVACIDADE</td>
            <td><textarea name="privacidade" cols="100" rows="10" class="ckeditor" id="privacidade" ><?php echo htmlentities($row_seleciona_paginas_site['privacidade'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <th colspan="2" align="right" valign="middle" nowrap="nowrap">&nbsp;</th>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">ENTREGA</td>
            <td><textarea name="entrega" cols="100" rows="10" class="ckeditor" id="entrega" ><?php echo htmlentities($row_seleciona_paginas_site['entrega'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">TROCA</td>
            <td><textarea name="troca" cols="100" rows="10" class="ckeditor" id="troca" ><?php echo htmlentities($row_seleciona_paginas_site['troca'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">GARANTIA</td>
            <td><textarea name="garantia" cols="100" rows="10" class="ckeditor" id="garantia" ><?php echo htmlentities($row_seleciona_paginas_site['garantia'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="CONFIRMAR" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id" value="<?php echo $row_seleciona_paginas_site['id']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($seleciona_paginas_site);
?>
