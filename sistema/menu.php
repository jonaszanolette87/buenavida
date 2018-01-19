<?php
ob_start();

//initialize the session

if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../css/estilo1.css" rel="stylesheet" type="text/css" />

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="#" class="MenuBarItemSubmenu MenuBarItemSubmenu"><img src="../imagens/icon_cadastrar.png" alt="CADASTRAR" width="22" height="20" hspace="2" align="absmiddle" />CADASTROS</a>
    <ul>
      
     

      <li><a href="../inicio/principal.php?t=clientes">CLIENTES</a></li>
     
      
       <li><a href="../inicio/principal.php?t=fornecedores">FORNECEDORES</a></li>
        <li><a href="../inicio/principal.php?t=vendedores">AGENTES DE TURISMO</a></li>
      <li><a href="../inicio/principal.php?t=produtos">PRODUTOS</a></li>
<li><a href="../inicio/principal.php?t=formasdepagamento">FORMAS DE PAGAMENTO</a></li>


      <li><a href="../inicio/principal.php?t=categorias">CATEGORIAS</a></li>

<li><a href="../inicio/principal.php?t=quartos">QUARTOS</a></li>



<li><a href="../inicio/principal.php?t=tarifas">TARIFAS</a></li>


<li><a href="../inicio/principal.php?t=reservas">RESERVAS</a></li>


<li><a href="../inicio/principal.php?t=mapa_de_reservas">MAPA DE RESERVAS</a></li>

<li><a href="../inicio/principal.php?t=usuarios">USUARIOS</a></li>
    </ul>
    <ul>
      
    </ul>
  </li>
  
  
   <li><a class="MenuBarItemSubmenu" href="#"><img src="../imagens/relatorios.gif" alt="RELATORIOS" width="20" height="20" hspace="2" align="absmiddle" />ENTRADAS E SAIDAS</a>
    <ul>
    <li><a href="../inicio/principal.php?t=compras">COMPRAS</a></li>
    <li><a href="../inicio/principal.php?t=vendas">VENDAS</a></li>
<li><a href="../inicio/principal.php?t=checkin">CHECK IN </a></li>
<li><a href="../inicio/principal.php?t=checkout">CHECK OUT</a></li>
<li><a href="../inicio/principal.php?t=remarcacoes">REMARCACOES</a></li>
<li><a href="../inicio/principal.php?t=cancelamentos">CANCELAMENTOS</a></li>
</ul>
  </li>
 
  
    <li><a class="MenuBarItemSubmenu" href="#"><img src="../imagens/relatorios.gif" alt="RELATORIOS" width="20" height="20" hspace="2" align="absmiddle" />FINANCEIRO</a>
    <ul>
<li><a href="../inicio/principal.php?t=contasareceber">CONTAS A RECEBER</a></li>
<li><a href="../inicio/principal.php?t=contasapagar">CONTAS A PAGAR</a></li>
<li><a href="../inicio/principal.php?t=movimento_diario">MOVIMENTO DIARIO</a></li>
</ul>
  </li>
  
  
   <li><a class="MenuBarItemSubmenu" href="#"><img src="../imagens/relatorios.gif" alt="RELATORIOS" width="20" height="20" hspace="2" align="absmiddle" />SUPORTE</a>
    <ul>
<li><a href="../inicio/principal.php?t=pedidos_sistema">PEDIDOS</a></li>
</ul>
  </li>
  


   <li><a class="MenuBarItemSubmenu" href="#"><img src="../imagens/relatorios.gif" alt="RELATORIOS" width="20" height="20" hspace="2" align="absmiddle" />RELATÓRIOS</a>
    <ul>
<li><a href="../inicio/principal.php?t=rel_clientes">CLIENTES</a></li>
<li><a href="../inicio/principal.php?t=rel_produtos">PRODUTOS/ESTOQUE</a></li>

<li><a href="../inicio/principal.php?t=rel_reservas">RESERVAS</a></li>
<li><a href="../inicio/principal.php?t=rel_movimentodiario">MOVIMENTO DIARIO</a></li>
<li><a href="../inicio/principal.php?t=rel_contasareceber">CONTAS A RECEBER</a></li>
<li><a href="../inicio/principal.php?t=rel_contasapagar">CONTAS A PAGAR</a></li>
<li><a href="../inicio/principal.php?t=rel_compras">COMPRAS</a></li>

<li><a href="../inicio/principal.php?t=rel_vendas">VENDAS</a></li>

</ul>
  </li>

  <li><a href="<?php echo $logoutAction ?>"><img src="../imagens/botao_fechar.png" alt="SAIR" width="20" height="20" hspace="2" align="absmiddle" />SAIR</a></li>
</ul>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
