function formatar(src, mask)
{
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var caract = new RegExp(/^[0-9\b]+$/i);
  var texto = mask.substring(i)
if (texto.substring(0,1) != saida)
  {
        src.value += texto.substring(0,1);
  }

    var kCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    var caract = new RegExp(/^[0-9\b]+$/i);
    var caract = caract.test(String.fromCharCode(kCode));

    if(!caract){
        return false;
    }
}




documentall = document.all;
/*
* função para formatação de valores monetários retirada de
* http://jonasgalvez.com/br/blog/2003-08/egocentrismo
*/

function formatamoney(c) {
    var t = this; if(c == undefined) c = 2;
    var p, d = (t=t.split("."))[1].substr(0, c);
    for(p = (t=t[0]).length; (p-=3) >= 1;) {
	        t = t.substr(0,p) + "." + t.substr(p);
    }
    return t+","+d+Array(c+1-d.length).join(0);
}

String.prototype.formatCurrency=formatamoney

function demaskvalue(valor, currency){
/*
* Se currency é false, retorna o valor sem apenas com os números. Se é true, os dois últimos caracteres são considerados as
* casas decimais
*/
var val2 = '';
var strCheck = '0123456789';
var len = valor.length;
	if (len== 0){
		return 0.00;
	}

	if (currency ==true){
		/* Elimina os zeros à esquerda
		* a variável  <i> passa a ser a localização do primeiro caractere após os zeros e
		* val2 contém os caracteres (descontando os zeros à esquerda)
		*/

		for(var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ',')) break;

		for(; i < len; i++){
			if (strCheck.indexOf(valor.charAt(i))!=-1) val2+= valor.charAt(i);
		}

		if(val2.length==0) return "0.00";
		if (val2.length==1)return "0.0" + val2;
		if (val2.length==2)return "0." + val2;

		var parte1 = val2.substring(0,val2.length-2);
		var parte2 = val2.substring(val2.length-2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;

	}
	else{
			/* currency é false: retornamos os valores COM os zeros à esquerda,
			* sem considerar os últimos 2 algarismos como casas decimais
			*/
			val3 ="";
			for(var k=0; k < len; k++){
				if (strCheck.indexOf(valor.charAt(k))!=-1) val3+= valor.charAt(k);
			}
	return val3;
	}
}


function reais(obj,event){

var whichCode = (window.Event) ? event.which : event.keyCode;
/*
Executa a formatação após o backspace nos navegadores !document.all
*/
if (whichCode == 8 && !documentall) {
/*
Previne a ação padrão nos navegadores
*/
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	obj.value= demaskvalue(x,true).formatCurrency();
	return false;
}
/*
Executa o Formata Reais e faz o format currency novamente após o backspace
*/
FormataReais(obj,'.',',',event);
} // end reais


function backspace(obj,event){
/*
Essa função basicamente altera o  backspace nos input com máscara reais para os navegadores IE e opera.
O IE não detecta o keycode 8 no evento keypress, por isso, tratamos no keydown.
Como o opera suporta o infame document.all, tratamos dele na mesma parte do código.
*/

var whichCode = (window.Event) ? event.which : event.keyCode;
if (whichCode == 8 && documentall) {
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	var y = demaskvalue(x,true).formatCurrency();

	obj.value =""; //necessário para o opera
	obj.value += y;

	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	return false;

	}// end if
}// end backspace

function FormataReais(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;

//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown
if (whichCode == 0 ) return true;
if (whichCode == 9 ) return true; //tecla tab
if (whichCode == 13) return true; //tecla enter
if (whichCode == 16) return true; //shift internet explorer
if (whichCode == 17) return true; //control no internet explorer
if (whichCode == 27 ) return true; //tecla esc
if (whichCode == 34 ) return true; //tecla end
if (whichCode == 35 ) return true;//tecla end
if (whichCode == 36 ) return true; //tecla home

/*
O trecho abaixo previne a ação padrão nos navegadores. Não estamos inserindo o caractere normalmente, mas via script
*/

if (e.preventDefault){ //standart browsers
		e.preventDefault()
	}else{ // internet explorer
		e.returnValue = false
}

var key = String.fromCharCode(whichCode);  // Valor para o código da Chave
if (strCheck.indexOf(key) == -1) return false;  // Chave inválida

/*
Concatenamos ao value o keycode de key, se esse for um número
*/
fld.value += key;

var len = fld.value.length;
var bodeaux = demaskvalue(fld.value,true).formatCurrency();
fld.value=bodeaux;

/*
Essa parte da função tão somente move o cursor para o final no opera. Atualmente não existe como movê-lo no konqueror.
*/
  if (fld.createTextRange) {
    var range = fld.createTextRange();
    range.collapse(false);
    range.select();
  }
  else if (fld.setSelectionRange) {
    fld.focus();
    var length = fld.value.length;
    fld.setSelectionRange(length, length);
  }
  return false;

}

function clica(id,iderro){
document.getElementById(id).style.background = '';
document.getElementById(iderro).style.display = 'none';
}

function clica2(iderro){
document.getElementById(iderro).style.display = 'none';
}

function clica3(id){
document.getElementById(id).style.display = 'none';
}

