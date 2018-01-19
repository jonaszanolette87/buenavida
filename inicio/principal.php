<?php 

ob_start();
include('../Connections/conn.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<link rel="stylesheet" href="funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script>

<script type="text/javascript" src="../js/scripts.js"></script>
<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.1.4.pack.js"/></script>
 
<script type="text/javascript">
	$(document).ready(function(){
		$("#fone").mask("(99)9999-9999");
		$("#cpf").mask("999.999.999-99");
		$("#cep").mask("99.999-999");
		$("#data").mask("99/99/9999");
		$("#cnpj").mask("99.999.999/9999-99");
$("#hospede_cpf").mask("99.999.999/9999-99");
$("#hospede_cpf1").mask("99.999.999/9999-99");
$("#hospede_cpf2").mask("99.999.999/9999-99");
$("#hospede_cpf3").mask("99.999.999/9999-99");
$("#hospede_cpf4").mask("99.999.999/9999-99");
$("#hospede_cpf5").mask("99.999.999/9999-99");
$("#hospede_cpf6").mask("99.999.999/9999-99");
$("#hospede_cpf7").mask("99.999.999/9999-99");
$("#hospede_cpf8").mask("99.999.999/9999-99");
$("#hospede_cpf9").mask("99.999.999/9999-99");
		
		
	});
</script>


<?php include ("../sistema/topo.php");?>
<?php 
echo "<div>";
include ("../sistema/menu.php");
echo "</div>";

?><br />
<br />


<div id='princial'>
<?php


$usuario_login = $_SESSION['MM_Username'];
mysql_select_db($database_conn, $conn);
$query_usuarios = "SELECT * FROM usuarios WHERE email='$usuario_login'";
$usuarios = mysql_query($query_usuarios, $conn) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
$idusuario = $row_usuarios['id'];



mysql_select_db($database_conn, $conn);
$query_permissao  = "SELECT * FROM permissoes WHERE id_usuario = '$idusuario'";
$permissao = mysql_query($query_permissao, $conn) or die(mysql_error());
$row_permissao = mysql_fetch_assoc($permissao);
$totalRows_permissao = mysql_num_rows($permissao);



$visualizarusuarios = substr($row_permissao['usuarios'],3,1);
$visualizarclientes = substr($row_permissao['clientes'],3,1);
$visualizarprodutos = substr($row_permissao['produtos'],3,1);
$visualizarmarcas = substr($row_permissao['marcas'],3,1);
$visualizargrupos = substr($row_permissao['grupos'],3,1);
$visualizarcategorias = substr($row_permissao['categorias'],3,1);
$visualizarvendas = substr($row_permissao['vendas'],3,1);
$visualizarcompras = substr($row_permissao['compras'],3,1);
$visualizarvendedores = substr($row_permissao['vendedores'],3,1);
$visualizardestaques = substr($row_permissao['destaques'],3,1);
$visualizarconfiguracoes= substr($row_permissao['configuracoes'],3,1);
$visualizarfornecedores= substr($row_permissao['fornecedores'],3,1);
$visualizarclientesinativos= substr($row_permissao['clientesinativos'],3,1);
$visualizarprodutosdesatualizados= substr($row_permissao['produtosdesatualizados'],3,1);
$visualizarrevendas= substr($row_permissao['revendas'],3,1);
$visualizarhoteis= substr($row_permissao['hoteis'],3,1);
$visualizarreservas= substr($row_permissao['reservas'],3,1);
$visualizarquartos= substr($row_permissao['quartos'],3,1);
$visualizarmovimentodiario= substr($row_permissao['movimentodiario'],3,1);
$visualizarcontasareceber= substr($row_permissao['contasareceber'],3,1);
$visualizarcontasapagar= substr($row_permissao['contasapagar'],3,1);
$visualizarcolaboradores= substr($row_permissao['colaboradores'],3,1);
$visualizarcheckin= substr($row_permissao['checkin'],3,1);
$visualizarcheckout= substr($row_permissao['checkout'],3,1);
$visualizarcancelamentos= substr($row_permissao['cancelamentos'],3,1);
$visualizarremarcacoes= substr($row_permissao['remarcacoes'],3,1);
$visualizartarifas= substr($row_permissao['tarifas'],3,1);
$visualizarimoveis= substr($row_permissao['imoveis'],3,1);



$cadastrarusuarios = substr($row_permissao['usuarios'],0,1);
$cadastrarclientes = substr($row_permissao['clientes'],0,1);
$cadastrarprodutos = substr($row_permissao['produtos'],0,1);
$cadastrarmarcas = substr($row_permissao['marcas'],0,1);
$cadastrargrupos = substr($row_permissao['grupos'],0,1);
$cadastrarcategorias = substr($row_permissao['categorias'],0,1);
$cadastrarvendas = substr($row_permissao['vendas'],0,1);
$cadastrarcompras = substr($row_permissao['compras'],0,1);
$cadastrarvendedores = substr($row_permissao['vendedores'],0,1);
$cadastrardestaques = substr($row_permissao['destaques'],0,1);
$cadastrarconfiguracoes= substr($row_permissao['configuracoes'],0,1);
$cadastrarfornecedores= substr($row_permissao['fornecedores'],0,1);
$cadastrarclientesinativos= substr($row_permissao['clientesinativos'],0,1);
$cadastrarprodutosdesatualizados= substr($row_permissao['produtosdesatualizados'],0,1);
$cadastrarrevendas= substr($row_permissao['revendas'],0,1);
$cadastrarhoteis= substr($row_permissao['hoteis'],0,1);
$cadastrarreservas= substr($row_permissao['reservas'],0,1);
$apagarpreco= substr($row_permissao['preco'],0,1);
$cadastrarquartos= substr($row_permissao['quartos'],0,1);
$cadastrarmovimentodiario= substr($row_permissao['movimentodiario'],0,1);
$cadastrarcontasareceber= substr($row_permissao['contasareceber'],0,1);
$cadastrarcontasapagar= substr($row_permissao['contasapagar'],0,1);
$cadastrarcolaboradores= substr($row_permissao['colaboradores'],0,1);
$cadastrarcheckin= substr($row_permissao['checkin'],0,1);
$cadastrarcheckout= substr($row_permissao['checkout'],0,1);
$cadastrarremarcacoes= substr($row_permissao['remarcacoes'],0,1);
$cadastrarcancelamentos= substr($row_permissao['cancelamentos'],0,1);
$cadastrartarifas= substr($row_permissao['tarifas'],0,1);
$cadastrarimoveis= substr($row_permissao['imoveis'],0,1);
$cadastrarformasdepagamento= substr($row_permissao['formasdepagamento'],0,1);


$alterarusuarios = substr($row_permissao['usuarios'],1,1);
$alterarclientes = substr($row_permissao['clientes'],1,1);
$alterarprodutos = substr($row_permissao['produtos'],1,1);
$alterarmarcas = substr($row_permissao['marcas'],1,1);
$alterargrupos = substr($row_permissao['grupos'],1,1);
$alterarcategorias = substr($row_permissao['categorias'],1,1);
$alterarvendas = substr($row_permissao['vendas'],1,1);
$alterarcompras= substr($row_permissao['compras'],1,1);
$alterarvendedores = substr($row_permissao['vendedores'],1,1);
$alterardestaques = substr($row_permissao['destaques'],1,1);
$alterarconfiguracoes= substr($row_permissao['configuracoes'],1,1);
$alterarfornecedores= substr($row_permissao['fornecedores'],1,1);
$alterarclientesinativos= substr($row_permissao['clientesinativos'],1,1);
$alterarprodutosdesatualizados= substr($row_permissao['produtosdesatualizados'],1,1);
$alterarrevendas= substr($row_permissao['revendas'],1,1);
$alterarhoteis= substr($row_permissao['hoteis'],1,1);
$alterarreservas= substr($row_permissao['reservas'],1,1);
$alterarquartos= substr($row_permissao['quartos'],1,1);
$alterarmovimentodiario= substr($row_permissao['movimentodiario'],1,1);
$alterarcontasareceber= substr($row_permissao['contasareceber'],1,1);
$alterarcontasapagar= substr($row_permissao['contasapagar'],1,1);
$alterarcolaboradores= substr($row_permissao['colaboradores'],1,1);
$alterarcheckin= substr($row_permissao['checkout'],1,1);
$alterarcheckout= substr($row_permissao['checkin'],1,1);
$alterarremarcacoes= substr($row_permissao['remarcacoes'],1,1);
$alterarcancelamentos= substr($row_permissao['cancelamentos'],1,1);
$alterartarifas= substr($row_permissao['tarifas'],1,1);
$alterarimoveis= substr($row_permissao['imoveis'],1,1);
$alterarformasdepagamento= substr($row_permissao['formasdepagamento'],1,1);

$excluirusuarios = substr($row_permissao['usuarios'],2,1);
$excluirclientes = substr($row_permissao['clientes'],2,1);
$excluirprodutos = substr($row_permissao['produtos'],2,1);
$excluirmarcas = substr($row_permissao['marcas'],2,1);
$excluirgrupos = substr($row_permissao['grupos'],2,1);
$excluircategorias = substr($row_permissao['categorias'],2,1);
$excluirvendas = substr($row_permissao['vendas'],2,1);
$excluircompras= substr($row_permissao['compras'],2,1);
$excluirvendedores = substr($row_permissao['vendedores'],2,1);
$excluirdestaques = substr($row_permissao['destaques'],2,1);
$excluirconfiguracoes= substr($row_permissao['configuracoes'],2,1);
$excluirfornecedores= substr($row_permissao['fornecedores'],2,1);
$excluirclientesinativos= substr($row_permissao['clientesinativos'],2,1);
$excluirprodutosdesatualizados= substr($row_permissao['produtosdesatualizados'],2,1);
$excluirrevendas= substr($row_permissao['revendas'],2,1);
$excluirhoteis= substr($row_permissao['hoteis'],2,1);
$excluirreservas= substr($row_permissao['reservas'],2,1);
$excluirquartos= substr($row_permissao['quartos'],2,1);
$excluirmovimentodiario= substr($row_permissao['movimentodiario'],2,1);
$excluircontasapagar= substr($row_permissao['contasapagar'],2,1);
$excluircontasareceber= substr($row_permissao['contasareceber'],2,1);
$excluircolaboradores= substr($row_permissao['colaboradores'],2,1);
 $excluircheckin= substr($row_permissao['checkin'],2,1);
 $excluircheckou= substr($row_permissao['checkout'],2,1);
 $excluirremarcacoes= substr($row_permissao['remarcacoes'],2,1);
 $excluircancelamentos= substr($row_permissao['cancelamentos'],2,1);
  $excluirtarifas= substr($row_permissao['tarifas'],2,1);
   $excluirimoveis= substr($row_permissao['imoveis'],2,1);
$excluirformasdepagamento= substr($row_permissao['formasdepagamento'],2,1);

$tela = $_GET['t'];
switch ($tela) {
	
	case 'pedidos_sistema' :
		
	include('../pedidos_sistema/index.php');
	break;
	

case 'formasdepagamento' :
		
	include('../formasdepagamento/index.php');
	break;
	
	
	case 'checkin' :

	include('../checkin/index.php');
	break;
	

	case 'checkout' :

	include('../checkout/index.php');
	break;


	case 'remarcacoes' :

	include('../remarcacoes/index.php');
	break;


	case 'cancelamentos' :

	include('../cancelamentos/index.php');
	break;


	case 'checkout' :

	include('../checkout/index.php');
	break;

	
	case 'quartos' :
		
	include('../quartos/index.php');
	break;
	
	
	case 'mapa_de_reservas' :
		
	include('../mapa_de_reservas/index.php');
	break;


	case 'mapa_de_reservas_fornecedores' :
		
	include('../mapa_de_reservas_fornecedores/index.php');
	break;

	
	case 'reservas' :
		
	include('../reservas/index.php');
	break;
	
	case 'mapa_de_reservas' :
		
	include('../mapa_de_reservas/index.php');
	break;
	
 case 'colaboradores' :
	include('../colaboradores/index.php');
	break;
	
	 case 'colaboradores_cadastrar' :
	include('../colaboradores/cadastrar.php');
	break;
	
	
	 case 'colaboradores_alterar' :
	include('../colaboradores/alterar.php');
	break;
	
	case 'configuracoes' :
	include('../configuracoes/index.php');
	break;
	
	case 'contasareceber' :
		
	include('../contasareceber/index.php');
	break;
	
	
	case 'contasapagar' :
		
	include('../contasapagar/index.php');
	break;
	
	case 'movimento_diario' :

	include('../movimentodiario/index.php');
	break;
	
	
	case 'compras' :

	include('../compras/index.php');
	break;
	
	
	
	case 'vendas' :

	include('../vendas/index.php');
	break;
	
	case 'hoteis' :
		
	include('../hoteis/index.php');
	break;
		
	case 'bancos' :
		
	include('../bancos/index.php');
	break;
	
	case 'favorecidos' :
		
	include('../favorecidos/index.php');
	break;
	
	
	case 'site' :
		
	include('../paginas/index.php');
	break;
		
	case 'usuarios' :
		
	include('../usuarios/index.php');
	break;
	
	case 'vendedores' :
		
	include('../vendedores/index.php');
	break;
	
	case 'fornecedores' :
		
	include('../fornecedores/index.php');
	break;
	
	case 'grupos' :
		
	include('../grupos/index.php');
	break;
	
	
	case 'categorias' :
		
	include('../categorias/index.php');
	break;
	case 'marcas' :
		
	include('../marcas/index.php');
	break;
	
	case 'clientes' :
		
	include('../clientes/index.php');
	break;
	
	
	case 'produtos' :
		
	include('../produtos/index.php');
	break;
	
	case 'aniversariantes' :
		
	include('../aniversariantes/index.php');
	break;
	
		
	case 'destaques' :
		
	include('../destaques/index.php');
	break;
	
		
	case 'tarifas' :
		
	include('../tarifas/index.php');
	break;	
	
	
	case 'enviar_arquivo' :
		
	include('../configuracoes/enviar_arquivo.php');
	break;	
	
	
	case 'rel_clientes' :
		
	include('../relatorios/clientes/rel_clientes.php');
	break;
	
	case 'rel_compras' :
		
	include('../relatorios/compras/rel_compras.php');
	break;
	
	case 'rel_vendas' :
		
	include('../relatorios/vendas/rel_vendas.php');
	break;
	
	case 'rel_produtos' :
		
	include('../relatorios/produtos/rel_produtos.php');
	break;
	
	case 'rel_cartoes' :
		
	include('../relatorios/cartoes/rel_cartoes.php');
	break;
	
	case 'rel_compromissos' :
		
	include('../relatorios/compromissos/rel_compromissos.php');
	break;
	
	case 'rel_reservas' :
		
	include('../relatorios/reservas/rel_reservas.php');
	break;
	
	case 'rel_contasareceber' :
		
	include('../relatorios/contasareceber/rel_contasareceber.php');
	break;
	
	case 'rel_contasapagar' :
		
	include('../relatorios/contasapagar/rel_contasapagar.php');
	break;
	
	case 'rel_movimentodiario' :
		
	include('../relatorios/movimentodiario/rel_movimentodiario.php');
	break;
	case 'imoveis' :
	include('../imoveis/index.php');
	break;
	
	default:
		
	include('../inicial/compromissos.php');
	break;
	
	
	}


?>
</div>
<?php include ("../sistema/rodape.php");?>

</body>
</html>
