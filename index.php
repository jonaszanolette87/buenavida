<?php 

ob_start();

require_once('Connections/conn.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login'])) {
  $loginUsername=$_POST['login'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "inicio/principal.php";
  $MM_redirectLoginFailed = "index.php?error=login ou senha errados ou horário do usuário  ";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conn, $conn);
  
  $LoginRS__query=sprintf("SELECT email, senha, hora_entrada,hora_saida FROM usuarios
  
   WHERE email=%s AND senha=%s AND CURTIME() Between hora_entrada AND hora_saida",
  
   GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
	mail("michel23sud@gmail.com",$loginUsername." Logou no SGR OLINE",$loginUsername." Esta logado no sistema","");
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  
	 // mail("wagnernormando@gmail.com",$loginUsername." Tentou Logar no SGR OLINE",$loginUsername." Tentativa inválida de entrar no sistema","");
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administração do Site</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	color: #FFF;
}
body {
	background-color: #FFFFFF;
}
</style>
</head>

<body>
<br />
<br />
<br />
<br />
<br />
<br />
<div id="login">
<?php if(isset($_GET['error'])) {echo "<font color=#F3070B>Usuário ou senha errado. Por Favor Tente Novamente.</font>";}?>
<form id="form1" name="formLogin" method="POST" action="<?php echo $loginFormAction; ?>">
<table width="100%">
  <tbody>
    <tr>
      <td width="63%"><h1>Seja Bem Vindo</h1></td>
      <td width="37%" rowspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td>Indentifique-se por favor para utilizar o<br />
sistema de reservas da pousada.</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>USUARIO:<br />        <input name="login" type="text" id="login2" size="44" /></td>
      </tr>
    <tr>
      <td>SENHA:<br />
  <label for="senha2">
    <input name="senha" type="password" id="senha" size="44" />
  </label></td>
      </tr>
  </tbody>
</table>
<br />
<input type="submit" name="Acessar" id="Acessar" value="ENTRAR" />
</form>
<p color=#99ff00></p>
<br />
Esqueceu sua Senha? <a href="#">Enviar Senha </a>
<script language='JavaScript' type='text/javascript'>
  document.formLogin.login.focus()
</script></div>
</body>
</html>