// JavaScript Document
function confirmExclusao(url) {  
    if (confirm("Tem certeza que deseja excluir ?")) {  
       location.href=url;  
    }  
	else{
		alert("Exclusão Cancelada!");
		location.href="index.php"; 
		
	}	
 } 
    
function list_dados(valor)
{
    // Passando os dados para a página result.php através do método GET.
    http.open("GET", "../planodecontas/result.php?id=" + valor, true);
    http.onreadystatechange = handleHttpResponse;  
    http.send(null);
}

function get_sequencial(valor)
{
    // Passando os dados para a página result.php através do método GET.
    http.open("GET", "../planodecontas/sequencial.php?id=" + valor, true);
    http.onreadystatechange = handleHttpResponse2;  
    http.send(null);
}

function seleciona_grupos(valor)
{
    // Passando os dados para a página result.php através do método GET.
    http.open("GET", "../planodecontas/grupos.php?id=" + valor, true);
    http.onreadystatechange = handleHttpResponse3;  
    http.send(null);
}

function handleHttpResponse()
{
    campo_select = document.forms[0].id_subgrupo;
    if (http.readyState == 4) {
        campo_select.options.length = 0;
        results = http.responseText.split(",");
        for (var i = 0; i < results.length; i++) {
            string = results[i].split("|");
            campo_select.options[i] = new Option(string[0], string[1]);
        }  
    }
}

function handleHttpResponse2()
{
    campo = document.forms[0].sequencial;
    if (http.readyState == 4) {
        campo.options.length = 0;
        results = http.responseText.split(",");
        for (var i = 0; i < results.length; i++) {
            string = results[i].split("|");
            campo.options[i] = new Option(string[0], string[1]);
        }  
    }
}

function handleHttpResponse3()
{
    campo_select = document.forms[0].id_grupo;
    if (http.readyState == 4) {
        campo_select.options.length = 0;
        results = http.responseText.split(",");
        for (var i = 0; i < results.length; i++) {
            string = results[i].split("|");
            campo_select.options[i] = new Option(string[0], string[1]);
        }  
    }
}

// Essa função é somente para identificar o Navegador e suporte ao XMLHttpRequest.
function getHTTPObject()
{
    var req;
    try {
        if (window.XMLHttpRequest) {
            req = new XMLHttpRequest();
            if (req.readyState == null) {
                req.readyState = 1;
                req.addEventListener("load", function() {
                    req.readyState = 4;
                    if (typeof req.onReadyStateChange == "function") {
                        req.onReadyStateChange();
                    }
                }, false);  
            }
            return req; 
        }

        if (window.ActiveXObject) {
            var prefixes = ["MSXML2", "Microsoft", "MSXML", "MSXML3"];
            for (var i = 0; i < prefixes.length; i++) {
                try {
                    req = new ActiveXObject(prefixes[i] + ".XmlHttp");
                    return req;
                } catch (ex) {};
            }
        }
    } catch (ex) {}

    alert("XmlHttp Objects not supported by client browser");
}
var http = getHTTPObject();
// Logo após fazer a verificação, é chamada a função e passada 
// o valor à variável global http.

function naoPermiteAcento(e){ 
var acentos = new String('àâêôûãõáéíóúçüÀÂÊÔÛÃÕÁÉÍÓÚÇÜ'); 
var k= ""; if (e.which) { 
k = e.which; 
} 
else if (e.keyCode) 
{ 
k = e.keyCode; 
} 
var rxp = new RegExp(String.fromCharCode(k)); 
var pos = acentos.search(rxp); 
if (pos > -1) 
{ 
return false; 
} 
else 
{ 
return true; 
} 
} 

function maiuscula(valor) {
var campo=document.form1_cadcheques;
campo.nome.value=campo.nome.value.toUpperCase();
}