function clica4(id){
document.getElementById(id).style.display = '';
}

function clica5(id){
document.getElementById(id).style.background = '';
}

function valida_1(nform){
	
if (nform.nome.value == ""){
document.getElementById('nome').style.background = '#fcc';
document.getElementById('erro1').style.display = '';
return false
}

if (nform.fone.value == ""){
document.getElementById('fone').style.background = '#fcc';
document.getElementById('erro2').style.display = '';
return false
}

if (nform.bairro.value == ""){
document.getElementById('bairro').style.background = '#fcc';
document.getElementById('erro3').style.display = '';
return false
}

if (nform.complemento.value == ""){
document.getElementById('complemento').style.background = '#fcc';
document.getElementById('erro4').style.display = '';
return false
}

if (nform.cep.value == ""){
document.getElementById('cep').style.background = '#fcc';
document.getElementById('erro5').style.display = '';
return false
}

if (nform.municipio.value == ""){
document.getElementById('municipio').style.background = '#fcc';
document.getElementById('erro6').style.display = '';
return false
}


if (nform.uf.value == ""){
document.getElementById('uf').style.background = '#fcc';
document.getElementById('erro6').style.display = '';
return false
}

if (nform.fone.value == ""){
document.getElementById('fone').style.background = '#fcc';
document.getElementById('erro7').style.display = '';
return false
}



if (nform.ie.value == ""){
document.getElementById('ie').style.background = '#fcc';
document.getElementById('erro10').style.display = '';
return false
}

if (nform.id_vendedor.value == ""){
document.getElementById('id_vendedor').style.background = '#fcc';
document.getElementById('erro11').style.display = '';
return false
}

if (nform.email.value == ""){
document.getElementById('email').style.background = '#fcc';
document.getElementById('erro12').style.display = '';
return false
}

if (nform.id_tabela.value == ""){
document.getElementById('id_tabela').style.background = '#fcc';
document.getElementById('erro13').style.display = '';
return false
}



}

function valida_2(nform){
if (nform.codigo.value == ""){
document.getElementById('codigo').style.background = '#fcc';
document.getElementById('erro3').style.display = '';
return false
}
if (nform.produto.value == ""){
document.getElementById('nome').style.background = '#fcc';
document.getElementById('erro4').style.display = '';
return false
}
if (nform.quantidade.value == ""){
document.getElementById('estoque').style.background = '#fcc';
document.getElementById('erro5').style.display = '';
return false
}
if (nform.preco.value == ""){
document.getElementById('preco').style.background = '#fcc';
document.getElementById('erro6').style.display = '';
return false
}
}

function valida_3(nform) {
	marcado = -1
	for (i=0; i<nform.opcao.length; i++) {
		if (nform.opcao[i].checked) {
			marcado = i
		}
	}
	
	if (marcado == -1) {
		document.getElementById('erro7').style.display = '';
		return false;
	} else {
		window.open('','produtos','resizable=no,height=550,width=680,toolbar=yes,location=no,directories=no,fullscreen=no,menubar=no,scrollbars=yes,status=yes')
		closeMessage()
	} 
		return true;
}

function valida_4(nform){
if (nform.vendedor.value == ""){
document.getElementById('vendedor').style.background = '#fcc';
document.getElementById('erro8').style.display = '';
return false
}
if (nform.porcentagem.value == ""){
document.getElementById('porcentagem').style.background = '#fcc';
document.getElementById('erro9').style.display = '';
return false
}
}

function valida_5(nform){
if (nform.produto.value == ""){
document.getElementById('produto').style.background = '#fcc';
return false
}
if (nform.quantidade.value == "0"){
document.getElementById('quantidade').style.background = '#fcc';
return false
}
if (nform.preco.value == ""){
document.getElementById('preco').style.background = '#fcc';
return false
}
}

function visualiza(idd)
{
var abre = 'vendas_imprimir.php?id='+idd;
window.open(abre,'venda','resizable=no,height=550,width=680,toolbar=yes,location=no,directories=no,fullscreen=no,menubar=no,scrollbars=yes,status=yes');
}

function visualizar(idd)
{
var abre = 'vendas_imprimir.php?id='+idd;
window.open(abre,'venda','resizable=no,height=550,width=680,toolbar=yes,location=no,directories=no,fullscreen=no,menubar=no,scrollbars=yes,status=yes');
closeMessage()
}


function seleciona(valor){
var quebra=valor.split('::');
document.f10.porcentagem.value = quebra[1];
}

function selecionar(valor){

var quebra=valor.split('::');
if (valor == ""){
document.f12.custo.value = '';
} else {
document.f12.custo.value = 'CUSTO: R$ '+quebra[4];
}

document.getElementById('quantidade').style.background = '';
document.getElementById('preco').style.background = '';

var c=document.getElementById("quantidade")
while(c.options.length>0)c.options[0]=null

if (quebra[3]==0){
c.options[c.options.length]=new Option([0],[0])
} else {
for(var i=1;i<=quebra[3];i++){
c.options[c.options.length]=new Option([i],[i])
}
}

}

function confirma() {
if (confirm("Confirma Remover o Ítem?"))
{
return true;
}
else
return false;
}
