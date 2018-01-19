<?php ob_start();
?>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<div class="topo"><a href="../inicio/principal.php"><img align=left src="../imagens/home.png" width="34" height="34" /></a> SGR - Sistema de Gerenciamento de Reservas<br>
  <font size="-1"> Seja bem Vindo:</font>
<?php 
if (!isset($_SESSION)) {
  session_start();
}
$usuario_login = $_SESSION['MM_Username'];
echo $usuario_login;?>
</div>
